<input type="hidden" id="slider_calzadas"/>
<input type="hidden" id="calzada_activa">

<script type="text/javascript">
	$(document).ready(function(){
		console.clear()
		// imprimir("1. Cargando calzadas...")
		
		// Se consultan las calzadas
		let calzadas = ajax("<?php echo site_url('configuracion/obtener') ?>", {"tipo": "calzadas", "id": $("#via").val()}, "JSON")

		// Variables
		var escala_calzadas = new Array()
		var cont = 1
		var calzada

		// Se recorren los registros obtenidos
		$.each(calzadas, function(clave, valor) {
			// imprimir(`  1.${cont} ${valor.Nombre}`)

			// Se agrega cada registro al arreglo
	        escala_calzadas.push(`Calzada ${valor.Nombre}`)

	        // Valor de la calzada activa
	        $("#calzada_activa").val($(`#calzada${cont}`).val())

	        // Se crea un campo para luego leerlo
	        $("#slider_calzadas").append(`<input type="hidden" id="calzada${cont++}" value="${valor.Nombre}">`)
	    })
		// imprimir(escala_calzadas)

		// Si hay una sola calzada, se pone esta como activa
	    if(calzadas.length == 1) $("#calzada_activa").val($(`#calzada1`).val())

		// Slider
	    $('#slider_calzadas').jRange({
			from: 1.0,
			to: escala_calzadas.length,
			step: 1.0,
			disable: false,
			onstatechange: function(val){
	        	// Valor de la calzada activa
				$("#calzada_activa").val($(`#calzada${val}`).val())

				// Si solo hay un valor, carga los costados
				if(escala_calzadas.length > 1) cargar_costados()
			},
			isRange: false,
			theme: 'theme-green',
			scale: escala_calzadas,
			// format: '%s',
			width: 100,
			showLabels: false,
			snap: true
		})

	    // Si hay más de una calzada, carga los costados
		if(escala_calzadas.length == 1) cargar_costados()
	})
</script>