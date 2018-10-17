<div id="cont_mapa" clas="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {
			// Cartografía base
			"Municipios": [true],
			"Vias": [true],

			// Capas
			"Predios": [true, true, true],
		}

		var mapa = crear("cont_mapa", {minZoom: 12})
		dibujar_capas(mapa, capas)
	})
</script>