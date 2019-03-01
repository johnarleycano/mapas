<div id="cont_mapa"></div>

<script type="text/javascript">
	/**
	 * Interfaz que carga las calzadas
	 * en modo rango
	 * 
	 * @return
	 */
	function cargar_calzadas()
	{
		$("#cont_calzadas").load("<?php echo site_url('configuracion/cargar_interfaz'); ?>", {"tipo": "rango_calzadas", "id_via": $("#via").val()})
	}

	/**
	 * Interfaz que carga los costados
	 * en modo rango
	 * 
	 * @return
	 */
	function cargar_costados()
	{
		$("#cont_costados").load("<?php echo site_url('configuracion/cargar_interfaz'); ?>", {"tipo": "rango_costados"})
	}

	/**
	 * Interfaz que carga las fechas disponibles
	 * en modo rango
	 * 
	 * @return
	 */
	function cargar_fechas()
	{
		// imprimir("3. Cargando fechas disponibles...")
		
		// Mensaje de notificación
		cerrar_notificaciones()
        imprimir_notificacion("<div uk-spinner></div> Cargando fechas disponibles...")

		// Valores
		var id_via = "<?php echo $this->uri->segment(3); ?>"
		var calzada = "<?php echo $this->uri->segment(4); ?>"
		var costado = "<?php echo $this->uri->segment(5); ?>"

		// Datos por URL
		var datos = {
			"id_via": (id_via) ? id_via : $("#via").val(),
			"calzada": (calzada) ? calzada : $("#calzada_activa").val(),
			"costado": (costado) ? costado : $("#costado_activo").val(),
		}
			
		// Carga de interfaz
		$("#cont_fechas").load("<?php echo site_url('mediciones/cargar_interfaz'); ?>", {"tipo": "rango_fechas_senales_horizontales", "datos": datos})
	}

	$(document).ready(function(){
		// Creación del mapa
		window.mapa = crear("cont_mapa", {minZoom: 10, maxZoom: 18})
		
		// Carga de las calzadas
		cargar_calzadas()
        
		// Al seleccionar una vía, carga las calzadas
        $("#via").on("change", cargar_calzadas)
	})
</script>