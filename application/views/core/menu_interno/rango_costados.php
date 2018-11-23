<input type="hidden" id="slider_costados"/>
<input type="hidden" id="costado_activo">

<script type="text/javascript">
	$(document).ready(function(){
		// imprimir("2. Cargando costados...")
		
		// Se consultan los costados
		let costados = ajax("<?php echo site_url('configuracion/obtener') ?>", {"tipo": "tipos_costados"}, "JSON")

		// Variables
		var escala_costados = new Array()
		var cont = 1
		var costado

		// Se recorren los registros obtenidos
		$.each(costados, function(clave, valor) {
			// imprimir(`  2.${cont} ${valor.Nombre}`)
			
			// Se agrega cada registro al arreglo
	        escala_costados.push(`Costado ${valor.Nombre}`)

	        // Valor del costado activo
	        $("#costado_activo").val($(`#costado${cont}`).val())

	        // Se crea un campo para luego leerlo
	        $("#slider_costados").append(`<input type="hidden" id="costado${cont++}" value="${valor.Nombre}">`)
	    })
		// imprimir(escala_costados)
		
		// Slider
		$('#slider_costados').jRange({
			from: 1.0,
			to: escala_costados.length,
			step: 1.0,
			disable: false,
			onstatechange: function(val){
	        	// Valor del costado activo
				$("#costado_activo").val($(`#costado${val}`).val())

				// Se cargan las fechas
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