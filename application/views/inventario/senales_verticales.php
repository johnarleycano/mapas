<div id="cont_mapa" clas="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {
			"Vias": [true, true],
			"Kilometros": [true],
			"Mapa_Base": "google_hibrido",
			"Municipios": [true],
			"Abscisas": [true],
			"Senales_Verticales": [true, true, true],
		}

		var mapa = crear("cont_mapa", {zoom: 17, minZoom: 17})
		dibujar_capas(mapa, capas)

		$("select").on("change", function(){
			dibujar_capas(mapa, capas)
		})
	})
</script>