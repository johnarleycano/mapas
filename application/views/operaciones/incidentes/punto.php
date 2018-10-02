<div id='cont_mapa'></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Se toma el id del incidente
		var id_incidente = "<?php echo $this->uri->segment(3); ?>"

		$("#contenedor_principal").removeClass("margen");
		
		// capas: [0]: incluir; [1]: dibujar; [2]: centrar
		var capas = {}

		var opciones = {
			"zoom": 18, 
			"minZoom": 18,
			// "maxZoom": 18,
			// "zoomControl": false,
			// "ubicacionActual": false
		}

		var mapa = crear("cont_mapa", opciones)
		dibujar_capas(mapa, capas)

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

			    if(incidente){
				    // Variables
					var coordenadas = []
				    var abscisa = parseInt(incidente.abscisa)
				    var kilometro = Math.trunc(abscisa / 1000) * 1000
				    var residuo_abscisa =  (abscisa % 1000) / 1000

				    // Consulta de puntos del kilómetro
				    var puntos_kilometro = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id":  {"id_sector": null, "id_via": incidente.id_via_configuracion, "kilometro": kilometro}}, 'JSON')

				    // Si trae resultados
				    if(puntos_kilometro.features.length > 0){
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
						
						// Al incidente se le insertan las coordenadas
					    var actualizar = ajax(`${$("#url").val()}/operaciones/actualizar`, {"tipo": "incidente", "id": this.id_incidente, "datos": {"longitud": coordenada.latLng.lng, "latitud": coordenada.latLng.lat}}, 'JSON')

					    // Se retornan las coordenadas
						return coordenada.latLng
				    }
				}
			}
		}

		// Se invoca la clase y se ejecuta
		const coordenadas = new Coordenadas(id_incidente)
		mapa.setView(new L.LatLng(coordenadas.obtener.lat, coordenadas.obtener.lng), opciones.zoom)

		/***********************************************************************************************************
		 ************************* Script para generar coordenadas a incidentes existentes *************************
		 ***********************************************************************************************************/
		// var incidentes = ajax(`${$("#url").val()}/operaciones/obtener`, {"tipo": "incidentes", "id": {"id_sector": null, "id_via": null}}, 'JSON')
		
		// // Recorrido de las coordenadas
		// $.each(incidentes, function(key, incidente){ 
		// 	// Si el incidente no tiene coordenadas creadas
		// 	if(!incidente.latitud){
		// 		// Se ejecuta la clase creadora de las coordenadas
		// 		const coordenadas = new Coordenadas(incidente.id)
		// 		coordenadas.obtener
				
		// 		imprimir(coordenadas)
		// 	}
		// })
		/***********************************************************************************************************
		 ***********************************************************************************************************
		 ***********************************************************************************************************/
	})
</script>
