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
                case 'fotos_aereas':
                    // Se toma el string del perímetro y se divide en cuatro puntos
                    $id["perimetro"] = explode(',', $id["perimetro"]);
                    
                    // Se consulta los registros
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

                    print json_encode($geojson, JSON_NUMERIC_CHECK);
                break;

                case "municipios_geometria":
                    $resultado = $this->inventario_model->obtener($tipo, $id);
                    
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
                        // unset($registro->geojson);

                        array_push($geojson['features'], $feature);
                    }

                    echo json_encode($geojson, JSON_NUMERIC_CHECK);
                    // print json_encode($geojson, JSON_NUMERIC_CHECK);
                break;

                case "obras":
                    // Se toma el string del perímetro y se divide en cuatro puntos
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

                    print json_encode($geojson, JSON_NUMERIC_CHECK);
                break;

                case "senales_verticales":
                    // Se toma el string del perímetro y se divide en cuatro puntos
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
     * Mapa de fotos aéreas
     * @return [type] [description]
     */
    function fotos_aereas()
    {
        // Títulos
        $this->data['titulo'] = 'Fotos aéreas';
        $this->data['titulo_mapa'] = 'Registro fotográfico aéreo';

        // Opciones
        // $this->data['opciones'] = array("menu_superior", "menu_lateral", "menu_interno", "filtro_superior", "filtro_interno");
        $this->data['opciones'] = array("menu_superior", "menu_lateral");
        // $this->data['filtros'] = array("sectores", "vias", "costados", "anios_incidentes", "meses_incidentes", "tipos_atencion_incidentes");
        $this->data['filtros'] = array("");

        // Vistas
        $this->data['contenido_principal'] = 'inventario/recorridos/aereos';
        $this->load->view('core/template', $this->data);
    }

    /**
     * Mapa de obras de arte
     * @return [type] [description]
     */
    function obras()
    {
        // Títulos
        $this->data['titulo'] = 'Obras de arte';
        $this->data['titulo_mapa'] = 'Mantenimiento | Obras de arte';

        // Opciones
        // $this->data['opciones'] = array("menu_superior", "menu_lateral", "menu_interno", "filtro_superior", "filtro_interno");
        $this->data['opciones'] = array("menu_superior", "menu_lateral");
        // $this->data['filtros'] = array("sectores", "vias", "costados", "anios_incidentes", "meses_incidentes", "tipos_atencion_incidentes");
        $this->data['filtros'] = array("");

        // Vistas
        $this->data['contenido_principal'] = 'inventario/obras';
        $this->load->view('core/template', $this->data);
    }

    /**
     * Mapa de señalización vertical
     * @return [type] [description]
     */
    function senales_verticales()
    {
        // Títulos
        $this->data['titulo'] = 'Señalización vertical';
        $this->data['titulo_mapa'] = 'Mantenimiento | Señalización vertical';
        
        // Opciones
        // $this->data['opciones'] = array("menu_superior", "menu_lateral", "menu_interno", "filtro_superior", "filtro_interno");
        $this->data['opciones'] = array("menu_superior", "menu_lateral");
        // $this->data['filtros'] = array("sectores", "vias", "costados", "anios_incidentes", "meses_incidentes", "tipos_atencion_incidentes");
        $this->data['filtros'] = array("");

        // Vistas
        $this->data['contenido_principal'] = 'inventario/senales_verticales';
        $this->load->view('core/template', $this->data);
    }
}
/* Fin del archivo Inventario.php */
/* Ubicación: ./application/controllers/Inventario.php */