<input type="hidden" id="slider_fechas"/>
<input type="hidden" id="fecha_activa">

<script type="text/javascript">
	$(document).ready(function(){
		// Variables
		var escala_fechas = new Array()
		
		var cont = 1
		
		var opciones = {
            "Mapa_Base": "google_streets",
            "Senales_Horizontales": [true, true, true],
            "Kilometros": [true],
        }

		let datos = {
			"via": "<?php echo $datos['id_via']; ?>",
			"calzada": `Calzada ${"<?php echo strtolower($datos['calzada']); ?>"}`,
			"costado": "<?php echo $datos['costado']; ?>",
		}
		// imprimir(datos)

		// Se consultan las secuencias disponibles
		let secuencias = ajax("<?php echo site_url('mediciones/obtener') ?>", {"tipo": "senales_horizontales_secuencias", "id": datos}, "JSON")

		// Si no se encuentran fechas
		if(secuencias.length == 0){
			// Mensaje de notificación
			swal("No se encontraron mediciones para esta vía.")

			return false
		}

		// Se recorren las secuencias
		$.each(secuencias, function(clave, valor) {
			// Se agrega la secuencia a la consulta
			datos.secuencia = valor.secuencia

			// Se consulta la fecha que más se repita para poner en el rango
			let fecha = ajax("<?php echo site_url('mediciones/obtener') ?>", {"tipo": "senales_horizontales_fecha_comun", "id": datos}, "JSON")
			// imprimir("Fecha común: "+ fecha.fechainspe)
			
			// Se agrega la fecha al slider
			escala_fechas.push(fecha.fechainspe)

			$("#fecha_activa").val(fecha.fechainspe)

			// Se crea un campo para luego leerlo
	        $("#slider_fechas").append(`<input type="hidden" id="fecha${cont++}" value="${fecha.fechainspe}" data-secuencia="${valor.secuencia}">`)
		})
		
		// Slider
		$('#slider_fechas').jRange({
			from: 1.0,
			to: secuencias.length,
			step: 1.0,
			disable: false,
			isRange: false,
			theme: 'theme-green',
			scale: escala_fechas,
			// format: '%s',
			width: 500,
			showLabels: false,
			snap: true,
			onstatechange: function(val){
				// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
	            opciones.datos = {
	                "via": $("#via").val(),
	                "calzada": datos.calzada,
	                "costado": datos.costado,
	                "secuencia": $(`#fecha${val}`).attr("data-secuencia"),
	            }

	            // Dibujo de la capa
        		dibujar_capas(window.mapa, opciones)
			},
		})
	})
</script>