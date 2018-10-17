<div id="cont_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Datos por URL
		var id_medicion = "<?php echo $this->uri->segment(3); ?>"
		var id_tipo_medicion = "<?php echo $this->uri->segment(4); ?>"
		var id_costado = "<?php echo $this->uri->segment(5); ?>"

		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {
			// Cartografía base
			"Municipios": [false],

			// Capas
			"Mediciones": [true, true, true],

			// Opciones
			"datos": {
				"Fk_Id_Medicion": id_medicion,
				"Fk_Id_Tipo_Medicion": id_tipo_medicion,
				"Fk_Id_Costado": id_costado,
			},
		}

		// Creación del mapa
		var mapa = crear("cont_mapa", {minZoom: 11, maxZoom: 18, zoom: 11})
		
		// Dibujo de las capas
		dibujar_capas(mapa, capas)

		// Removiendo el margen
		$("#contenedor_principal").removeClass("margen");
	})
</script>