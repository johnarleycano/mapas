<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		var mapa = generar_mapa("cont_mapa")
		marcar(mapa, "incidentes")

		$("select").on("change", function(){
			marcar(mapa, "incidentes")
		})
	})
</script>