<div id="cont_mapa" clas="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var opciones = {
			"Vias": [true, true],
			"Obras": [true, true],
		}

		var mapa = generar_mapa("cont_mapa", {zoom: 18, minZoom: 15, maxZoom: 18})
		marcar(mapa, opciones)
	})
</script>