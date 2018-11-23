<?php 
Class Mediciones_model extends CI_Model{
	function __construct() {
        parent::__construct();

        $this->db_inventario = $this->load->database('inventario', TRUE);
        $this->db_mantenimiento = $this->load->database('mantenimiento', TRUE);
    }

	/**
	 * Obtiene registros de base de datos
	 * y los retorna a las vistas
	 * 
	 * @param  [string] $tipo Tipo de consulta que va a hacer
	 * @param  [int] 	$id   Id foráneo para filtrar los datos
	 * 
	 * @return [array]       Arreglo de datos
	 */
	function obtener($tipo, $id = null, $adicional = null)
	{
		switch ($tipo) {
			case 'roceria_cuneta':
				$sql = 
				"SELECT
					DATE(d.Fecha) Fecha,
					TIME(d.Fecha) Hora,
					d.Factor_Externo,
					d.Abscisa,
					AsWKB (
					(
				SELECT
					c.Shape 
				FROM
					configuracion.vias_geometrias AS c 
				WHERE
					c.Fk_Id_Via = m.Fk_Id_Via 
					AND c.Abscisa_Inicial = d.Abscisa 
					) 
					) AS wkb,
					d.Calificacion,
					(
				SELECT
					CONCAT( c.Color_R, ', ', c.Color_G, ', ', c.Color_B ) Color 
				FROM
					valores_calificaciones AS c 
				WHERE
					c.Valor = d.Calificacion 
				ORDER BY
					c.Estado DESC 
					LIMIT 0,
					1 
					) Color 
				FROM
					mediciones_detalle AS d
					INNER JOIN mediciones AS m ON d.Fk_Id_Medicion = m.Pk_Id 
				WHERE
					d.Fk_Id_Medicion = {$id['Fk_Id_Medicion']} 
					AND d.Fk_Id_Tipo_Medicion = {$id['Fk_Id_Tipo_Medicion']} 
					AND d.Fk_Id_Costado = {$id['Fk_Id_Costado']}  
				ORDER BY
					d.Abscisa ASC";

				// return $this->db_incidentes->get_compiled_select();
                return $this->db_mantenimiento->query($sql)->result();
			break;

			case "senales_horizontales":
				$this->db_inventario
					->select(array(
						'AVG(sh.medición) promedio',
						'sh.entero',
						'sh.color',
						'ST_AsGeoJSON (public.ST_Transform(((SELECT v.geom FROM "public"."VIAS" AS v WHERE v.id_via = sh.id_via AND v.desde = sh.entero)), 4326), 6) geojson',
					))
                    ->from("SeñalesHorizontales sh")
                    ->join('"public"."VIAS"', 'sh.via = "public"."VIAS"."id"')
                    ->where(array(
                    	"sh.via" => $id["via"],
                    	"sh.calzada" => $id["calzada"],
                    	"sh.costado" => $id["costado"],
						"sh.fechainspe" => $id["fechainspe"],
                    ))
                    ->order_by("sh.entero")
                    ->group_by(array(
                    	"sh.entero",
                    	"geojson",
                    	"sh.color",
                    ))
                ;

                return $this->db_inventario->get()->result();
				// return $this->db_inventario->get_compiled_select();
			break;

			case 'senales_horizontales_fechas':
				$this->db_inventario
                    ->select("sh.fechainspe")
                    ->where($id)
                    ->group_by("sh.fechainspe")
                    ->order_by("sh.fechainspe")
                    ->from("SeñalesHorizontales sh")
                    ->limit(6)
                ;

                return $this->db_inventario->get()->result();
			break;
		}
	}
}
/* Fin del archivo Mediciones_model.php */
/* Ubicación: ./application/models/Mediciones_model.php */