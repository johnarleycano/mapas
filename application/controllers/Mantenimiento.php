<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author: 	John Arley Cano Salinas
 * Fecha: 		16 de octubre de 2018
 * Programa:  	Mapas | Módulo de mantenimiento
 *            	Información relacionada al mantenimiento
 * Email: 		johnarleycano@hotmail.com
 */
class Mantenimiento extends CI_Controller {
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
        $this->load->model(array('mantenimiento_model'));
    }

	/**
     * Mapa de mediciones
     * @return [type] [description]
     */
    function mediciones()
    {
        $this->data['titulo'] = 'Mediciones';
        $this->data['filtro_superior'] = false;
        $this->data['menu'] = false;
        $this->data['contenido_principal'] = 'mantenimiento/mediciones';
        $this->load->view('core/template', $this->data);
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
                case 'mediciones':
                    // Se consulta los registros
                    $resultado = $this->mantenimiento_model->obtener($tipo, $id);
                    
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
            }
        } else {
            // Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo Mantenimiento.php */
/* Ubicación: ./application/controllers/Mantenimiento.php */