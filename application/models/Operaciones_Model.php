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
		}
	}
}
/* Fin del archivo Operaciones_model.php */
/* Ubicación: ./application/models/Operaciones_model.php */