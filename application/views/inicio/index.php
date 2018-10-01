<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var opciones = {
			"Vias": [true, true],
			"Kilometros": [true, true],
			"Senales_Verticales": [true, true, true],
			"Fotos_Aereas": [true, true],
			"Obras": [true, true],
			"Municipios": [true, true],
		}

		var mapa = generar_mapa("cont_mapa", {zoom: 18, minZoom: 15, maxZoom: 18})
		marcar(mapa, opciones)
	})
</script>