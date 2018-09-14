<?php 
Class Configuracion_model extends CI_Model{
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
			case "abscisas":
				$filtro = "";
                if ($id['id_sector'] || $id["id_via"]) $filtro = ($id["id_via"]) ? "WHERE g.Fk_Id_Via = {$id['id_via']}" : "WHERE v.Fk_Id_Sector = {$id['id_sector']}";

				$sql =
				"SELECT
					v.Nombre AS Via,
					g.Abscisa_Inicial Abscisa,
					X ( GeomFromText ( AsText ( StartPoint ( g.Shape ) ) ) ) Longitud,
					Y ( GeomFromText ( AsText ( StartPoint ( g.Shape ) ) ) ) Latitud 
				FROM
					vias_geometrias AS g
					INNER JOIN vias AS v ON g.Fk_Id_Via = v.Pk_Id 
				$filtro
				ORDER BY
					g.Abscisa_Inicial ASC";

				return $this->db->query($sql)->result();
			break;
		}
	}
}
/* Fin del archivo Configuracion_model.php */
/* Ubicación: ./application/models/Configuracion_model.php */
