/**
 * Dibuja
 * @param  {string}     contenedor  [Contenedor donde se abrirá el mapa]
 * @param  {array}      opciones    [Arreglo con las capas y opciones configurables]
 * @return {map}                    [Mapa creado]
 */
function crear(contenedor, opciones = null)
{
    // Variables por defecto
    var zoom = 16
    var zoom_minimo = 16
    var zoom_maximo = 19
    var control_zoom = true
    var ubicacion_actual = true

    // Si hay opciones a configurar
    if(opciones) {
        // Se cambia la opción de acuerdo a lo parametrizado
        if (typeof opciones.zoom !== 'undefined' || opciones.zoom) zoom = opciones.zoom
        if (typeof opciones.minZoom !== 'undefined' || opciones.minZoom) zoom_minimo = opciones.minZoom
        if (typeof opciones.maxZoom !== 'undefined' || opciones.maxZoom) zoom_maximo = opciones.maxZoom
        if (typeof opciones.zoomControl !== 'undefined' || opciones.zoomControl) control_zoom = opciones.zoomControl
    }

    // Opciones del mapa
    let mapa = L.map(contenedor, {
        "center": [6.176188, -75.354868],
        "zoomControl": control_zoom,
        "zoom": zoom,
        "maxZoom": zoom_maximo,
        "minZoom": zoom_minimo,
    })

    // Se agregan los controles
    agregar_controles(mapa, opciones)

    // Se retorna el mapa
    return mapa
}

// Pendiente
function dibujar_eventos_diarios(mapa, opciones){
    // // Información de los eventos diarios
    var capa_eventos_diarios = new L.geoJson(null, {
        pointToLayer: function (feature, latlng) {
    //         // Código del ícono
    //         var codigo = String(feature.properties["codsen"]).toUpperCase()

    //         // Ícono
    //         var smallIcon = new L.Icon({
    //             "iconSize": [21, 21],
    //             "iconUrl": `${$("#url_base").val()}img/iconos/senales_verticales/${codigo}.svg`,
    //         })
            
    //         // Marcador
    //         return L.marker(latlng, {icon: smallIcon});
    //     },
    //     onEachFeature: function pop_SealesVerticales_1(feature, layer) {
    //         var popupContent =
    //             `
    //             <b>Kilómetro:</b> ${(feature.properties['kilómetro']) ? feature.properties['kilómetro'] : ''}<br>
    //             <b>Margen:</b> ${(feature.properties['costado']) ? feature.properties['costado'] : ''}<br>
    //             <b>Código de señal:</b> ${(feature.properties['codseñal']) ? feature.properties['codseñal'] : ''}<br>
    //             <b>Color:</b> ${(feature.properties['color']) ? feature.properties['color'] : ''}<br>
    //             <b>Fecha:</b> ${(feature.properties['fechainspe']) ? feature.properties['fechainspe'] : ''}<br>
    //             <b>Medición:</b> ${(feature.properties['medición']) ? feature.properties['medición'] : ''}<br>
    //             <b>Observación:</b> ${(feature.properties['observ']) ? feature.properties['observ'] : ''}<br>
    //             <b>Antigraf:</b> ${(feature.properties['antigraf']) ? feature.properties['antigraf'] : ''}<br>
    //             <center>
    //                 <img src="${$("#url_base").val()}DCIM/${feature.properties['archivo']}" />
    //             </center>
    //             `
    //         layer.bindPopup(popupContent, {maxHeight: 400});
        },
    })

    // // Cuadro del perímetro del que va a cargar los datos
    // var perimetro = mapa.getBounds().toBBoxString()

    // Consulta de los accidentes diarios
    // accidentes_diarios = ajax(`${$("#url").val()}/operaciones/obtener`, {"tipo": "accidentes_dia", "id": opciones.Dia}, 'JSON')
    // imprimir(accidentes_diarios)

    // // Se agregan los datos a la capa
    // capa_eventos_diarios.addData(senales_verticales)

    // // Cuando se mueva la capa
    // mapa.on('moveend', function(e) {
    //     // Se limpian las señales
    //     capa_eventos_diarios.clearLayers()

    //     // Se consultan las señales en el perímetro
    //     senales_verticales = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "senales_verticales", "id": {"id_sector": filtros.id_sector, "id_via": filtros.id_via, "perimetro": mapa.getBounds().toBBoxString()}}, 'JSON')

    //     // Se agregan a la capa
    //     capa_eventos_diarios.addData(senales_verticales)
    // })

    // // Se agrega la capa
    // // mapa.addLayer(capa_eventos_diarios)

    // return capa_eventos_diarios
}



function generar_marcador(punto) {
    imprimir(`Has elegido crear un marcador en las coordenadas ${punto.latlng}`)
}

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