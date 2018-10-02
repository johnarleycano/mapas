/**
 * Función que adiciona los mapas base a cada mapa
 * 
 * @param  {map}        mapa    [Objeto mapa]
 * @param  {string}     capa    [capa que se activa por defecto]
 * @return {map}                [Mapas base]
 */
function agregar_mapas_base(mapa, capa = "bing")
{
    // Mapa de Bing
    var bing = new L.BingLayer("Pl2wXFOEKQ0lIT6FDWrM~7S7lA5j_F2sDUhSdCeQVzw~AvN-ATn5N1EQzxbEEBkYWNUYY1AyXIzXPwXex81xLAN1RyJYJaML4e2gD9QTzsIU", {
        type: "Aerial",
        maxZoom: 19
    })

    // Mapa de Open Street
    var open_street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    })

    // Mapa de Open Street en gris
    var open_street_dark = L.tileLayer('http://{s}.www.toolserver.org/tiles/bw-mapnik/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
        maxZoom: 19
    })

    // Arreglo de los mapas base
    var mapas_base = {
        "bing": bing,
        "open_street": open_street,
        "open_street_dark": open_street_dark,
    }

    // Se checkea el radio del mapa base
    $(`#${capa}`).prop("checked", true)
    
    // Cuando se selecciona otro mapa base
    $("input[name='mapas_base']").on("click", function(){
        // Se recorren los mapas base
         $.each(mapas_base, function(key, mapa_base) {
            // Se quita el mapa base
            mapa.removeLayer(mapa_base)
        })

        // Se activa el mapa base
        mapas_base[$(this).attr("id")].addTo(mapa)
    })

    // Se activa el mapa seleccionado
    mapas_base[capa].addTo(mapa)

    // Se retorna el mapa con todas las capas base
    return mapas_base
}