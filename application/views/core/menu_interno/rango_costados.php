<input type="hidden" id="slider_costados"/>

<script type="text/javascript">
	$(document).ready(function(){
		// Se consultan los costados
		let costados = ajax("<?php echo site_url('configuracion/obtener') ?>", {"tipo": "tipos_costados"}, "JSON")

		// Variables
		var escala_costados = new Array()
		var cont = 1

		// Recorrido de los registros
		$.each(costados, function(clave, valor) {
			// Se agrega cada registro al arreglo
	        escala_costados.push(`Costado ${valor.Nombre}`)

	        // Se crea un campo para luego leerlo
	        $("#slider_costados").append(`<input type="hidden" id="costado${cont++}" value="${valor.Nombre}">`)
	    })

		$('#slider_costados').jRange({
			from: 1.0,
			to: escala_costados.length,
			step: 1.0,
			disable: false,
			onstatechange: function(val){
				var costado = $(`#costado${val}`).val()
				cargar_fechas()
			},
			isRange: false,
			theme: 'theme-green',
			scale: escala_costados,
			// format: '%s',
			width: 130,
			showLabels: false,
			snap: true
		})

	})
</script>