<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var opciones = {
			"Vias": [true, true, true],
			"Abscisas": [true, false, false],
			"Incidentes": [true, true, true],
			"Senales_Verticales": [false],
		}

		var mapa = generar_mapa("cont_mapa")
		marcar(mapa, opciones)

		$("select").on("change", function(){
			marcar(mapa, opciones)
		})
	})
</script>