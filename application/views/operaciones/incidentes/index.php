<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Variables
	    let sector = parseFloat($("#select_sector_filtro").val())
	    let via = parseFloat($("#select_via_filtro").val())
	    let id_sector = (sector || sector > 0) ? sector : null
	    let id_via = (via || via > 0) ? via : null

		var mapa = generar_mapa("cont_mapa")

		marcar(mapa, "incidentes")

		$("select").on("change", function(){
			marcar(mapa, "incidentes")
		})
	})
</script>