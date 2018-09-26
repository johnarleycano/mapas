<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author: 	John Arley Cano Salinas
 * Fecha: 		5 de septiembre de 2018
 * Programa:  	Mapas | Módulo inicial
 *            	Información inicial de los mapas
 * Email: 		johnarleycano@hotmail.com
 */
class Inicio extends CI_Controller {
	/**
     * Función constructora de la clase. Se hereda el mismo constructor 
     * de la clase para evitar sobreescribirlo y de esa manera 
     * conservar el funcionamiento de controlador.
     */
    function __construct() {
        parent::__construct();

        // Si no ha iniciado sesión, se redirige a la aplicación de configuración
        if(!$this->session->userdata('Pk_Id_Usuario')){
            redirect("sesion/cerrar");
        }
    }

	/**
     * Interfaz inicial
     * 
     * @return [void]
     */
	function index()
	{
        $this->data['titulo'] = 'Inicio';
        $this->data['titulo_mapa'] = 'Sistema de mapas - Devimed S.A.';
        $this->data['menu'] = true;
        $this->data['filtro_superior'] = true;
        $this->data['filtros'] = array();
        $this->data['contenido_principal'] = 'inicio/index';
        $this->load->view('core/template', $this->data);
	}
}
/* Fin del archivo Inicio.php */
/* Ubicación: ./application/controllers/Inicio.php */