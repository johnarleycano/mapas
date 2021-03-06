<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author: 	John Arley Cano Salinas
 * Fecha: 		16 de noviembre de 2018
 * Programa:  	Mapas | Módulo de Mediciones
 *            	Gestión de mapas relacionados a
 *            	las mediciones realizadas por las
 *            	diferentes áreas
 * Email: 		johnarleycano@hotmail.com
 */
class Mediciones extends CI_Controller {
	/**
     * Función constructora de la clase. Se hereda el mismo constructor 
     * de la clase para evitar sobreescribirlo y de esa manera 
     * conservar el funcionamiento de controlador.
     */
    function __construct() {
        parent::__construct();

        // Librería GeoPHP
        include_once('system/libraries/geoPHP.inc');

        // Carga de modelos
        $this->load->model(array('mediciones_model'));
    }

    /**
     * Mapa de mediciones de rocería
     * y cunetas
     * 
     * @return [type] [description]
     */
    function roceria_cuneta()
    {
        // Títulos
        $this->data['titulo'] = 'Rocería y cunetas';
        $this->data['titulo_mapa'] = 'Medición';

        // Opciones
        // $this->data['opciones'] = array("menu_superior", "menu_lateral", "menu_interno", "filtro_superior", "filtro_interno");
        $this->data['opciones'] = array("");
        // $this->data['filtros'] = array("sectores", "vias", "costados", "anios_incidentes", "meses_incidentes", "tipos_atencion_incidentes");
        $this->data['filtros'] = array("");

        // Vistas
        $this->data['contenido_principal'] = 'mediciones/roceria_cuneta';
        $this->load->view('core/template', $this->data);
    }

    /**
     * Mapa de señalización horizontal
     * y cunetas
     * 
     * @return [type] [description]
     */
    function senales_horizontales()
    {
        // Títulos
        $this->data['titulo'] = 'Señalización horizontal promedio';
        $this->data['titulo_mapa'] = 'Señalización horizontal promedio';

        // Opciones
        // $this->data['opciones'] = array("menu_superior", "menu_lateral", "menu_interno", "filtro_superior", "filtro_interno");
        $this->data['opciones'] = array("menu_superior", "menu_lateral", "menu_interno", "filtro_superior", "filtro_interno");
        // $this->data['filtros'] = array("sectores", "vias", "costados", "anios_incidentes", "meses_incidentes", "tipos_atencion_incidentes");
        $this->data['filtros'] = array("sectores", "vias");

        // Vistas
        $this->data['contenido_principal'] = 'mediciones/senales_horizontales/index';
        $this->load->view('core/template', $this->data);
    }

    /**
     * Carga la interfaz según sea el caso
     * 
     * @return [view] 
     */
    function cargar_interfaz(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Dependiendo del tipo
            switch ($this->input->post('tipo')) {
                case 'rango_fechas_senales_horizontales':
                    $this->data["datos"] = $this->input->post("datos");
                    $this->load->view("mediciones/senales_horizontales/rango_fechas", $this->data);
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
                case 'roceria_cuneta':
                    // Se consulta los registros
                    $resultado = $this->mediciones_model->obtener($tipo, $id);
                    
                    $geojson = array(
                       'type'      => 'FeatureCollection',
                       'features'  => array()
                    );

                    // Recorrido de los registros
                    foreach ($resultado as $registro) {
                    	$geom = geoPHP::load($registro->wkb,'wkb');

			            $feature = array(
			                 'type' => 'Feature',
			                 'geometry' => json_decode($geom->out('json')),
			                 'properties' => $registro
			            );

			            unset($registro->wkb);
			            
			            array_push($geojson['features'], $feature);
			        }

                    print json_encode($geojson, JSON_NUMERIC_CHECK);
                break;

                case 'senales_horizontales':
                    $resultado = $this->mediciones_model->obtener($tipo, $id);
                    
                    $geojson = array(
                       'type'      => 'FeatureCollection',
                       'features'  => array()
                    );

                    foreach ($resultado as $registro) {
                        $properties = $registro;
                        $feature = array(
                             'type' => 'Feature',
                             'geometry' => json_decode($registro->geojson, true),
                             'properties' => $registro
                        );

                        array_push($geojson['features'], $feature);
                    }

                    print json_encode($geojson, JSON_NUMERIC_CHECK);
            	break;

                case 'senales_horizontales_fecha_comun':
                    print json_encode($this->mediciones_model->obtener($tipo, $id));
                break;

                case 'senales_horizontales_secuencias':
                    print json_encode($this->mediciones_model->obtener($tipo, $id));
                break;
            }
        } else {
            // Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo Mediciones.php */
/* Ubicación: ./application/controllers/Mediciones.php */