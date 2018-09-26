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
     * Mapa de incidentes
     * @return [type] [description]
     */
    function incidente()
    {
        $this->data['titulo'] = 'Punto';
        $this->data['filtro_superior'] = false;
        $this->data['menu'] = false;
        $this->data['contenido_principal'] = 'operaciones/incidentes/punto';
        $this->load->view('core/template', $this->data);
    }

    /**
     * Mapa de incidentes
     * @return [type] [description]
     */
    function incidentes()
    {
        $this->data['titulo'] = 'Incidentes';
        $this->data['titulo_mapa'] = 'Operaciones | Incidentes ocurridos este mes';
        $this->data['filtro_superior'] = true;
        $this->data['menu'] = true;
        $this->data['filtros'] = array("tipos_atencion" => true);
        $this->data['contenido_principal'] = 'operaciones/incidentes/index';
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
                case "historico_accidentes":
                    print json_encode($this->operaciones_model->obtener($tipo, $id));
                break;

                case "incidente":
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
}
/* Fin del archivo Operaciones.php */
/* Ubicación: ./application/controllers/Operaciones.php */