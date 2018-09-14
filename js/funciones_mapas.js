function agregar_capas_mapas(mapa)
{
    // Mapa de Bing
    var bing = new L.BingLayer("Pl2wXFOEKQ0lIT6FDWrM~7S7lA5j_F2sDUhSdCeQVzw~AvN-ATn5N1EQzxbEEBkYWNUYY1AyXIzXPwXex81xLAN1RyJYJaML4e2gD9QTzsIU", {type: "Aerial"})

    // Mapa de Open Street
    var open_street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapa)

    var capas_mapas = {
        "Bing": bing,
        "Open Street": open_street,
    }

    return capas_mapas
}

function generar_mapa(contenedor)
{
    // Opciones del mapa
    let mapa = L.map(contenedor, {
        center: [6.176188, -75.354868],
        zoom: 15,
        minZoom: 5,
        maxZoom: 17,
    })

    // Control de escala
    let escala = L.control.scale({ position: 'bottomright', imperial: false})
    mapa.addControl(escala)

    // Minimapa
    // let mini_mapa = new L.TileLayer('https://{s}.www.toolserver.org/tiles/bw-mapnik/{z}/{x}/{y}.png', {minZoom:0, maxZoom: 13})
    // new L.Control.MiniMap(mini_mapa, { toggleDisplay: true }).addTo(mapa)

    // Se retorna el mapa
    return mapa
}

function generar_marcador(punto) {
    imprimir(`Has elegido crear un marcador en las coordenadas ${punto.latlng}`)
}

function marcar(mapa)
{
    // Variables
    let sector = parseFloat($("#select_sector_filtro").val())
    let via = parseFloat($("#select_via_filtro").val())
    let id_sector = (sector || sector > 0) ? sector : null
    let id_via = (via || via > 0) ? via : null

    /**
     * 
     */

    // Se recorren los layers
    mapa.eachLayer(function (layer) {
        // Se elimina cada layer
        mapa.removeLayer(layer);
    })

    // Se consultan las vías    
    var vias = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id": {"id_sector": id_sector, "id_via": id_via}}, 'JSON')

    // Se agrega la capa de vías
    var capa_vias = new L.geoJson(vias, {
        style: {
            "color": "#555555",
            "weight": 5,
            "opacity": 1
        }
    }).addTo(mapa)

    // Se centra en la capa
    mapa.fitBounds(capa_vias.getBounds())

    // Se agregan las capas de mapas
    var capas_mapas = agregar_capas_mapas(mapa)

    /**
     * 
     */

    // Se consultan las abscisas    
    abscisas = ajax(`${$("#url").val()}/configuracion/obtener`, {"tipo": "abscisas", "id": {"id_sector": id_sector, "id_via": id_via}}, 'JSON')
    // imprimir(abscisas)
    
    var circulos = new Array()

    $.each(abscisas, function(key, abscisa) {
        let circulo = L.circleMarker(
            [abscisa.Latitud, abscisa.Longitud],
            {
                radius: 5,
                color: "#438E32",
            }
        )
        .on("click", function(){
            swal(
                `Vía: ${abscisa.Via}
                Abscisa: ${abscisa.Abscisa}`
            )
        })
        circulos.push(circulo)
    })

    var capa_abscisas = L.layerGroup(circulos).addTo(mapa)

    // Capas específicas
    var capas = {
        "Vías": capa_vias,
        "Abscisas": capa_abscisas
    }

    // Agregado el control
    var control = L.control.layers(capas_mapas, capas).addTo(mapa)
    mapa.control.removeFrom(mapa)
}