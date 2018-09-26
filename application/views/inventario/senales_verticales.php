<div id="cont_mapa" clas="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var opciones = {
			"Vias": [true, true, false],
			"Abscisas": [true, false],
			"Incidentes": [false],
			"Senales_Verticales": [true, true, true],
			"Capa_Mapa": "Bing",
		}

		var mapa = generar_mapa("cont_mapa", {zoom: 18, minZoom: 15, maxZoom: 18})
		marcar(mapa, opciones)

		$("select").on("change", function(){
			marcar(mapa, opciones)
		})
	})
</script>