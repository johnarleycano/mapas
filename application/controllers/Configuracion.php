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
     * Carga la interfaz según sea el caso
     * 
     * @return [view] 
     */
    function cargar_interfaz(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Dependiendo del tipo
            switch ($this->input->post('tipo')) {
                case 'rango_calzadas':
                    $this->data["id_via"] = $this->input->post("id_via");
                    $this->load->view("core/menu_interno/rango_calzadas", $this->data);
                break;

                case 'rango_costados':
                    $this->load->view("core/menu_interno/rango_costados");
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
                case "calzadas":
                    print json_encode($this->configuracion_model->obtener($tipo, $id));
                break;

                case "puntos_kilometros":
                    print json_encode($this->configuracion_model->obtener($tipo, $id));
                break;

                case "tipos_costados":
                    print json_encode($this->configuracion_model->obtener($tipo, $id));
                break;

                case "vias":
                    print json_encode($this->configuracion_model->obtener($tipo, $id));
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