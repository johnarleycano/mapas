<div id='cont_mapa'></div>

<script type="text/javascript">
	$(document).ready(function(){
		var tipo_punto = "<?php echo $this->uri->segment(3); ?>"
		var id_via = parseInt("<?php echo $this->uri->segment(4); ?>")
		var abscisa = parseInt("<?php echo $this->uri->segment(5); ?>")
		var id = parseInt("<?php echo $this->uri->segment(6); ?>")

		$("#contenedor_principal").removeClass("margen")

		// capas: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {
			"Mapa_Base": "google_hibrido"
		}

		var opciones = {
			"zoom": 18, 
			"minZoom": 18,
		}

		var mapa = crear("cont_mapa", opciones)
		dibujar_capas(mapa, capas)

		// Se generan las coordenadas del punto específico
		var coordenadas = generar_coordenadas(mapa, id_via, abscisa, id)

		// Si encuentra coordenadas
		if(coordenadas) {
			// Se crea el marcador
            var marcador = L.marker(coordenadas)
            // .on("click", function(){
            //  // Modal con información
            //     swal({
            //       title: `Incidente`,
            //       buttons: false,
            //       timer: 5000
            //     })
            // })
            .addTo(mapa)

			// Ubica el mapa en la coordenada
			mapa.setView(new L.LatLng(coordenadas.lat, coordenadas.lng), opciones.zoom)

			// Si el punto se crea desde el registro inicial
			if(tipo_punto == "inicial"){
				var datos = {
					"id_via": id_via, 
					"abscisa": abscisa, 
					"longitud": coordenadas.lng, 
					"latitud": coordenadas.lat
				}

				// Se guarda temporalmente las coordenadas en la base de datos para que pueda ser tomada posteriormente
				ajax(`${$("#url").val()}/operaciones/crear`, {"tipo": "coordenada_temporal", "datos": datos}, 'HTML')
			}

			// Si el punto se crea desde el registro SOS
			if(tipo_punto == "registro_sos"){
				// Al incidente se le insertan las coordenadas
			    ajax(`${$("#url").val()}/operaciones/actualizar`, {"tipo": "incidente", "id": id, "datos": {"longitud": coordenadas.lng, "latitud": coordenadas.lat}}, 'HTML')
			}
		}
	})
</script>