<div id="cont_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {
			// Cartografía base
			"Vias": [true, true],
			"Kilometros": [true],
			"Abscisas": [true],
			"Municipios": [true, true],
			"IGAC": [true],
			
			// Capas
			"Senales_Verticales": [true, true, true],
			"Obras": [true, true],
		}

		// Creación del mapa
		var mapa = crear("cont_mapa", {zoom: 17})

		// Dibujo de las capas
		dibujar_capas(mapa, capas)
	})
</script>