<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {
			"Vias": [true, true],
			"Fotos_Aereas": [true, true],
		}

		var mapa = crear("cont_mapa")
		dibujar_capas(mapa, capas)
	})
</script>