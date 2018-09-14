<div id='cont_mapa'></div>

<script type="text/javascript">
	$(document).ready(function(){
		var mapa = generar_mapa("cont_mapa")
		marcar(mapa)

		$("select").on("change", function(){
			marcar(mapa)
		})

    mapa.on('click', generar_marcador)
		
	})
</script>