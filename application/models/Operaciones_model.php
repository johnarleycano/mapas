<?php 
Class Operaciones_model extends CI_Model{
	function __construct() {
        parent::__construct();

        $this->db_incidentes = $this->load->database('incidentes', TRUE);
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
			case "historico_accidentes":
				$filtro = "";
                if ($id['id_sector'] || $id["id_via"]) $filtro = ($id["id_via"]) ? "WHERE h.Fk_Id_Via = {$id['id_via']}" : "WHERE Fk_Id_Sector = {$id['id_sector']}";

				$sql =
				"SELECT
					h.Pk_Id,
					h.Fk_Id_Via,
					h.Abscisa,
					X ( Coordenadas ) AS Longitud,
					Y ( Coordenadas ) AS Latitud, 
					h.Total_Accidentes 
				FROM
					dvm_historico_accidentes AS h 
					INNER JOIN configuracion.vias AS v ON h.Fk_Id_Via = v.Pk_Id
				$filtro";

		        // return $this->db_incidentes->get_compiled_select();
                return $this->db_incidentes->query($sql)->result();
			break;

			case "incidente":
				$this->db_incidentes
		        	->select(array(
			            'i.*',
			            'v.id_via_configuracion',
			            'v.nombre nombre_via_configuracion',
			            ))
		            ->from('dvm_incidente i')
		            ->join('dvm_via v', 'i.via = v.id ')
		            ->where('i.id', $id)
	            ;
		        
		        // return $this->db_configuracion->get_compiled_select(); // string de la consulta
		        return $this->db_incidentes->get()->row();
			break;

			case 'incidentes':
				$filtro = "";
                if ($id['id_sector'] || $id["id_via"]) $filtro = ($id["id_via"]) ? "AND v.id_via_configuracion = {$id['id_via']}" : "AND vc.Fk_Id_Sector = {$id['id_sector']}";

				$sql = 
				"SELECT
					i.id,
					i.abscisa,
					ta.nombre,
					i.fecha,
					v.id_via_configuracion 
				FROM
					incidentes_desarrollo.dvm_incidente AS i
					INNER JOIN incidentes_desarrollo.dvm_via AS v ON i.via = v.id
					INNER JOIN incidentes_desarrollo.dvm_tipo_atencion AS ta ON i.tipo_atencion = ta.id
					INNER JOIN configuracion.vias AS vc ON v.id_via_configuracion = vc.Pk_Id 
				WHERE
					i.fecha BETWEEN '2018-09-01' AND '2018-09-30' 
					AND i.abscisa_real <> '' 
					$filtro
				ORDER BY
					vc.Fk_Id_Sector ASC,
					v.id_via_configuracion ASC,
					i.abscisa ASC";

				// return $this->db_incidentes->get_compiled_select();
                return $this->db_incidentes->query($sql)->result();
			break;
		}
	}
}
/* Fin del archivo Operaciones_model.php */
/* Ubicación: ./application/models/Operaciones_model.php */