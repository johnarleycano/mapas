<div id='cont_mapa'></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Se toma el id del incidente
		var id_incidente = "<?php echo $this->uri->segment(3); ?>"

		$("#contenedor_principal").removeClass("margen");
		var mapa = generar_mapa("cont_mapa")
		marcar(mapa)

		/**
		 * Clase que contiene la gestión de
		 * las coordenadas del incidente
		 */
		class Coordenadas {
			constructor(id_incidente) {
				this.id_incidente = id_incidente
			}

			get obtener() {
				return this.calcular()
			}

			calcular() {
				// Consulta de los datos del incidente
			    var incidente = ajax(`${$("#url").val()}/operaciones/obtener`, {"tipo": "incidente", "id":  this.id_incidente}, 'JSON')

			    // Variables
				var coordenadas = []
			    var abscisa = parseInt(incidente.abscisa)
			    var kilometro = Math.trunc(abscisa / 1000) * 1000
			    var residuo_abscisa =  (abscisa % 1000) / 1000

			    // Consulta de puntos del kilómetro
			    var puntos_kilometro = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id":  {"id_sector": null, "id_via": incidente.id_via_configuracion, "kilometro": kilometro}}, 'JSON')
			    
			    // Si trae resultados
			    if(puntos_kilometro.features[0]){
			    	// Se almacena las coordenadas
		       		let coordenadas_kilometro = puntos_kilometro.features[0].geometry.coordinates

		       		// Se recorren las coordenadas
		       		for (var i = 0; i < coordenadas_kilometro.length; i++){
		       			// Se invierten para poder ser ubicadas geoespacialmente
		                coordenadas.push(coordenadas_kilometro[i].reverse())
		            }

	            	// Se crea una polilínea y se obtienen las coordenadas
		            var polilinea = new L.polyline(coordenadas)

		            // Se obtienen las coordenadas de la polilínea
		            var coordenadas_polilinea = polilinea.getLatLngs()

					// Se calcula el punto exacto
					var coordenada = L.GeometryUtil.interpolateOnLine(mapa, coordenadas_polilinea, residuo_abscisa)

					// Se crea el marcador
					var marcador = L.marker(coordenada.latLng)
		                .on("click", function(){
		                	// Modal con información
		                    swal({
		                      title: `Incidente en ${incidente.nombre_via_configuracion}`,
		                      text: `
		                        Abscisa: ${incidente.abscisa_real}
		                        Informado por ${incidente.informado_por_nombre}
		                        Fecha: ${incidente.fecha}
		                        `,
		                      buttons: false,
		                      timer: 5000
		                    })
		                })
		                .addTo(mapa)
					
					// Se hace zoom al kilómetro
					mapa.fitBounds(polilinea.getBounds())
			    }

			    // Se retornan las coordenadas
				return coordenada.latLng
			}
		}

		// Se invoca la clase y se ejecuta
		const coordenadas = new Coordenadas(id_incidente)
		coordenadas.obtener
	})
</script>
