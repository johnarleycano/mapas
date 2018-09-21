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
			case "historico_accidentes":
				$filtro = "";
                if ($id['id_sector'] || $id["id_via"]) $filtro = ($id["id_via"]) ? "WHERE h.Fk_Id_Via = {$id['id_via']}" : "WHERE Fk_Id_Sector = {$id['id_sector']}";

				$sql =
				"SELECT
					h.Pk_Id,
					h.Fk_Id_Via,
					h.Abscisa,
					X ( Coordenadas ) AS Longitud,
					Y ( Coordenadas ) AS Latitud, 
					h.Total_Accidentes 
				FROM
					dvm_historico_accidentes AS h 
					INNER JOIN configuracion.vias AS v ON h.Fk_Id_Via = v.Pk_Id
				$filtro";

		        // return $this->db_incidentes->get_compiled_select();
                return $this->db_incidentes->query($sql)->result();
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
		        // return $this->db_incidentes->query($sql)->row();
			break;

			case 'incidentes':
				$filtro = "";
                if ($id['id_sector'] || $id["id_via"]) $filtro = ($id["id_via"]) ? "AND v.id_via_configuracion = {$id['id_via']}" : "AND vc.Fk_Id_Sector = {$id['id_sector']}";

				$sql = 
				"SELECT
					i.id, 	
					i.abscisa,
					ta.nombre,
					i.fecha,
					v.id_via_configuracion
				FROM
					incidentes_desarrollo.dvm_incidente AS i
					INNER JOIN incidentes_desarrollo.dvm_via AS v ON i.via = v.id
					INNER JOIN incidentes_desarrollo.dvm_tipo_atencion AS ta ON i.tipo_atencion = ta.id
				WHERE
					i.abscisa_real <> ''
					-- AND i.fecha BETWEEN '2018-09-01' AND '2018-09-30' 
					AND
(i.abscisa <> '10700' AND
v.id_via_configuracion <> 8)
					$filtro
				ORDER BY
					i.abscisa ASC";

				// return $this->db_incidentes->get_compiled_select();
                return $this->db_incidentes->query($sql)->result();
			break;

			case 'incidentes2':
				$filtro = "";
                if ($id['id_sector'] || $id["id_via"]) $filtro = ($id["id_via"]) ? "AND v.id_via_configuracion = {$id['id_via']}" : "AND vc.Fk_Id_Sector = {$id['id_sector']}";

				$sql = 
				"SELECT
					i.id,
					i.abscisa,
					i.fecha,
					i.abscisa_real,
					ta.nombre,
					i.fecha,
					v.id_via_configuracion,
					X ( GeomFromText ( AsText ( i.coordenadas ) ) ) Longitud,
					Y ( GeomFromText ( AsText ( i.coordenadas ) ) ) Latitud 
				FROM
					dvm_incidente AS i
					INNER JOIN dvm_via AS v ON i.via = v.id
					INNER JOIN dvm_tipo_atencion AS ta ON i.tipo_atencion = ta.id 
				WHERE
					i.fecha BETWEEN '2018-09-01' 
					AND '2018-09-30' 
					AND i.coordenadas IS NOT NULL 
				ORDER BY
					i.abscisa ASC";

				// return $this->db_incidentes->get_compiled_select();
                return $this->db_incidentes->query($sql)->result();
			break;
		}
	}
}
/* Fin del archivo Operaciones_model.php */
/* Ubicación: ./application/models/Operaciones_model.php */