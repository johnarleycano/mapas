<div id="cont_mapa" clas="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		var mapa = generar_mapa("cont_mapa")
		marcar(mapa, "senales_verticales")

		$("select").on("change", function(){
			marcar(mapa, "senales_verticales")
		})

	})
</script>