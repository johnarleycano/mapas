/**
 * Adiciona los controles de un mapa
 * 
 * @param  {map}    mapa        [Mapa]
 * @param  {array}  opciones    [Arreglo de opciones configurables]
 * @return
 */
function agregar_controles(mapa, opciones)
{
    // Si tiene control, zoom movida a la derecha
    if(typeof mapa.zoomControl !== "undefined") mapa.zoomControl.setPosition('topright')

    // Control de escala
    let escala = L.control.scale({ position: 'bottomright', imperial: false})
    mapa.addControl(escala)

    // Control de ubicación actual
    var ubicacion_actual = L.control.locate({
    	position: 'topright',
    	strings: {
    		title: 'Mostrar mi ubicación actual',
    	},
    	icon: 'fa fa-location-arrow',
    })
    ubicacion_actual.addTo(mapa)
}