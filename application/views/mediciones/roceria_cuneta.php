<div id="cont_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Valores
		const medicion = "<?php echo $this->uri->segment(3); ?>"
		const tipo_medicion = "<?php echo $this->uri->segment(4); ?>"
		const costado = "<?php echo $this->uri->segment(5); ?>"

		// Datos por URL
		let id_medicion = (medicion) ? medicion : 471
		let id_tipo_medicion = (tipo_medicion) ? tipo_medicion : 1
		let id_costado = (costado) ? costado : 20

		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {
			// Capas
			"Roceria_Cuneta": [true, true, true],
			"Mapa_Base": "google_hibrido",

			// Opciones
			"datos": {
				"Fk_Id_Medicion": id_medicion,
				"Fk_Id_Tipo_Medicion": id_tipo_medicion,
				"Fk_Id_Costado": id_costado,
			},
		}

		// Creación del mapa
		var mapa = crear("cont_mapa")
		
		// Dibujo de las capas
		dibujar_capas(mapa, capas)

		// Removiendo el margen
		$("#contenedor_principal").removeClass("margen");
	})
</script>