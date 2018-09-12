<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author: 	John Arley Cano Salinas
 * Fecha: 		5 de septiembre de 2018
 * Programa:  	Mapas | Módulo de configuración
 *            	Información relacionada a la configuración
 * Email: 		johnarleycano@hotmail.com
 */
class Configuracion extends CI_Controller {
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
        $this->load->model(array('configuracion_model'));
    }

    function wkb_to_json($wkb) {
        $geom = geoPHP::load($wkb,'wkb');
        return $geom->out('json');
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
                case "vias_geometria":
     //                // Build GeoJSON feature collection array
			  //       $geojson = array(
			  //          'type'      => 'FeatureCollection',
			  //          'features'  => array()
			  //       );

			  //       foreach ($this->configuracion_model->obtener("vias_geometrias", $id) as $registro) {
			  //           $feature = array(
			  //                'type' => 'Feature',
			  //                'geometry' => json_decode($this->wkb_to_json($registro->wkb)),
			  //                'properties' => $registro
			  //           );

			  //           unset($registro->wkb);
			  //           unset($registro->Shape);
			  //           # Add feature arrays to feature collection array
			  //           array_push($geojson['features'], $feature);

			  //       }

					// echo json_encode($geojson, JSON_NUMERIC_CHECK);
                break;
            }
        } else {
            // Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo Configuracion.php */
/* Ubicación: ./application/controllers/Configuracion.php */