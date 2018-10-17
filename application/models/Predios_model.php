<?php 
Class Predios_model extends CI_Model{
	function __construct() {
        parent::__construct();

        $this->db_predios = $this->load->database('predios', TRUE);
    }

    /**
	 * Obtiene registros de base de datos
	 * y los retorna a las vistas
	 * 
	 * @param  [string] 	$tipo 	Tipo de consulta que va a hacer
	 * @param  [int] 		id   	Id foráneo para filtrar los datos
	 * 
	 * @return [array]      Arreglo de datos
	 */
	function obtener($tipo, $id = null, $adicional = null)
	{
		switch ($tipo) {
			case 'listado':
				$sql = 
				"SELECT
					p.ficha_predial,
					AsWKB ( p.coordenadas ) AS Coordenadas,
					-- i.municipio 
				FROM
					tbl_predio AS p
					-- INNER JOIN tbl_identificacion AS i ON i.ficha_predial = p.ficha_predial 
				WHERE
					AsWKB ( p.coordenadas ) IS NOT NULL";

				// return $this->db_predios->get_compiled_select();
                return $this->db_predios->query($sql)->result();
			break;
		}
	}
}
/* Fin del archivo Predios_model.php */
/* Ubicación: ./application/models/Predios_model.php */