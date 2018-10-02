/**
 * Dibujo de capas en el mapa
 * 
 * @param  {map}        mapa        [Mapa]
 * @param  {array}      opciones    [Arreglo de opciones]
 * @return
 */
function dibujar_capas(mapa, opciones)
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

    // Se agregan las opciones de los filtros
    filtros["opciones"] = opciones 

    // Se recorren los layers
    mapa.eachLayer(function (layer) {
        // Se elimina cada layer
        mapa.removeLayer(layer);
    })

    // Se agrega la cartografía base
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
}

/**
 * Dibujo de las fotos aéreas capturadas en campo
 * 
 * @param  {map}        mapa        [Mapa]
 * @param  {array}      opciones    [Arreglo de opciones]
 * @return {layer}                  [Capa de fotos aéreas]
 */
function dibujar_fotos_aereas(mapa, opciones)
{
    // Información de la capa
    var capa_fotos_aereas = new L.geoJson(null, {
        pointToLayer: function (feature, latlng) {
            // Url de la foto
            var url = `${$("#url_base").val()}/archivos/inventario/fotos_aereas/${feature.properties['Date']}/${feature.properties['Name']}`

            // Contenido del popup
            var contenido = `
                <b>Fecha de captura de la foto:</b> ${feature.properties['Date']}<br><br>
                <img src='${url}' width='auto'/>
                <a href="${url}" download>
                    <input type='submit' class='uk-button uk-button-secondary uk-button-large uk-width-1-1' value='Descargar'>
                </a>
            `

            // Parámetros del ícono
            var icono = L.icon({
                iconUrl: `${$("#url_base").val()}img/iconos/foto.svg`,
                iconSize: [20, 20],
                popupAnchor: [0,-15]
            })

            // Se retorna el marcador
            return L.marker(latlng, {"icon": icono}).bindPopup(contenido, { 'minWidth': '640', 'height': '480' }).bindPopup(contenido) 
        },
    })

    // Cuadro del perímetro del que va a cargar los datos
    var perimetro = mapa.getBounds().toBBoxString()

    // Consulta de las fotos aéreas
    var fotos_aereas = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "fotos_aereas", "id": {"perimetro": perimetro}}, 'JSON')

    // Cuando se mueva el mapa
    mapa.on('moveend', function(e) {
        // Se limpian las señales
        capa_fotos_aereas.clearLayers()

        // Se consultan las señales en el perímetro
        fotos_aereas = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "fotos_aereas", "id": {"perimetro": mapa.getBounds().toBBoxString()}}, 'JSON')

        // Se agregan a la capa
        capa_fotos_aereas.addData(fotos_aereas)
    })

    // Se agregan los datos a la capa
    capa_fotos_aereas.addData(fotos_aereas)

    // Se retorna la capa
    return capa_fotos_aereas
}

/**
 * Dibujo de los incidentes de operaciones
 * 
 * @param  {map}    mapa        [Mapa]
 * @param  {array}  filtros     [Arreglo de filtros y opciones]
 * @return {layer}              [Capa de incidentes]
 */
function dibujar_incidentes(mapa, filtros)
{
    // Variables de filtros y selects
    var anio = $("#select_anio_incidente_filtro").val()
    var mes = $("#select_mes_incidente_filtro").val()
    var tipo_atencion = $("#select_tipo_atencion_filtro").val()
    anio = (anio || anio > 0) ? anio : null
    mes = (mes || mes > 0) ? mes : null
    id_tipo_atencion = (tipo_atencion || tipo_atencion > 0) ? tipo_atencion : null

    // Datos
    var datos = {
        "id_sector": null,
        "id_via": null,
        "anio": anio,
        "mes": mes,
        "id_tipo_atencion": id_tipo_atencion,
    }

    // Información de la capa
    var capa_incidentes = new L.geoJson(null, {
        pointToLayer: function (feature, latlng) {
            // Se retorna el marcador
            return L.marker(latlng)
        },
    })

    // Consulta de incidentes
    let incidentes = ajax(`${$("#url").val()}/operaciones/obtener`, {"tipo": "incidentes", "id": datos}, 'JSON')
    
    // Se agregan los datos a la capa
    capa_incidentes.addData(incidentes)

    // Se retorna la capa
    return capa_incidentes
}

/**
 * Dibujo de la capa de obras de arte
 * 
 * @param  {map}        mapa        [Mapa]
 * @param  {array}      filtros     [Arreglo de filtros y opciones]
 * @return {layer}                  [Capa de obras de arte]
 */
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
            // Contenido del popup
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

            // Se agrega el contenido al popup
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

    // Se retorna la capa
    return capas_obras
}

/**
 * Dibujo de la capa de señalización vertical
 * 
 * @param  {map}        mapa        [Mapa]
 * @param  {array}      filtros     [Arreglo de filtros y opciones]
 * @return {layer}                  [Capa de señales verticales]
 */
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
        onEachFeature: function(feature, layer) {
            // Contenido del popup
            var contenido =
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

            // Carga de información al popup
            layer.bindPopup(contenido, {maxHeight: 400})
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

    // Se retorna la capa
    return capa_senales_verticales
}