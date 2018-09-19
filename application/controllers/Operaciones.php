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
                case "historico_accidentes":
                	$this->load->view("operaciones/index");
                break;
            }
        } else {
            // Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
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
                case "historico_accidentes":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;

                case "incidentes":
                	print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;
            }
        } else {
            // Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    /**
     * Mapa de incidentes
     * @return [type] [description]
     */
    function incidentes()
    {
        $this->data['titulo'] = 'Incidentes';
        $this->data['contenido_principal'] = 'operaciones/incidentes/index';
        $this->load->view('core/template', $this->data);
    }
}
/* Fin del archivo Operaciones.php */
/* Ubicación: ./application/controllers/Operaciones.php */