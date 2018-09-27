<?php 
Class Operaciones_model extends CI_Model{
	function __construct() {
        parent::__construct();

        $this->db_incidentes = $this->load->database('incidentes', TRUE);
    }

    /**
	 * Actualización en base de datos base de datos
	 * @param  string $tipo Tipo de dato
	 * @param  int $id   Identificador
	 * @return array       Datos
	 */
	function actualizar($tipo, $id, $datos){
		// Según el tipo
		switch ($tipo) {
			case 'incidente':
				return $this->db_incidentes
					->where("id",$id)
					->set("coordenadas","geomfromtext('POINT({$datos['longitud']} {$datos['latitud']})')",false)
					->update("dvm_incidente");
			break;
		}
	}

	/**
	 * Obtiene registros de base de datos
	 * y los retorna a las vistas
	 * 
	 * @param  [string] $tipo Tipo de consulta que va a hacer
	 * @param  [int] 	$id   Id foráneo para filtrar los datos
	 * 
	 * @return [array]       Arreglo de datos
	 */
	function obtener($tipo, $id = null, $adicional = null)
	{
		switch ($tipo) {
			case "anios_incidentes":
				$this->db_incidentes
		        	->select(array(
			            'YEAR(i.fecha) Numero',
			            ))
		            ->group_by('Numero')
		            ->order_by('Numero', 'DESC')
		            ->from('dvm_incidente i')
	            ;
		        
		        // return $this->db_incidentes->get_compiled_select(); // string de la consulta
		        return $this->db_incidentes->get()->result();
			break;

			case "incidente":
				$this->db_incidentes
		        	->select(array(
			            'i.abscisa',
			            'i.abscisa_real',
			            'i.informado_por_nombre',
			            'i.fecha',
			            'v.id_via_configuracion',
			            'v.nombre nombre_via_configuracion',
			            ))
		            ->from('dvm_incidente i')
		            ->join('dvm_via v', 'i.via = v.id ')
		            ->where('i.id', $id)
	            ;
		        
		        // return $this->db_incidentes->get_compiled_select(); // string de la consulta
		        return $this->db_incidentes->get()->row();
			break;

			case 'incidentes':
				$filtro = "";
                if ($id['id_sector'] || $id["id_via"]) $filtro = ($id["id_via"]) ? "AND v.id_via_configuracion = {$id['id_via']}" : "AND vc.Fk_Id_Sector = {$id['id_sector']}";
                $filtro_tipo_atencion = ($id['id_tipo_atencion']) ? "AND i.tipo_atencion = {$id['id_tipo_atencion']}" : "" ;

				$sql = 
				"SELECT
					i.id,
					i.abscisa,
					i.abscisa_real,
					ta.nombre,
					i.fecha,
					v.id_via_configuracion,
					X ( i.coordenadas ) AS latitud,
					Y ( i.coordenadas ) AS longitud 
				FROM
					dvm_incidente AS i
					LEFT JOIN dvm_via AS v ON i.via = v.id
					LEFT JOIN dvm_tipo_atencion AS ta ON i.tipo_atencion = ta.id 
				WHERE
					i.coordenadas IS NOT NULL 
					AND YEAR(i.fecha ) = {$id['anio']}
					AND MONTH(i.fecha ) = {$id['mes']}
					$filtro
					$filtro_tipo_atencion";

				// return $this->db_incidentes->get_compiled_select();
                return $this->db_incidentes->query($sql)->result();
			break;

			case "meses_incidentes":
				$this->db_incidentes
		        	->select(array(
			            'LPAD(MONTH(i.fecha), 2, 0) Numero',
			            ))
		            ->group_by('Numero')
		            ->where('YEAR(i.fecha)', $id)
		            ->order_by('Numero')
		            // ->order_by('Numero', 'DESC')
		            ->from('dvm_incidente i')
	            ;
		        
		        // return $this->db_incidentes->get_compiled_select(); // string de la consulta
		        return $this->db_incidentes->get()->result();
			break;

			case "tipos_atencion_incidente":
				$this->db_incidentes
		        	->select(array(
			            "ta.id Pk_Id",
						"ta.nombre Nombre"
		            ))
		            ->from('dvm_incidente i')
		            ->join('dvm_tipo_atencion ta', 'i.tipo_atencion = ta.id ')
		            ->where('YEAR(i.fecha)', $id["anio"])
		            ->where('MONTH(i.fecha)', $id["mes"])
		            ->group_by('i.tipo_atencion')
		            ->order_by('ta.nombre')
	            ;
		        
		        // return $this->db_incidentes->get_compiled_select(); // string de la consulta
		        return $this->db_incidentes->get()->result();
			break;
		}
	}
}
/* Fin del archivo Operaciones_model.php */
/* Ubicación: ./application/models/Operaciones_model.php */