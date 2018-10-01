function agregar_mapas_base(mapa, capa = "bing")
{
    // Mapa de Bing
    var bing = new L.BingLayer("Pl2wXFOEKQ0lIT6FDWrM~7S7lA5j_F2sDUhSdCeQVzw~AvN-ATn5N1EQzxbEEBkYWNUYY1AyXIzXPwXex81xLAN1RyJYJaML4e2gD9QTzsIU", {
        type: "Aerial"
    })

    // Mapa de Open Street
    var open_street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    })

    // Mapa de Open Street en gris
    var open_street_dark = L.tileLayer('http://{s}.www.toolserver.org/tiles/bw-mapnik/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
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

    return mapas_base
}

function agregar_cartografia_base(mapa, filtros)
{
   var capa

    // Almacenamiento de los mapas
    var cartografia_base = {}

    /***************************************************
     ***************** Dibujo de vías ******************
     **************************************************/
    // Se dibuja la capa
    var capa_vias = dibujar_vias(mapa, filtros)

    // Se agrega la capa
    cartografia_base["vias"] = capa_vias

    // Si tiene activa la opción de dibujar las vías
    if(typeof filtros["opciones"]["Vias"] !== 'undefined' && filtros["opciones"]["Vias"][1]){
        // Se adiciona la capa
        mapa.addLayer(capa_vias)
        // Se Chequea la capa
        $("#vias").prop("checked", true)
    }
        
    // Cuando se selecciona otro mapa base
    $("#vias").on("click", function(){
        capa = $(this).attr("id")

        if ($("#vias").prop('checked')){
            mapa.addLayer(capa_vias)
            $("#vias").prop("checked", true)
        } else {
            mapa.removeLayer(capa_vias)
            $("#vias").prop("checked", false)
        }
    })

    /***************************************************
     ************** Dibujo de kilómetros ***************
     **************************************************/
     // Se dibuja la capa
    var capa_kilometros = dibujar_kilometros(mapa, filtros)

    // Se agrega la capa
    cartografia_base["kilometros"] = capa_kilometros

    // // Si tiene activa la opción de dibujar las abscisas
    if(typeof filtros["opciones"]["Kilometros"] !== 'undefined' && filtros["opciones"]["Kilometros"][1]){
        // Se adiciona la capa
        mapa.addLayer(capa_kilometros)
        // Se Chequea la capa
        $("#kilometros").prop("checked", true)
    }
        
    // Cuando se selecciona otro mapa base
    $("#kilometros").on("click", function(){
        capa = $(this).attr("id")

        if ($("#kilometros").prop('checked')){
            mapa.addLayer(capa_kilometros)
            $("#kilometros").prop("checked", true)
        } else {
            mapa.removeLayer(capa_kilometros)
            $("#kilometros").prop("checked", false)
        }
    })

    /***************************************************
     ************** Dibujo de municipios ***************
     **************************************************/
     // Se dibuja la capa
    var capa_municipios = dibujar_municipios(mapa, filtros)

    // Se agrega la capa
    // cartografia_base["Municipios"] = capa_municipios

    // Si tiene activa la opción de dibujar las abscisas
    if(typeof filtros["opciones"]["Municipios"] !== 'undefined' && filtros["opciones"]["Municipios"][1]){
        // Se adiciona la capa
        mapa.addLayer(capa_municipios)
    
        // Se Chequea la capa
        $("#municipios").prop("checked", true)
    }
        
    // Cuando se selecciona otro mapa base
    $("#municipios").on("click", function(){
        capa = $(this).attr("id")

        if ($(this).prop('checked')){
            mapa.addLayer(capa_municipios)
            $(this).prop("checked", true)
        } else {
            mapa.removeLayer(capa_municipios)
            $(this).prop("checked", false)
        }
    })

    // // Si tiene activa la opción, centra el dibujo en la capa
    // if(filtros["opciones"]["Vias"][2]) mapa.fitBounds(capa_vias.getBounds())
    // if(filtros["opciones"]["Abscisas"][2]) mapa.fitBounds(capa_abscisas.getBounds())
}

function generar_mapa(contenedor, opciones = null)
{
    if (opciones) {
        var zoom = (typeof opciones.zoom !== 'undefined' || !opciones.zoom) ? opciones.zoom : 18
        var zoom_minimo = (typeof opciones.minZoom !== 'undefined' || !opciones.zoom) ? opciones.minZoom : 15
        var zoom_maximo = (typeof opciones.maxZoom !== 'undefined' || ! opciones.zoom) ? opciones.maxZoom : 18
        var control_zoom = (typeof opciones.zoomControl !== 'undefined' || ! opciones.zoom) ? opciones.zoomControl : true
    }

    // Opciones del mapa
    let mapa = L.map(contenedor, {
        "center": [6.176188, -75.354868],
        "zoomControl": control_zoom,
        "zoom": zoom,
        "maxZoom": zoom_maximo,
        "maxZoom": zoom_maximo,
    })

    // Se agregan los controles
    agregar_controles(mapa)

    // Se retorna el mapa
    return mapa
}

function agregar_controles(mapa)
{
    // Posición del control zoom movida a la derecha
    mapa.zoomControl.setPosition('topright')

    // Control de escala
    let escala = L.control.scale({ position: 'bottomright', imperial: false})
    mapa.addControl(escala)

    // Control de ubicación actual
    var ubicacion_actual = L.control.locate({ position: 'topright'})
    ubicacion_actual.addTo(mapa)
}

function dibujar_vias(mapa, filtros)
{
    // Se consultan las vías    
    var kilometros = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id": {"id_sector": filtros.id_sector, "id_via": filtros.id_via}}, 'JSON')

    // Se agrega la capa de vías
    return new L.geoJson(kilometros, {
        style: {
            "color": "#FACD00",
            "weight": 5,
            "opacity": 1
        }
    })
}

function dibujar_kilometros(mapa, filtros)
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

function dibujar_fotos_aereas(mapa, opciones)
{
    return L.geoJson(json_cvb_0, {
        attribution: '<a href=""></a>',
        pointToLayer: function (feature, latlng) {
            var contenido = `
                <img src='${$("#url_base").val()}/archivos/inventario/fotos_aereas/${feature.properties['Name']}' width='auto'/>
            `
            var icono = L.icon({
                iconUrl: `${$("#url_base").val()}img/iconos/foto.svg`,
                iconSize: [20, 20],
                popupAnchor: [0,-15]
            })

            return L.marker(latlng, {"icon": icono}).bindPopup(contenido,  { 'minWidth': '640' }).bindPopup(contenido)        
        },
    })
}

function dibujar_incidentes(mapa, filtros)
{
    var anio = $("#select_anio_incidente_filtro").val()
    var mes = $("#select_mes_incidente_filtro").val()
    var tipo_atencion = $("#select_tipo_atencion_filtro").val()

    anio = (anio || anio > 0) ? anio : null
    mes = (mes || mes > 0) ? mes : null
    id_tipo_atencion = (tipo_atencion || tipo_atencion > 0) ? tipo_atencion : null

    var datos = {
        "id_sector": null,
        "id_via": null,
        "anio": anio,
        "mes": mes,
        "id_tipo_atencion": id_tipo_atencion,
    }
    // imprimir(datos)

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
                "iconUrl": `${$("#url_base").val()}img/iconos/inventario/senales_verticales/${codigo}.svg`,
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
                    <img src="${$("#url_base").val()}archivos/inventario/senales_verticales/${feature.properties['archivo']}" />
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

function dibujar_obras(mapa, filtros){
    // Información de las obras
    var capas_obras = new L.geoJson(null, {
        pointToLayer: function (feature, latlng) {
            // Ícono
            var icono = new L.Icon({
                "iconUrl": `${$("#url_base").val()}img/iconos/inventario/obras/icono.svg`,
                "iconSize": [76, 76],
                "iconAnchor": [38, 30],
            })
            
            // Marcador
            return L.marker(latlng, {icon: icono, rotationAngle: feature.properties.direccion})
        },
        onEachFeature: function(feature, layer) {
            var contenido =
            `
                <h4><b>Obra de arte número ${feature.properties['numero']}</b></h4>
                <b>Abscisa:</b> ${(feature.properties['abscisa']) ? feature.properties['abscisa'] : ""}<br>
                <b>Tipo:</b> ${(feature.properties['tipo']) ? feature.properties['tipo'] : ""}<br>
                <b>Obra:</b> ${(feature.properties['obra']) ? feature.properties['obra'] : ""}<br>
                <b>Ancho:</b> ${(feature.properties['ancho']) ? feature.properties['ancho'] : ""}<br>
                <b>Altura:</b> ${(feature.properties['altura']) ? feature.properties['altura'] : ""}<br>
                <b>Encole (I/D):</b> ${(feature.properties['encole_i_d']) ? feature.properties['encole_i_d'] : ""}<br>
                <b>Descole (I/D):</b> ${(feature.properties['descole_i_d']) ? feature.properties['descole_i_d'] : ""}<br>
                <b>Longitud:</b> ${(feature.properties['longitud']) ? feature.properties['longitud'] : ""}<br>
                <b>Entrada:</b> ${(feature.properties['entrada']) ? feature.properties['entrada'] : ""}<br>
                <b>Salida:</b> ${(feature.properties['salida']) ? feature.properties['salida'] : ""}<br><br>
                <b>Observación:</b> ${(feature.properties['observacion']) ? feature.properties['observacion'] : ""}<br>
            `

            layer.bindPopup(contenido, {maxHeight: 400})
        },
    })

    // Cuadro del perímetro del que va a cargar los datos
    var perimetro = mapa.getBounds().toBBoxString()

    // Consulta de las obras de arte
    obras = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "obras", "id": {"id_sector": null, "id_via": null, "perimetro": perimetro}}, 'JSON')

    // Se agregan los datos a la capa
    capas_obras.addData(obras)

    // Cuando se mueva el mapa
    mapa.on('moveend', function(e) {
        // Se limpian las señales
        capas_obras.clearLayers()

        // Se consultan las señales en el perímetro
        obras = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "obras", "id": {"id_sector": null, "id_via": null, "perimetro": mapa.getBounds().toBBoxString()}}, 'JSON')

        // Se agregan a la capa
        capas_obras.addData(obras)
    })

    return capas_obras
}

function dibujar_municipios(mapa, filtros){
    // Información de los municipios
    
    var capas_municipios = new L.geoJson(null, {
        style: function(feature){

        },
        onEachFeature: function(feature, layer) {
            return L.polygon(feature.geometry.coordinates)
        },
    })

    // Consulta de los municipios
    municipios = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "municipios_geometria", "id": {"id_sector": null, "id_via": null}}, 'JSON')

    // Se agregan los datos a la capa
    capas_municipios.addData(municipios)

    return capas_municipios
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

    // Variables de filtros
    var filtros = {
        "id_sector": (sector || sector > 0) ? sector : null,
        "id_via": (via || via > 0) ? via : null,
    }

    filtros["opciones"] = opciones 

    // Se recorren los layers
    mapa.eachLayer(function (layer) {
        // Se elimina cada layer
        mapa.removeLayer(layer);
    })

    agregar_cartografia_base(mapa, filtros)
    
    /***************************************************
     ******* Dibujo de incidentes de operaciones *******
     **************************************************/
    // Si tiene activa la carga de incidentes
    if(typeof opciones["Incidentes"] !== 'undefined' && opciones["Incidentes"][0]){
        // Se dibuja la capa
        var capa_incidentes = dibujar_incidentes(mapa, filtros)

        // Si tiene activa la opción de dibujar las abscisas
        if(opciones["Incidentes"][1]) capa_incidentes.addTo(mapa)

        // Si tiene activa la opción, centra el dibujo en la capa
        // if(opciones["Incidentes"][2]) mapa.setView(new L.LatLng(6.17458,-75.34900), 17)
    }

    /***************************************************
     *** Dibujo de inventario de señales verticales ****
     **************************************************/
    if(typeof opciones["Senales_Verticales"] !== 'undefined' && opciones["Senales_Verticales"][0]){
        // Se dibuja la capa
        var capa_senales_verticales = dibujar_senales_verticales(mapa, filtros)

        // Si tiene activa la opción de dibujar
        if(typeof filtros["opciones"]["Senales_Verticales"] !== 'undefined' && filtros["opciones"]["Senales_Verticales"][1]){
            // Se adiciona la capa
            mapa.addLayer(capa_senales_verticales)

            // Se Chequea la capa
            $("#senales_verticales").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#senales_verticales").on("click", function(){
            capa = $(this).attr("id")

            if ($(this).prop('checked')){
                mapa.addLayer(capa_senales_verticales)
                $(this).prop("checked", true)
            } else {
                mapa.removeLayer(capa_senales_verticales)
                $(this).prop("checked", false)
            }
        })

        // Si tiene activa la opción, centra el dibujo en la capa
        // if(opciones["Senales_Verticales"][2]) mapa.setView(new L.LatLng(6.17458,-75.34900), 17)
    }
    
    /***************************************************
     **** Dibujo de eventos diarios de operaciones *****
     **************************************************/
     // Si tiene activa la carga de eventos diarios
    if(typeof opciones["Eventos_Diarios"] !== 'undefined' && opciones["Eventos_Diarios"][0]){
        // Se dibuja la capa
        var capa_eventos_diarios = dibujar_eventos_diarios(mapa, opciones)
        imprimir(opciones)

        // // Se agrega la capa
        // capas["Incidentes"] = capa_incidentes

        // // Si tiene activa la opción de dibujar las abscisas
        // if(opciones["Incidentes"][1]) capa_incidentes.addTo(mapa)

        // Si tiene activa la opción, centra el dibujo en la capa
        // if(opciones["Incidentes"][2]) mapa.setView(new L.LatLng(6.17458,-75.34900), 17)
    }
    
    /***************************************************
     ************* Dibujo de fotos aéreas **************
     **************************************************/
     // Si tiene activa la carga de fotos aéreas
    if(typeof opciones["Fotos_Aereas"] !== 'undefined' && opciones["Fotos_Aereas"][0]){
        // Se dibuja la capa
        var capa_fotos_aereas = dibujar_fotos_aereas(mapa, opciones)

        // Si tiene activa la opción de dibujar
        if(typeof opciones["Fotos_Aereas"] !== 'undefined' && opciones["Fotos_Aereas"][0]){
            // Se adiciona la capa
            mapa.addLayer(capa_fotos_aereas)

            // Se Chequea la capa
            $("#fotos_aereas").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#fotos_aereas").on("click", function(){
            capa = $(this).attr("id")

            if ($(this).prop('checked')){
                mapa.addLayer(capa_fotos_aereas)
                $(this).prop("checked", true)
            } else {
                mapa.removeLayer(capa_fotos_aereas)
                $(this).prop("checked", false)
            }
        })

        // Si tiene activa la opción, centra el dibujo en la capa
        // if(opciones["Fotos_Aereas"][2]) mapa.setView(new L.LatLng(6.17458,-75.34900), 17)
    }
    
    /***************************************************
     ************* Dibujo de obras de arte *************
     **************************************************/
     // Si tiene activa la carga de obras de arte
    if(typeof opciones["Obras"] !== 'undefined' && opciones["Obras"][0]){
        // Se dibuja la capa
        var capa_obras = dibujar_obras(mapa, opciones)

        // Si tiene activa la opción de dibujar
        if(typeof filtros["opciones"]["Obras"] !== 'undefined' && filtros["opciones"]["Obras"][1]){
            // Se adiciona la capa
            mapa.addLayer(capa_obras)

            // Se Chequea la capa
            $("#obras").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#obras").on("click", function(){
            capa = $(this).attr("id")

            if ($(this).prop('checked')){
                mapa.addLayer(capa_obras)
                $(this).prop("checked", true)
            } else {
                mapa.removeLayer(capa_obras)
                $(this).prop("checked", false)
            }
        })

        // // Si tiene activa la opción, centra el dibujo en la capa
        // if(opciones["Fotos_Aereas"][2]) mapa.setView(new L.LatLng(6.17458,-75.34900), 17)
    }

    // Variable para mantener la ubicación del mapa
    var hash = new L.Hash(mapa)

    // Se agregan los mapas base
    var mapas_base = agregar_mapas_base(mapa, opciones.Mapa_Base)
    
    // var control = L.control.layers(null, capas).addTo(mapa)
}