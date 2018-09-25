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
        zoom: 13,
        minZoom: 5,
        maxZoom: 18,
    })

    // Control de escala
    let escala = L.control.scale({ position: 'bottomright', imperial: false})
    mapa.addControl(escala)

    // Control de ubicación actual
    L.control.locate().addTo(mapa)

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
    let tipo_atencion = parseFloat($("#select_tipo_atencion_filtro").val())

    let id_sector = (sector || sector > 0) ? sector : null
    let id_via = (via || via > 0) ? via : null
    let id_tipo_atencion = (tipo_atencion || tipo_atencion > 0) ? tipo_atencion : null

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
    // .bindPopup("ok")
    .addTo(mapa)

    // Se agrega la capa
    capas["Vías"] = capa_vias

    // Se centra en la capa
    if(capa != "senales_verticales") mapa.fitBounds(capa_vias.getBounds())

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
        // Recolección de datos
        datos = {
            "id_sector": id_sector,
            "id_via": id_via,
            "id_tipo_atencion": id_tipo_atencion
        }

        // Consulta de incidentes
        let incidentes = ajax(`${$("#url").val()}/operaciones/obtener`, {"tipo": "incidentes", "id": datos}, 'JSON')
        
        // Arreglo que contiene los puntos
        var puntos = new Array()
        
        // Recorrido de los incidentes
        $.each(incidentes, function(key, incidente) {
            var punto = L.marker([incidente.longitud, incidente.latitud])
            .on("click", function(){
                swal({
                  title: `Incidente en la vía`,
                  text: `
                    Abscisa: ${incidente.abscisa_real}
                    Fecha: ${incidente.fecha}
                    `,
                  icon: "success",
                  buttons: false,
                  timer: 5000
                })
            })

            // El punto se agrega al arreglo
            puntos.push(punto)
        })

        // Se agrega el layer en el arreglo de capas
        capas["Incidentes"] = L.layerGroup(puntos).addTo(mapa)
    }

    /***************************************************
     *** Dibujo de inventario de señales verticales ****
     **************************************************/
    if(capa == "senales_verticales"){
        // Variable para mantener la ubicación del mapa
        var hash = new L.Hash(mapa)

        // Información de las señales verticales
        var capa_senales_verticales = new L.geoJson(null, {
            pointToLayer: function (feature, latlng) {
                // Código del ícono
                var codigo = String(feature.properties["codsen"]).toUpperCase()

                // Ícono
                var smallIcon = new L.Icon({
                    "iconSize": [21, 21],
                    "iconUrl": `${$("#url_base").val()}img/iconos/${codigo}.svg`,
                })
                
                // Marcador
                return L.marker(latlng, {icon: smallIcon});
            },
            onEachFeature: function pop_SealesVerticales_1(feature, layer) {
                var popupContent =
                    `
                    <b>Kilómetro:</b> ${(feature.properties['kilómetro']) ? feature.properties['kilómetro'] : ''}<br>
                    <b>Margen:</b> ${(feature.properties['costado']) ? feature.properties['costado'] : ''}<br>
                    <b>Código de señal:</b> ${(feature.properties['codseñal']) ? feature.properties['codseñal'] : ''}<br>
                    <b>Color:</b> ${(feature.properties['color']) ? feature.properties['color'] : ''}<br>
                    <b>Fecha de inspección:</b> ${(feature.properties['fechainspe']) ? feature.properties['fechainspe'] : ''}<br>
                    <b>Medición:</b> ${(feature.properties['medición']) ? feature.properties['medición'] : ''}<br>
                    <b>Observación:</b> ${(feature.properties['observ']) ? feature.properties['observ'] : ''}<br>
                    <b>Antigraf:</b> ${(feature.properties['antigraf']) ? feature.properties['antigraf'] : ''}
                    `
                layer.bindPopup(popupContent, {maxHeight: 400});
            },
        })

        // Cuadro del perímetro del que va a cargar los datos
        var perimetro = mapa.getBounds().toBBoxString()

        // Consulta de las señales verticales
        senales_verticales = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "senales_verticales", "id": {"id_sector": null, "id_via": id_via, "perimetro": perimetro}}, 'JSON')

        // Se agregan los datos a la capa
        capa_senales_verticales.addData(senales_verticales)
        
        // Cuando se mueva la capa
        mapa.on('moveend', function(e) {
            // Se limpian las señales
            capa_senales_verticales.clearLayers()

            // Se consultan las señales en el perímetro
            senales_verticales = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "senales_verticales", "id": {"id_sector": id_sector, "id_via": id_via, "perimetro": mapa.getBounds().toBBoxString()}}, 'JSON')

            // Se agregan a la capa
            capa_senales_verticales.addData(senales_verticales)
        }) 

        // Se agrega la capa
        mapa.addLayer(capa_senales_verticales)
    
        // Se agrega la capa
        capas["Señales verticales"] = capa_senales_verticales

        mapa.setView(new L.LatLng(6.17456,-75.34895), 18)
    }

    if(!control) var control = L.control.layers(capas_mapas, capas).addTo(mapa)
}