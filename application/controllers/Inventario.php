<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author: 	John Arley Cano Salinas
 * Fecha: 		21 de septiembre de 2018
 * Programa:  	Mapas | Módulo de inventario
 *            	Información relacionada a los mapas del
 *            	área de mantenimiento, para el caso de
 *              inventario
 * Email: 		johnarleycano@hotmail.com
 */
class Inventario extends CI_Controller {
	/**
     * Función constructora de la clase. Se hereda el mismo constructor 
     * de la clase para evitar sobreescribirlo y de esa manera 
     * conservar el funcionamiento de controlador.
     */
    function __construct() {
        parent::__construct();

        // Carga de modelos
        $this->load->model(array('inventario_model'));
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
                case "senales_verticales":
                    $id["perimetro"] = explode(',', $id["perimetro"]);
                    
                    $resultado = $this->inventario_model->obtener($tipo, $id);
                    
                    $geojson = array(
                       'type'      => 'FeatureCollection',
                       'features'  => array()
                    );

                    foreach ($resultado as $registro) {
                        $properties = $registro;

                        // unset($properties->geojson);
                        // unset($properties->geom);


                        $feature = array(
                             'type' => 'Feature',
                             'geometry' => json_decode($registro->geojson, true),
                             'properties' => $properties
                        );

                        array_push($geojson['features'], $feature);

                    }
                    // echo json_encode($geojson, JSON_NUMERIC_CHECK);

                    print json_encode($geojson, JSON_NUMERIC_CHECK);
                    // echo json_encode($geojson, JSON_NUMERIC_CHECK);
                break;
            }
        } else {
            // Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     * Mapa de señalización vertical
     * @return [type] [description]
     */
    function senales_verticales()
    {
        $this->data['titulo'] = 'Señalización vertical';
        $this->data['filtro_superior'] = true;
        $this->data['menu'] = true;
        $this->data['contenido_principal'] = 'inventario/senales_verticales';
        $this->load->view('core/template', $this->data);
    }
}
/* Fin del archivo Inventario.php */
/* Ubicación: ./application/controllers/Inventario.php */