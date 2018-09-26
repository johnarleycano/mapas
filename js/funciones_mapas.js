function agregar_capas_mapas(mapa, capa = "Bing")
{
    // Mapa de Bing
    var bing = new L.BingLayer("Pl2wXFOEKQ0lIT6FDWrM~7S7lA5j_F2sDUhSdCeQVzw~AvN-ATn5N1EQzxbEEBkYWNUYY1AyXIzXPwXex81xLAN1RyJYJaML4e2gD9QTzsIU", {
        type: "Aerial"
    })

    // Mapa de Open Street
    var open_street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    })

    // Arreglo de las capas de mapas
    var capas_mapas = {
        "Bing": bing,
        "Open Street": open_street,
    }

    // Se activa el mapa seleccionado
    capas_mapas[capa].addTo(mapa)

    return capas_mapas
}

function generar_mapa(contenedor, opciones = null)
{
    if (opciones) {
        var zoom = (typeof opciones.zoom !== 'undefined') ? opciones.zoom : 18
        var zoom_minimo = (typeof opciones.minZoom !== 'undefined') ? opciones.minZoom : 15
        var zoom_maximo = (typeof opciones.maxZoom !== 'undefined') ? opciones.maxZoom : 18
    }

    // Opciones del mapa
    let mapa = L.map(contenedor, {
        "center": [6.176188, -75.354868],
        "zoom": zoom,
        "minZoom": zoom_minimo,
        "maxZoom": zoom_maximo,
    })

    // Control de escala
    let escala = L.control.scale({ position: 'bottomright', imperial: false})
    mapa.addControl(escala)

    // Control de ubicación actual
    L.control.locate().addTo(mapa)

    // Se retorna el mapa
    return mapa
}

function dibujar_vias(mapa, filtros)
{
    // Se consultan las vías    
    var kilometros = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id": {"id_sector": filtros.id_sector, "id_via": filtros.id_via}}, 'JSON')

    // Se agrega la capa de vías
    return new L.geoJson(kilometros, {
        style: {
            "color": "#555555",
            "weight": 5,
            "opacity": 1
        }
    })
}

function dibujar_abscisas(mapa, filtros)
{
    // Se consultan las abscisas    
    var abscisas = ajax(`${$("#url").val()}/configuracion/obtener`, {"tipo": "abscisas", "id": {"id_sector": filtros.id_sector, "id_via": filtros.id_via}}, 'JSON')

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
    
    return L.layerGroup(puntos) 
}

function dibujar_incidentes(mapa, filtros)
{
    // Consulta de incidentes
    let incidentes = ajax(`${$("#url").val()}/operaciones/obtener`, {"tipo": "incidentes", "id": {"id_sector": null, "id_via": filtros.id_via, "id_tipo_atencion": filtros.id_tipo_atencion}}, 'JSON')

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
    
    return L.layerGroup(puntos) 
}

function dibujar_senales_verticales(mapa, filtros){
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
                <b>Fecha:</b> ${(feature.properties['fechainspe']) ? feature.properties['fechainspe'] : ''}<br>
                <b>Medición:</b> ${(feature.properties['medición']) ? feature.properties['medición'] : ''}<br>
                <b>Observación:</b> ${(feature.properties['observ']) ? feature.properties['observ'] : ''}<br>
                <b>Antigraf:</b> ${(feature.properties['antigraf']) ? feature.properties['antigraf'] : ''}<br>
                <center>
                    <img src="${$("#url_base").val()}DCIM/${feature.properties['archivo']}" />
                </center>
                `
            layer.bindPopup(popupContent, {maxHeight: 400});
        },
    })

    // Cuadro del perímetro del que va a cargar los datos
    var perimetro = mapa.getBounds().toBBoxString()

    // Consulta de las señales verticales
    senales_verticales = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "senales_verticales", "id": {"id_sector": null, "id_via": filtros.id_via, "perimetro": perimetro}}, 'JSON')

    // Se agregan los datos a la capa
    capa_senales_verticales.addData(senales_verticales)

    // Cuando se mueva la capa
    mapa.on('moveend', function(e) {
        // Se limpian las señales
        capa_senales_verticales.clearLayers()

        // Se consultan las señales en el perímetro
        senales_verticales = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "senales_verticales", "id": {"id_sector": filtros.id_sector, "id_via": filtros.id_via, "perimetro": mapa.getBounds().toBBoxString()}}, 'JSON')

        // Se agregan a la capa
        capa_senales_verticales.addData(senales_verticales)
    })

    // Se agrega la capa
    // mapa.addLayer(capa_senales_verticales)

    return capa_senales_verticales
}

function generar_marcador(punto) {
    imprimir(`Has elegido crear un marcador en las coordenadas ${punto.latlng}`)
}

function marcar(mapa, opciones)
{
    /**********************************
     ******** Parametrización *********
     *********************************/
    let sector = parseFloat($("#select_sector_filtro").val())
    let via = parseFloat($("#select_via_filtro").val())
    let tipo_atencion = parseFloat($("#select_tipo_atencion_filtro").val())

    // Variables de filtros
    var filtros = {
        "id_sector": (sector || sector > 0) ? sector : null,
        "id_via": (via || via > 0) ? via : null,
        "id_tipo_atencion": (tipo_atencion || tipo_atencion > 0) ? tipo_atencion : null,
    }

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
    // Si tiene activa la carga de vías
    if(opciones["Vias"][0]){
        // Se dibuja la capa
        var capa_vias = dibujar_vias(mapa, filtros)

        // Se agrega la capa
        capas["Vías"] = capa_vias

        // Si tiene activa la opción de dibujar las vías
        if(opciones["Vias"][1]) capa_vias.addTo(mapa)

        // Si tiene activa la opción, centra el dibujo en la capa
        if(opciones["Vias"][2]) mapa.fitBounds(capa_vias.getBounds())
    }

    /**********************************
     ****** Dibujo de las abscisas ****
     *********************************/
    // Si tiene activa la carga de abscisas
    if(opciones["Abscisas"][0]){
        // Se dibuja la capa
        var capa_abscisas = dibujar_abscisas(mapa, filtros)

        // Se agrega la capa
        capas["Abscisas"] = capa_abscisas

        // Si tiene activa la opción de dibujar las abscisas
        if(opciones["Abscisas"][1]) capa_abscisas.addTo(mapa)

        // Si tiene activa la opción, centra el dibujo en la capa
        // if(opciones["Abscisas"][2]) mapa.fitBounds(capa_abscisas.getBounds())
    }
    
    /***************************************************
     ******* Dibujo de incidentes de operaciones *******
     **************************************************/
     // Si tiene activa la carga de incidentes
    if(opciones["Incidentes"][0]){
        // Se dibuja la capa
        var capa_incidentes = dibujar_incidentes(mapa, filtros)

        // Se agrega la capa
        capas["Incidentes"] = capa_incidentes

        // Si tiene activa la opción de dibujar las abscisas
        if(opciones["Incidentes"][1]) capa_incidentes.addTo(mapa)

        // Si tiene activa la opción, centra el dibujo en la capa
        // if(opciones["Incidentes"][2]) mapa.setView(new L.LatLng(6.17458,-75.34900), 17)
    }

    /***************************************************
     *** Dibujo de inventario de señales verticales ****
     **************************************************/
    if(opciones["Senales_Verticales"][0]){
        // Se dibuja la capa
        var capa_senales_verticales = dibujar_senales_verticales(mapa, filtros)

        // Se agrega la capa
        capas["Señales verticales"] = capa_senales_verticales

        // Si tiene activa la opción de dibujar las abscisas
        if(opciones["Senales_Verticales"][1]) capa_senales_verticales.addTo(mapa)

        // Si tiene activa la opción, centra el dibujo en la capa
        // if(opciones["Senales_Verticales"][2]) mapa.setView(new L.LatLng(6.17458,-75.34900), 17)
    }

    // Variable para mantener la ubicación del mapa
    var hash = new L.Hash(mapa)

    // Se agregan las capas de mapas
    var capas_mapas = agregar_capas_mapas(mapa, opciones.Capa_Mapa)
    
    if(!control) var control = L.control.layers(capas_mapas, capas).addTo(mapa)
}