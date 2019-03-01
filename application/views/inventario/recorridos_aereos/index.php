<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	/**
	 * Interfaz que carga las fechas disponibles
	 * en modo rango
	 * 
	 * @return
	 */
	function cargar_fechas()
	{
		// Datos por URL
		var datos = {
			"id_via": ($("#via").val() != 0) ? $("#via").val() : null,
		}

		// Si no se selecciona una vía, se detiene
		if(!datos.id_via) return false

		// Carga de interfaz
		$("#cont_fechas").load("<?php echo site_url('inventario/cargar_interfaz'); ?>", {"tipo": "rango_fechas_fotos_aereas", "datos": datos})
	}

	$(document).ready(function(){
		// Creación del mapa
		window.mapa = crear("cont_mapa", {minZoom: 10, maxZoom: 18})

		// Carga de las fechas
		cargar_fechas()

		// Al seleccionar una vía, carga las fechas
        $("#via").on("change", cargar_fechas)
	})
</script>