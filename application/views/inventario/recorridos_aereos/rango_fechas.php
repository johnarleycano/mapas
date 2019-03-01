<input type="hidden" id="slider_fechas"/>
<input type="hidden" id="fecha_activa">

<script type="text/javascript">
	$(document).ready(function(){
		// Variables
		var escala_fechas = new Array()
		
		var cont = 1

		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var opciones = {
			"Vias": [true],
			"Fotos_Aereas": [true, true, true],
			"Mapa_Base": "google_streets",
			"IGAC": [true],
		}

		let datos = {
			"via": $("#via").val(),
		}
		// imprimir(datos)
		
		// Se consultan las secuencias disponibles
		let secuencias = ajax("<?php echo site_url('inventario/obtener') ?>", {"tipo": "fotos_aereas_secuencias", "id": datos}, "JSON")

		// Si no se encuentran fechas
		if(secuencias.length == 0){
			// Mensaje de notificación
			swal("No se encontraron fotografías para esta vía.")

			return false
		}

		// Se recorren las secuencias
		$.each(secuencias, function(clave, valor) {
			// Se agrega la secuencia a la consulta
			datos.secuencia = valor.secuencia
			// imprimir(datos)

			// Se consulta la fecha que más se repita para poner en el rango
			let fecha = ajax("<?php echo site_url('inventario/obtener') ?>", {"tipo": "fotos_aereas_fecha_comun", "id": datos}, "JSON")

			// Se agrega la fecha al slider
			escala_fechas.push(fecha.valor)

			$("#fecha_activa").val(fecha.valor)

			// Se crea un campo para luego leerlo
	        $("#slider_fechas").append(`<input type="hidden" id="fecha${cont++}" value="${fecha.valor}" data-secuencia="${valor.secuencia}">`)
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
	                "secuencia": $(`#fecha${val}`).attr("data-secuencia"),
	            }

	            // Dibujo de la capa
        		dibujar_capas(window.mapa, opciones)
			},
		})
	})
</script>