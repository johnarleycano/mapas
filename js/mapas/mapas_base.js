/**
 * Función que adiciona los mapas base a cada mapa
 * 
 * @param  {map}        mapa    [Objeto mapa]
 * @param  {string}     capa    [capa que se activa por defecto]
 * @return {map}                [Mapas base]
 */
function agregar_mapas_base(mapa, capa = "google_satelite")
{
    // Z-Index
    mapa.createPane('50').style.zIndex = 50

    // Mapa de Bing
    var bing_satelital = new L.BingLayer("Pl2wXFOEKQ0lIT6FDWrM~7S7lA5j_F2sDUhSdCeQVzw~AvN-ATn5N1EQzxbEEBkYWNUYY1AyXIzXPwXex81xLAN1RyJYJaML4e2gD9QTzsIU", {
        type: "Aerial",
        maxZoom: 19,
        pane: '50',
    })

    // Gobernación de Antioquia
    var gobernacion_antioquia = L.esri.tiledMapLayer({
        url: "http://190.109.167.188:81/arcgis/rest/services/imagenes/Ant_10000_Orto_WebMercator/ImageServer",
        maxZoom: 21,
        pane: '50',
    })

    // Google Híbrido
    var google_hibrido = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
        maxZoom: 21,
        subdomains:['mt0','mt1','mt2','mt3'],
        pane: '50',
    })    

    // Google satelital
    var google_satelite = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
        maxZoom: 21,
        subdomains:['mt0','mt1','mt2','mt3'],
        pane: '50',
    })

    // Google Streets
    var google_streets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 21,
        subdomains:['mt0','mt1','mt2','mt3'],
        pane: '50',
    })

    // Mapa de Open Street
    var open_street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 21,
        pane: '50',
    })

    // Mapa de Open Street en gris
    var open_street_dark = L.tileLayer('http://{s}.www.toolserver.org/tiles/bw-mapnik/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
        maxZoom: 21,
        pane: '50',
    })

    // Arreglo de los mapas base
    var mapas_base = {
        "bing_satelital": bing_satelital,
        "gobernacion_antioquia": gobernacion_antioquia,
        "google_hibrido": google_hibrido,
        "google_satelite": google_satelite,
        "google_streets": google_streets,
        "open_street": open_street,
        "open_street_dark": open_street_dark,
    }

    // Se marca por defecto el mapa base
    select_por_defecto("select_mapa_base", capa)
    
    // Cuando se selecciona otro mapa base
    $("#select_mapa_base").on("change", function(){
        // Se recorren los mapas base
        $.each(mapas_base, function(key, mapa_base) {
            // Se quita el mapa base
            mapa.removeLayer(mapa_base)
        })

        // Se activa el mapa base
        mapas_base[$(this).val()].addTo(mapa)
    })

    // Se activa el mapa seleccionado
    mapas_base[capa].addTo(mapa)

    // Se retorna el mapa con todas las capas base
    return mapas_base
}