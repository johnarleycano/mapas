<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		var mapa = generar_mapa("cont_mapa")
		marcar(mapa)

		$("select").on("change", function(){
			marcar(mapa)
		})

		// Al dar clic sobre cualquier parte del mapa, ejecuta
		// la función para generar un marcador
    	mapa.on('click', generar_marcador)
	})
</script>