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

function marcar(mapa, capa = null)
{
    /**********************************
     ******** Parametrización *********
     *********************************/
    let sector = parseFloat($("#select_sector_filtro").val())
    let via = parseFloat($("#select_via_filtro").val())
    let id_sector = (sector || sector > 0) ? sector : null
    let id_via = (via || via > 0) ? via : null

    // Arreglo que contendrá todas las capas
    var capas = {}

    // Se recorren los layers
    mapa.eachLayer(function (layer) {
        // Se elimina cada layer
        mapa.removeLayer(layer);
    })

    /**********************************
     ******* Dibujo de las vías *******
     *********************************/
    // Se consultan las vías    
    var kilometros = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id": {"id_sector": id_sector, "id_via": id_via}}, 'JSON')

    // Arreglo que almacenará todas las líneas
    var lineas = []
    
    // Se agrega la capa de vías
    var capa_vias = new L.geoJson(kilometros, {
        style: {
            "color": "#555555",
            "weight": 5,
            "opacity": 1
        }
    })
    .bindPopup("ok")
    // .addTo(mapa)

    // Se agrega la capa
    capas["Vías"] = capa_vias

    // Se centra en la capa
    mapa.fitBounds(capa_vias.getBounds())

    // Se agregan las capas de mapas
    var capas_mapas = agregar_capas_mapas(mapa)

    /**********************************
     ****** Dibujo de las abscisas ****
     *********************************/
    // Se consultan las abscisas    
    abscisas = ajax(`${$("#url").val()}/configuracion/obtener`, {"tipo": "abscisas", "id": {"id_sector": id_sector, "id_via": id_via}}, 'JSON')
    
    // Arreglo que contiene los puntos
    var puntos = new Array()

    // Recorrido de las abscisas
    $.each(abscisas, function(key, abscisa) {
        // Creación del punto
        let punto = L.circleMarker(
            [abscisa.Latitud, abscisa.Longitud],
            {
                radius: 5,
                color: "#438E32",
            }
        )
        // Evento clic
        .on("click", function(){
            swal(
                `Vía: ${abscisa.Via}
                Abscisa: ${abscisa.Abscisa}`
            )
        })

        // El punto se agrega al arreglo
        puntos.push(punto)
    })

    // Se agrega el layer en el arreglo de capas
    capas["Abscisas"] = L.layerGroup(puntos)/*.addTo(mapa)*/
    
    /***************************************************
     ******* Dibujo de incidentes de operaciones *******
     **************************************************/
    if(capa == "incidentes"){
        // Consulta de incidentes
        let incidentes = ajax(`${$("#url").val()}/operaciones/obtener`, {"tipo": "incidentes", "id": {"id_sector": id_sector, "id_via": id_via}}, 'JSON')
        
        // Arreglo con el grupo
        grupo = []
        
        // $.each(incidentes, function(key, incidente) {
        //     var coordenadas = []
        //         kilometro = Math.trunc(abscisa / 1000) * 1000  
        //         punto =  (abscisa % 1000) / 1000
                
        //     // imprimir(`Vía ${incidente.id_via_configuracion}, abscisa ${abscisa}`)

        //     var puntos = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id":  {"id_sector": id_sector, "id_via": incidente.id_via_configuracion, "kilometro": kilometro}}, 'JSON')

        //     // Si existen coordenadas (Porque puede tener una abscisa fuera de perímetro)
        //     if(puntos.features[0]){
        //         var valores = puntos.features[0].geometry.coordinates

        //         for (i = 0; i < valores.length; i++){
        //             coordenadas.push(valores[i].reverse())
        //         }

        //         var polyline = new L.polyline(coordenadas)
                    
        //         var arrayOfPoints = polyline.getLatLngs()
                
        //         var point1 = L.GeometryUtil.interpolateOnLine(mapa, arrayOfPoints, punto)
                
        //         var marcador = L.marker(point1.latLng)
        //         .on("mouseover", function(){
        //             swal({
        //               title: `Incidente número ${incidente.id}`,
        //               text: `
        //                 Tipo de incidente: ${incidente.nombre}
        //                 Abscisa: ${incidente.abscisa}
        //                 Fecha: ${incidente.fecha}
        //                 `,
        //               icon: "success",
        //               buttons: false,
        //               timer: 5000
        //             })
        //         })
                
        //         grupo.push(marcador)
        //     }
        // })

        // var capa_incidentes = L.layerGroup(grupo)
        // .addTo(mapa);

        // capas["Incidentes"] = capa_incidentes
    }

    if(!control){
        // Agregado el control
        var control = L.control.layers(capas_mapas, capas).addTo(mapa)
    }
}