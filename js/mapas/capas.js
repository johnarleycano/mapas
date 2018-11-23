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
        var capa_eventos_diarios = dibujar_incidentes(mapa, opciones)

        // Si tiene activa la opción de dibujar los eventos diarios
        if(typeof opciones["Eventos_Diarios"] !== 'undefined' && opciones["Eventos_Diarios"][1]){
            // Se adiciona la capa
            mapa.addLayer(capa_eventos_diarios)

            // Se Chequea la capa
            $("#eventos_diarios").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#eventos_diarios").on("click", function(){
            if ($(this).prop('checked')){
                mapa.addLayer(capa_eventos_diarios)
                $(this).prop("checked", true)
            } else {
                mapa.removeLayer(capa_eventos_diarios)
                $(this).prop("checked", false)
            }
        })

        // Si tiene activa la opción, centra el dibujo en la capa
        // if(opciones["Eventos_Diarios"][2]) mapa.setView(new L.LatLng(6.17458,-75.34900), 17)
    }
    
    /***************************************************
     ************* Dibujo de fotos aéreas **************
     **************************************************/
     // Si tiene activa la carga de fotos aéreas
    if(typeof opciones["Fotos_Aereas"] !== 'undefined' && opciones["Fotos_Aereas"][0]){
        // Se dibuja la capa
        var capa_fotos_aereas = dibujar_fotos_aereas(mapa, opciones)

        // Si tiene activa la opción de dibujar
        if(typeof opciones["Fotos_Aereas"] !== 'undefined' && opciones["Fotos_Aereas"][1]){
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

    /***************************************************
     **** Dibujo de mediciones de rocería y cunetas ****
     **************************************************/
    // Si tiene activa la carga de mediciones
    if(typeof opciones["Roceria_Cuneta"] !== 'undefined' && opciones["Roceria_Cuneta"][0]){
        // Se dibuja la capa
        var capa_roceria_cuneta = dibujar_roceria_cuneta(mapa, filtros)

        // Si tiene activa la opción de dibujar las abscisas
        if(opciones["Roceria_Cuneta"][1]) capa_roceria_cuneta.addTo(mapa)

        // Si tiene activa la opción, centra el dibujo en la capa
        if(opciones["Roceria_Cuneta"][2]) mapa.fitBounds(capa_roceria_cuneta.getBounds())
    }

    /***************************************************
     **************** Dibujo de predios ****************
     **************************************************/
     // Si tiene activa la carga de predios
    if(typeof opciones["Predios"] !== 'undefined' && opciones["Predios"][0]){
        // Se dibuja la capa
        var capa_predios = dibujar_predios(mapa, opciones)

        // Si tiene activa la opción de dibujar
        if(typeof filtros["opciones"]["Predios"] !== 'undefined' && filtros["opciones"]["Predios"][1]){
            // Se adiciona la capa
            mapa.addLayer(capa_predios)

            // Se Chequea la capa
            $("#predios").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#predios").on("click", function(){
            if ($(this).prop('checked')){
                mapa.addLayer(capa_predios)
                $(this).prop("checked", true)
            } else {
                mapa.removeLayer(capa_predios)
                $(this).prop("checked", false)
            }
        })

        // Si tiene activa la opción, centra el dibujo en la capa
        if(opciones["Predios"][2]) mapa.fitBounds(capa_predios.getBounds())
    }

    /***************************************************
     *** Dibujo de medición de señales horizontales ****
     **************************************************/
    if(typeof opciones["Senales_Horizontales"] !== 'undefined' && opciones["Senales_Horizontales"][0]){
        // Se dibuja la capa
        var capa_senales_horizontales = dibujar_senales_horizontales(mapa, filtros)

        // Si tiene activa la opción de dibujar
        if(typeof filtros["opciones"]["Senales_Horizontales"] !== 'undefined' && filtros["opciones"]["Senales_Horizontales"][1]){
            // Se adiciona la capa
            mapa.addLayer(capa_senales_horizontales)

            // Se Chequea la capa
            $("#senales_horizontales").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#senales_horizontales").on("click", function(){
            capa = $(this).attr("id")

            if ($(this).prop('checked')){
                mapa.addLayer(capa_senales_horizontales)
                $(this).prop("checked", true)
            } else {
                mapa.removeLayer(capa_senales_horizontales)
                $(this).prop("checked", false)
            }
        })

        // Si tiene activa la opción, centra el dibujo en la capa
        if(opciones["Senales_Horizontales"][2]) mapa.fitBounds(capa_senales_horizontales.getBounds())
    }

    // Variable para mantener la ubicación del mapa
    var hash = new L.Hash(mapa)

    // Se agregan los mapas base
    var mapas_base = agregar_mapas_base(mapa, opciones.Mapa_Base)

    cerrar_notificaciones()
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
            return L.marker(latlng, {"icon": icono}).bindPopup(contenido, { 'minWidth': '640', 'height': '480' }) 
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
    var anio = ($("#select_anio_incidente_filtro").val()) ? $("#select_anio_incidente_filtro").val() : filtros.anio 
    var mes = ($("#select_mes_incidente_filtro").val()) ? $("#select_mes_incidente_filtro").val() : filtros.mes
    var dia = (typeof filtros.dia) ? filtros.dia : null

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
        "dia": dia,
        "id_tipo_atencion": id_tipo_atencion,
    }

    // Información de la capa
    var capa_incidentes = new L.geoJson(null, {
        pointToLayer: function (feature, latlng) {
            const color = feature.properties["color"]

            const estilo =
            `
                width: 100px; 
                height: 150px; 
                border: 3px solid #555; 
                // background: #428bca;
                -webkit-transform: rotate(45deg);
                -moz-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                -o-transform: rotate(45deg);
                transform: rotate(45deg);
            `
            var icono = new L.Icon({
                "iconUrl": `${$("#url_base").val()}img/iconos/operaciones/${feature.properties["icono"]}.svg`,
                "iconSize": [25, 25],
            })

            const myCustomColour = '#583470'

            const markerHtmlStyles = `
              background-color: ${myCustomColour};
              width: 3rem;
              height: 3rem;
              display: block;
              left: -1.5rem;
              top: -1.5rem;
              position: relative;
              border-radius: 3rem 3rem 0;
              transform: rotate(45deg);
              border: 1px solid #FFFFFF`

            const icon = L.divIcon({
              // className: "my-custom-pin",
                "iconSize": [25, 25],
              // iconAnchor: [0, 24],
              // labelAnchor: [-6, 0],
              // popupAnchor: [0, -36],
                // iconUrl: `${$("#url_base").val()}img/iconos/operaciones/accidente.svg`,
              html: `<span style="${markerHtmlStyles}" />`
            })

            var contenido =
            `
                <h4><b>${feature.properties["nombre"]} en la abscisa ${feature.properties["abscisa_real"]}</b></h4>
                <b>Fecha:</b> ${feature.properties["fechaincidente"]}<br>
                <b>Hora:</b> ${feature.properties["horaincidente"]}<br>
            `

            // Se retorna el marcador
            return L.marker(latlng, {
                icon: L.ExtraMarkers.icon({
                    // icon: 'plus sign',
                    innerHTML: feature.properties["icono_svg"],
                    // innerHTML: `
                        // <svg aria-hidden="true" viewBox="-300 -250 1100 1100" data-prefix="fas" fill="#FFFFFF" role="img" xmlns="http://www.w3.org/2000/svg">
                          // 
                        // </svg>
                    // `,
                    // circle, square, star, penta
                    shape: feature.properties["forma_marcador"],
                    // 'red', 'orange-dark', 'orange', 'yellow', 'blue-dark', 'cyan', 'purple', 'violet', 'pink', 'green-dark', 'green', 'green-light', 'black', or 'white'
                    markerColor: feature.properties["color_marcador"],
                    prefix: 'icon',
                    // iconColor: '#B3B1EB'
                })
            }).bindPopup(contenido)
            // return L.marker(latlng, {
            //   icon: icon
            // }).bindPopup(contenido)
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
 * Dibujo de las mediciones de rocería y cunetas
 * 
 * @param  {map}    mapa        [Mapa]
 * @param  {array}  filtros     [Arreglo de filtros y opciones]
 * @return {layer}              [Capa de mediciones]
 */
function dibujar_roceria_cuneta(mapa, filtros)
{
    // Datos
    var datos = filtros.opciones.datos

    // Información de la capa
    var capa_roceria_cuneta = new L.geoJson(null, {
        style: function (feature){
            return {
                opacity: 1,
                color: `rgba(${feature.properties.Color},1.0)`,
                lineCap: 'square',
                lineJoin: 'bevel',
                weight: 6,
                fillOpacity: 0,
            }
        },
        onEachFeature: function (feature, layer) {
            var contenido =
            `
            <b>Abscisa:</b> ${feature.properties["Abscisa"]}<br>
            <b>Fecha de medición:</b> ${feature.properties["Fecha"]}<br>
            <b>Hora de medición:</b> ${feature.properties["Hora"]}<br>
            <b>Factor externo:</b> ${(feature.properties["Factor_Externo"] == 1) ? "Si" : "No"}<br>
            `
            return layer.bindPopup(contenido, {maxHeight: 400})
        },
    })
        
    // Consulta de la medición
    let roceria_cuneta = ajax(`${$("#url").val()}/mediciones/obtener`, {"tipo": "roceria_cuneta", "id": datos}, 'JSON')

    // Se agregan los datos a la capa
    capa_roceria_cuneta.addData(roceria_cuneta)

    // Se retorna la capa
    return capa_roceria_cuneta
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

/**
 * Dibujo de la capa de predios
 * 
 * @param  {map}        mapa        [Mapa]
 * @param  {array}      filtros     [Arreglo de filtros y opciones]
 * @return {layer}                  [Capa de predios]
 */
function dibujar_predios(mapa, filtros){
    imprimir("Dibujando predios")
    // Información de los predios
    var capa_predios = new L.geoJson(null, {
        style: {
            "color": "red",
            "weight": 5,
            "opacity": 1,
            "fillOpacity": 0,
        },
        onEachFeature: function(feature, layer) {
            

                    // Contenido del popup
            var contenido =
            `
                <center><h5><b>${feature.properties['ficha_predial']}</b></h5></center>
                <table>
                    <tr>
                        <td><b>Municipio</b></td>
                        <td>${feature.properties['municipio']}</td>
                    </tr>
                    <tr>
                        <td><b>Abscisa inicial</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Abscisa final</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Propietario</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Área requerida</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Cédula catastral</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Estado del proceso</b></td>
                        <td></td>
                    </tr>
                </table>
            `

            // Se agrega el contenido al popup
            layer.bindPopup(contenido, {"minWidth": 320})

            // Polígono
            var poligono = L.polygon(feature.geometry.coordinates).bindPopup(contenido)

            var titulo = L.marker(layer.getBounds().getCenter(), {
                icon: L.divIcon({
                    className: 'uk-text-center',
                    html: `<strong style="color: white;">${feature.properties['ficha_predial']}</strong>`,
                    iconSize: [250, 40]
                })
            })
            // .addTo(mapa)


        },
    //     pointToLayer: function (feature, latlng) {
    //         // Ícono
    //         var icono = new L.Icon({
    //             "iconUrl": `${$("#url_base").val()}img/iconos/inventario/obras/icono.svg`,
    //             "iconSize": [76, 76],
    //             "iconAnchor": [38, 30],
    //         })
            
    //         // Marcador
    //         return L.marker(latlng, {icon: icono, rotationAngle: feature.properties.direccion})
    //     },
    //     onEachFeature: function(feature, layer) {
    
    //     },
    })

    // // Cuadro del perímetro del que va a cargar los datos
    // var perimetro = mapa.getBounds().toBBoxString()

    // Consulta de los predios
    var predios = ajax(`${$("#url").val()}/predios/obtener`, {"tipo": "listado"}, 'JSON')
    imprimir(predios)

    // Se agregan los datos a la capa
    capa_predios.addData(predios)

    // // Cuando se mueva el mapa
    // mapa.on('moveend', function(e) {
    //     // Se limpian las señales
    //     capa_predios.clearLayers()

    //     // Se consultan las señales en el perímetro
    //     obras = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "obras", "id": {"id_sector": null, "id_via": null, "perimetro": mapa.getBounds().toBBoxString()}}, 'JSON')

    //     // Se agregan a la capa
    //     capa_predios.addData(obras)
    // })

    // Se retorna la capa
    return capa_predios
}

/**
 * Dibujo de la capa de mediciones de señales horizontales
 * 
 * @param  {map}        mapa        [Mapa]
 * @param  {array}      filtros     [Arreglo de filtros y opciones]
 * @return {layer}                  [Capa de medición de señales horizontales]
 */
function dibujar_senales_horizontales(mapa, filtros){
    // Datos
    var datos = filtros.opciones.datos

    // Información de las señales verticales
    var capa_senales_horizontales = new L.geoJson(null, {
        style: function (feature){
            var color_rgb
            var color = feature.properties.color
            var promedio = feature.properties.promedio

            // Color de la vía
            if(color == "Blanco" && promedio < 140) color_rgb = "rgba(255,0,0,1.0)"
            if(color == "Blanco" && promedio >= 140) color_rgb = "rgba(21,116,36,1.0)"
            if(color == "Amarillo" && promedio < 120) color_rgb = "rgba(255,0,0,1.0)"
            if(color == "Amarillo" && promedio >= 120) color_rgb = "rgba(21,116,36,1.0)"

            return {
                opacity: 1,
                color: color_rgb,
                lineCap: 'square',
                lineJoin: 'bevel',
                weight: 6,
                fillOpacity: 0,
            }
        },
        onEachFeature: function (feature, layer) {
            var contenido =
            `
            <b>Kilómetro:</b> ${parseInt(feature.properties["entero"])/1000}<br>
            <b>Fecha de medición:</b> ${$("#fecha_activa").val()}<br>
            <b>Promedio:</b> ${feature.properties["promedio"]}<br>
            `
            return layer.bindPopup(contenido, {maxHeight: 400})
        },
    })

    // Consulta de las señales horizontales
    let senales_horizontales = ajax(`${$("#url").val()}/mediciones/obtener`, {"tipo": "senales_horizontales", "id": datos}, 'JSON')

    // Se agregan los datos a la capa
    capa_senales_horizontales.addData(senales_horizontales)

    // Se retorna la capa
    return capa_senales_horizontales
}