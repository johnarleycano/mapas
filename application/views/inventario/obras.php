<div id="cont_mapa" clas="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {
			"Vias": [true, true],
			"Obras": [true, true],
		}

		var mapa = crear("cont_mapa", {minZoom: 14, maxZoom: 16})
		dibujar_capas(mapa, capas)
	})
</script>