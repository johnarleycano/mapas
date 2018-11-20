<input type="hidden" id="slider_calzadas"/>

<script type="text/javascript">
	$(document).ready(function(){
		// Se consultan las calzadas
		let calzadas = ajax("<?php echo site_url('configuracion/obtener') ?>", {"tipo": "calzadas", "id": "<?php echo $id_via; ?>"}, "JSON")

		// Variables
		var escala_calzadas = new Array()
		var cont = 1

		// Recorrido de los registros
		$.each(calzadas, function(clave, valor) {
			// Se agrega cada registro al arreglo
	        escala_calzadas.push(`Calzada ${valor.Nombre}`)

	        // Se crea un campo para luego leerlo
	        $("#slider_calzadas").append(`<input type="hidden" id="calzada${cont++}" value="${valor.Nombre}">`)
	    })
	    
	    $('#slider_calzadas').jRange({
			from: 1.0,
			to: escala_calzadas.length,
			step: 1.0,
			disable: false,
			onstatechange: function(val){
				imprimir(val)
				var calzada = $(`#calzada${val}`).val()
				cargar_fechas()
			},
			isRange: false,
			theme: 'theme-green',
			scale: escala_calzadas,
			// format: '%s',
			width: 100,
			showLabels: false,
			snap: true
		})
	})
</script>