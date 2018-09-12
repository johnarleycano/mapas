<?php 
Class Filtros_Model extends CI_Model{
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
     * @param  [int]    $id   Id foráneo para filtrar los datos
     * 
     * @return [array]       Arreglo de datos
     */
    function obtener($tipo, $id = null)
    {
        switch ($tipo) {
            case "costados":
                $this->db_configuracion
                    ->select(array(
                        'c.Pk_Id',
                        'tc.Codigo',
                        'tc.Nombre',
                        ))
                    ->from('costados c')
                    ->join('tipos_costados tc', 'c.Fk_Id_Tipo_Costado = tc.Pk_Id')
                    ->where('c.Fk_Id_Via', $id)
                    ->order_by('Orden')
                ;
                
                // return $this->db_configuracion->get_compiled_select(); // string de la consulta
                return $this->db_configuracion->get()->result();
            break;
        
            case "sectores":
				return $this->db_configuracion
					->order_by("Codigo")
					->get("sectores")->result();
			break;

            case "vias":
                if ($id) $this->db_configuracion->where("Fk_Id_Sector", $id);
                
                return $this->db_configuracion
                    ->order_by("Abscisa_Inicial")
                    ->get("vias")
                    ->result();
            break;

            case "vias_geometrias":
                    $filtro = "";
                if ($id['id_sector'] || $id["id_via"]) $filtro = ($id["id_via"]) ? "WHERE g.Fk_Id_Via = {$id['id_via']}" : "WHERE vias.Fk_Id_Sector = {$id['id_sector']}";
                
                $sql =
                "SELECT
                    g.Pk_Id,
                    g.Shape,
                    g.Fk_Id_Via,
                    g.Abscisa_Inicial,
                    g.Abscisa_Final,
                    AsWKB ( g.Shape ) AS wkb
                FROM
                    vias_geometrias AS g
                INNER JOIN vias ON g.Fk_Id_Via = vias.Pk_Id 
                    $filtro";

                return $this->db->query($sql)->result();
            break;
        }
    }
}
/* Fin del archivo Filtros_Model.php */
/* Ubicación: ./application/models/Filtros_Model.php */