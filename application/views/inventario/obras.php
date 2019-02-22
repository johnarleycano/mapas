 <style>
.easy-button-button {
  display: block !important;
}

.tag-filter-tags-container {
  left: 30px;
}
</style>

<div id="cont_mapa" clas="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {
			"Vias": [true, true],
			"Obras": [true, true],
			"IGAC": [true],
		}

		var mapa = crear("cont_mapa")
		dibujar_capas(mapa, capas)
	})
</script>