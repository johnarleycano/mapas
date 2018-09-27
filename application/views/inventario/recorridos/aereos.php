<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var opciones = {
			"Vias": [true, true, false],
			"Abscisas": [true],
			"Incidentes": [false],
			"Senales_Verticales": [false],
			"Eventos_Diarios": [false],
			"Fotos_Aereas": [true, true, true],
			"Capa_Mapa": "Bing",
		}

		var mapa = generar_mapa("cont_mapa")
		marcar(mapa, opciones)
	})
</script>