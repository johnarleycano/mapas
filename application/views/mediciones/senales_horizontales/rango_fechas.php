<input type="hidden" id="slider_fechas"/>
<input type="hidden" id="fecha_activa">

<script type="text/javascript">
	$(document).ready(function(){
		// Variables
		var escala_fechas = new Array()
		var cont = 1
		var opciones = {
            // Capas
            "Senales_Horizontales": [true, true, true],
            "Vias": [true],
            "Kilometros": [true],
        }
		let datos = {
			"id_via": "<?php echo $datos['id_via']; ?>",
			"calzada": "<?php echo $datos['calzada']; ?>",
			"costado": "<?php echo $datos['costado']; ?>",
		}
		// imprimir(datos)

		// Se consultan las fechas disponibles
		let fechas = ajax("<?php echo site_url('mediciones/obtener') ?>", {"tipo": "senales_horizontales_fechas", "id": datos}, "JSON")

		// Si no se encuentran fechas
		if(fechas.length == 0){
			// Mensaje de notificación
			swal("No se encontraron mediciones para esta vía.")

			return false
		}
		
		// Se recorren los registros obtenidos
		$.each(fechas, function(clave, valor) {
	        escala_fechas.push(valor.fechainspe)

	        // Se crea un campo para luego leerlo
	        $("#slider_fechas").append(`<input type="hidden" id="fecha${cont++}" value="${valor.fechainspe}">`)
	    })
		// imprimir(escala_fechas)

		// Slider
		$('#slider_fechas').jRange({
			from: 1.0,
			to: fechas.length,
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
		        // Valor de la fecha activa
				$("#fecha_activa").val($(`#fecha${val}`).val())

				// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
	            opciones.datos = {
	                "via": $("#via").val(),
	                "calzada": datos.calzada,
	                "costado": datos.costado,
	                "fechainspe": $("#fecha_activa").val(),
	            }

	            // Dibujo de la capa
        		dibujar_capas(window.mapa, opciones)
			},
		})
	})
</script>