<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author:     John Arley Cano Salinas
 * Fecha:       5 de septiembre de 2018
 * Programa:    Configuración | Módulo de filtros
 *              Manejo de los filtros del sistema
 * Email:       johnarleycano@hotmail.com
 */
class Filtros extends CI_Controller {
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
        // $this->load->model(array('filtros_model'));
    }

    function index(){
        echo "Conectado";
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
            	 case "costados":
	                print json_encode($this->filtros_model->obtener($tipo, $id));
	            break;

            	case "filtro":
                    print json_encode($this->filtros_model->obtener($tipo, $id));
                break;

                case "municipios_geometria":
                    $resultado = $this->filtros_model->obtener($tipo, $id);
                    
                    $geojson = array(
                       'type'      => 'FeatureCollection',
                       'features'  => array()
                    );

                    foreach ($resultado as $registro) {
                        if($registro->Poligono){
                            $feature = array(
                                 'type' => 'Feature',
                                 'geometry' => json_decode($this->wkb_to_json($registro->Poligono)),
                                 'properties' => $registro
                            );
                            unset($registro->Poligono);

                            array_push($geojson['features'], $feature);
                        }
                    }

                    echo json_encode($geojson, JSON_NUMERIC_CHECK);
                break;

	            case "vias":
	                print json_encode($this->filtros_model->obtener($tipo, $id));
	            break;

                case "vias_geometria":
			        $geojson = array(
			           'type'      => 'FeatureCollection',
			           'features'  => array()
			        );

			        foreach ($this->filtros_model->obtener("vias_geometrias", $id) as $registro) {
			            $feature = array(
			                 'type' => 'Feature',
			                 'geometry' => json_decode($this->wkb_to_json($registro->wkb)),
			                 'properties' => $registro
			            );

			            unset($registro->wkb);
			            unset($registro->Shape);
			            
			            array_push($geojson['features'], $feature);

			        }

					echo json_encode($geojson, JSON_NUMERIC_CHECK);
                break;
            }
        } else {
            // Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo Filtros.php */
/* Ubicación: ./application/controllers/Filtros.php */