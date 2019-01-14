<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author: 	John Arley Cano Salinas
 * Fecha: 		12 de septiembre de 2018
 * Programa:  	Mapas | Módulo de Operaciones
 *            	Gestión de mapas relacionados al área
 *            	de Operaciones
 * Email: 		johnarleycano@hotmail.com
 */
class Operaciones extends CI_Controller {
	/**
     * Función constructora de la clase. Se hereda el mismo constructor 
     * de la clase para evitar sobreescribirlo y de esa manera 
     * conservar el funcionamiento de controlador.
     */
    function __construct() {
        parent::__construct();

        // Carga de modelos
        $this->load->model(array('operaciones_model'));
    }

    /**
     * Actualización de registros en base de datos
     */
    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se reciben los datos por POST
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');

            // Dependiendo del tipo
            switch ($tipo) {
                case 'incidente':
                    echo $this->operaciones_model->actualizar($tipo, $this->input->post('id'), $datos);
                break;
            } // switch
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     * Carga de interfaz vía Ajax
     *     
     * @return [void]
     */
    function cargar_interfaz()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            $tipo = $this->input->post("tipo");

            switch ($tipo) {
                case "dias_mes":
                    $this->data["anio"] = $this->input->post("anio");
                    $this->data["mes"] = $this->input->post("mes");
                    $this->load->view("operaciones/eventos/dias", $this->data);
                break;

                case 'detalle_eventos':
                    $this->data["fecha"] = $this->input->post("fecha");
                    $this->load->view("operaciones/eventos/detalle", $this->data);
                break;
            }
        } else {
            // Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     * Mapa de eventos diarios
     * @return [type] [description]
     */
    function eventos_diarios()
    {
        // Títulos
        $this->data['titulo'] = 'Eventos diarios';
        $this->data['titulo_mapa'] = 'Operaciones | Control de eventos diarios';

        // Opciones
        // $this->data['opciones'] = array("menu_superior", "menu_lateral", "menu_interno", "filtro_superior", "filtro_interno");
        $this->data['opciones'] = array("menu_superior", "menu_lateral");
        // $this->data['filtros'] = array("sectores", "vias", "costados", "anios_incidentes", "meses_incidentes", "tipos_atencion_incidentes");
        $this->data['filtros'] = array("");

        // Vistas
        $this->data['contenido_principal'] = 'operaciones/eventos/index';
        $this->load->view('core/template', $this->data);
    }

    /**
     * Mapa de incidentes
     * @return [type] [description]
     */
    function dibujar_punto()
    {
        // Títulos
        $this->data['titulo'] = 'Punto';
        $this->data['titulo_mapa'] = 'Sistema de información geográfica - Devimed S.A.';

        // Opciones
        // $this->data['opciones'] = array("menu_superior", "menu_lateral", "menu_interno", "filtro_superior", "filtro_interno");
        $this->data['opciones'] = array();
        // $this->data['filtros'] = array("sectores", "vias", "costados", "anios_incidentes", "meses_incidentes", "tipos_atencion_incidentes");
        $this->data['filtros'] = array("");

        // Vistas
        $this->data['contenido_principal'] = 'operaciones/incidentes/punto';
        $this->load->view('core/template', $this->data);
    }

    /**
     * Mapa de incidentes
     * @return [type] [description]
     */
    function incidentes()
    {
        // Títulos
        $this->data['titulo'] = 'Incidentes';
        $this->data['titulo_mapa'] = 'Operaciones | Incidentes ocurridos este mes';

        // Opciones
        // $this->data['opciones'] = array("menu_superior", "menu_lateral", "menu_interno", "filtro_superior", "filtro_interno");
        $this->data['opciones'] = array("menu_superior", "menu_lateral", "filtro_superior");
        $this->data['filtros'] = array("anios_incidentes", "meses_incidentes", "tipos_atencion_incidentes");

        // Vistas
        $this->data['contenido_principal'] = 'operaciones/incidentes/index';
        $this->load->view('core/template', $this->data);
    }

    /**
     * Crea registros en base de datos
     * 
     * @return [vois]
     */
    function crear()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se reciben los datos por POST
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');

            // Dependiendo del tipo
            switch ($tipo) {
                case 'coordenada_temporal':
                    echo $this->operaciones_model->crear($tipo, $datos);
                break;                
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     * Obtiene registros de base de datos
     * y los retorna a las vistas
     * 
     * @return [vois]
     */
    function obtener()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            $tipo = $this->input->post("tipo");
            $id = $this->input->post("id");

            switch ($tipo) {
                case "accidentes_dia":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;

                case "anios_incidentes":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;
                
                case "historico_accidentes":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;
                
                case "eventos_dia":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;

                case "incidente":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;


                case "incidentes2":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;

                case "incidentes":
                    // Se consulta los registros
                    $resultado = $this->operaciones_model->obtener($tipo, $id);

                    $geojson = array(
                       'type'      => 'FeatureCollection',
                       'features'  => array()
                    );

                    foreach ($resultado as $registro) {
                        $properties = $registro;

                        $feature = array(
                             'type' => 'Feature',
                             'geometry' => array("coordinates" => array($registro->latitud, $registro->longitud), "type" => "Point"),
                             'properties' => $properties
                        );

                        array_push($geojson['features'], $feature);
                    }

                    print json_encode($geojson, JSON_NUMERIC_CHECK);
                break;

                case "meses_incidentes":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;

                case "tipos_atencion_incidente":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;
            }
        } else {
            // Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo Operaciones.php */
/* Ubicación: ./application/controllers/Operaciones.php */