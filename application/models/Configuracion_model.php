<?php 
Class Configuracion_model extends CI_Model{
	function __construct() {
        parent::__construct();

        /*
         * db_configuracion es la conexion a los datos de configuración de la aplicación, como lo son los sectores, vías,
         * tramos, entre otros.
         * Esta se llama porque en el archivo database.php la variable ['configuracion']['pconnect] esta marcada como false,
         * lo que quiere decir que no se conecta persistentemente sino cuando se le invoca, como en esta ocasión.
         */
        $this->db_configuracion = $this->load->database('configuracion', TRUE);
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
			case "aplicacion":
                return $this->db->where("Pk_Id", $id)->get("aplicaciones")->row();
            break;

            case "calzadas":
				// if ($id) $this->db_configuracion->where("Fk_Id_Sector", $id);
				return $this->db_configuracion
					->select(array(
						"Tipo Pk_Id",
						"Tipo Nombre",
					))
					->where("Fk_Id_Via", $id)
					->get("calzadas")
					->result();
			break;

			case "puntos_kilometros":
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

			case "tipos_costados":
				return $this->db_configuracion
					->select(array(
						"Nombre Pk_Id",
						"Nombre",
					))
					->order_by("Orden")
					->get("tipos_costados")->result();
			break;

            case "vias":
				return $this->db_configuracion
					->where("Fk_Id_Sector", $id)
					->get("vias")
					->result();
			break;
		}
	}
}
/* Fin del archivo Configuracion_model.php */
/* Ubicación: ./application/models/Configuracion_model.php */