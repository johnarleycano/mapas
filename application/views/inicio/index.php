<div id='cont_mapa'></div>

<script type="text/javascript">
	$(document).ready(function(){
		let mapa = generar_mapa("cont_mapa")
		marcar("vias", mapa)

		$("select").on("change", function(){
			marcar("vias", mapa)
		})

    mapa.on('click', generar_marcador)
		
	})
</script>