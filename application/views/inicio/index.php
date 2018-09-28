<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var opciones = {
			"Vias": [true, true],
			"Abscisas": [true],
			"Senales_Verticales": [true, true, true],
			"Fotos_Aereas": [true, true],
		}

		var mapa = generar_mapa("cont_mapa", {zoom: 18, minZoom: 15, maxZoom: 18})
		marcar(mapa, opciones)

		$("select").on("change", function(){
			marcar(mapa, opciones)
		})

		// Al dar clic sobre cualquier parte del mapa, ejecuta
		// la función para generar un marcador
    	mapa.on('click', generar_marcador)
	})
</script>