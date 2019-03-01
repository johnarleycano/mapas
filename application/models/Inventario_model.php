<?php 
Class Inventario_model extends CI_Model{
	function __construct() {
        parent::__construct();

        $this->db_inventario = $this->load->database('inventario', TRUE);
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
			case 'fotos_aereas':
				$this->db_inventario
                    ->select("*")
                    ->select("PUBLIC.ST_AsGeoJSON ( PUBLIC.ST_Transform (( geom ), 4326 ), 6 ) geojson")
                    ->from("RecorridosDron")
					->where("PUBLIC.ST_Transform ( geom, 4326 ) && PUBLIC.ST_SetSRID ( PUBLIC.ST_MakeBox2D ( PUBLIC.ST_Point ( {$id['perimetro'][0]}, {$id['perimetro'][1]} ), PUBLIC.ST_Point ( {$id['perimetro'][2]}, {$id['perimetro'][3]} )), 4326 )")
					->where("secuencia", $id["secuencia"])
					->where("via", $id["via"])
                ;

                return $this->db_inventario->get()->result();
			break;

			case 'fotos_aereas_fecha_comun':
				$this->db_inventario
                    ->select(array(
                    	'count(rd."Date") total_fotos',
                    	"rd.Date valor",
                    ))
                    ->where($id)
                    ->group_by("rd.secuencia")
                    ->group_by("rd.Date")
                    ->order_by("rd.secuencia", "DESC")
                    ->order_by("total_fotos", "DESC")
                    ->from("RecorridosDron rd")
                    ->limit(1)
                ;

				// return $this->db_inventario->get_compiled_select();
                return $this->db_inventario->get()->row();
			break;

			case 'fotos_aereas_secuencias':
				$this->db_inventario
                    ->select("rd.secuencia")
                    ->from("RecorridosDron rd")
                    ->where($id)
                    ->order_by("rd.secuencia", "DESC")
                    ->group_by("rd.secuencia")
                    ->limit(4)
                ;

				// return $this->db_inventario->get_compiled_select();
                return $this->db_inventario->get()->result();
			break;

            case "municipios_geometria":
                $this->db_inventario
                    ->select("id")
                    ->select("PUBLIC.ST_AsGeoJSON ( PUBLIC.ST_Transform (( geom ), 4326 ), 6 ) geojson")
                    ->from("Municipios")
                ;

                return $this->db_inventario->get()->result();
            break;

			case "obras":
				// if($id["id_via"]) $this->db_inventario->where("id_vias", $id["id_via"]);

				$this->db_inventario
					->select("*")
					->select("PUBLIC.ST_AsGeoJSON ( PUBLIC.ST_Transform (( geom ), 4326 ), 6 ) geojson")
					->from("Obras")
					->where("PUBLIC.ST_Transform ( geom, 4326 ) && PUBLIC.ST_SetSRID ( PUBLIC.ST_MakeBox2D ( PUBLIC.ST_Point ( {$id['perimetro'][0]}, {$id['perimetro'][1]} ), PUBLIC.ST_Point ( {$id['perimetro'][2]}, {$id['perimetro'][3]} )), 4326 )")
					// ->where("id_vias", 3)
					;

		        return $this->db_inventario->get()->result();
			break;

			case "senales_verticales":
				if($id["id_via"]) $this->db_inventario->where("id_vias", $id["id_via"]);

				$this->db_inventario
					->select("*")
					->select("PUBLIC.ST_AsGeoJSON ( PUBLIC.ST_Transform (( geom ), 4326 ), 6 ) geojson")
					->from("SeñalesVerticales")
					->where("PUBLIC.ST_Transform ( geom, 4326 ) && PUBLIC.ST_SetSRID ( PUBLIC.ST_MakeBox2D ( PUBLIC.ST_Point ( {$id['perimetro'][0]}, {$id['perimetro'][1]} ), PUBLIC.ST_Point ( {$id['perimetro'][2]}, {$id['perimetro'][3]} )), 4326 )")
					// ->where("id_vias", 3)
					;

		        return $this->db_inventario->get()->result();
			break;
		}
	}
}
/* Fin del archivo Inventario_model.php */
/* Ubicación: ./application/models/Inventario_model.php */