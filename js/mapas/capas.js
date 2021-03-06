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
    let datos = opciones.datos

    // Información de la capa
    var capa_fotos_aereas = new L.geoJson(null, {
        pointToLayer: function (feature, latlng) {
            let foto = feature.properties

            // Url de la foto
            var url = `${$("#url_base").val()}/archivos/inventario/fotos_aereas/${foto.Date}/${foto.Name}`

            // Contenido del popup
            var contenido = `
                <b>Fecha de captura de la foto:</b> ${foto.Date}<br><br>
                <img src='${url}' width='auto'/>
                <p>
                    <a href="${url}" download>
                        <input type='submit' class='uk-button uk-button-secondary uk-button-large uk-width-1-1' value='Descargar'>
                    </a>
                </p>
            `

            // Parámetros del ícono
            var icono = L.icon({
                iconUrl: `${$("#url_base").val()}img/iconos/foto.svg`,
                iconSize: [20, 20],
                popupAnchor: [0,-15]
            })

            // Se retorna el marcador
            return L.marker(latlng, {"icon": icono}).bindPopup(contenido, { 'minWidth': '320', 'height': '480' }) 
        },
    })

    // Cuadro del perímetro del que va a cargar los datos
    datos.perimetro = mapa.getBounds().toBBoxString()
    // imprimir(datos)

    // Consulta de las fotos aéreas
    var fotos_aereas = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "fotos_aereas", "id": datos}, 'JSON')

    // Se consulta las vía, para buscar el área de zoom  
    let via = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id": {"id_sector": null, "id_via": datos.via}}, 'JSON')

    // Se agrega la capa de la vía
    var capa_via = new L.geoJson(via, {
        style: {
            "color": "#FACD00",
            "weight": 5,
            "opacity": 1
        },
        pane: '150',
    })

    // Se adiciona la capa
    mapa.addLayer(capa_via)

    // Cuando se mueva el mapa
    mapa.on('moveend', function(e) {
        cerrar_notificaciones()
        
        // Se limpian las señales
        capa_fotos_aereas.clearLayers()

        // // Si el zoom llega el límite
        // if(mapa.getZoom() <= 14){
        //     imprimir_notificacion(`<span uk-icon='icon: info'></span> Acerque más el mapa`, "info")
        //     return false
        // }

        // Se agrega el perímetro nuevo
        datos.perimetro = mapa.getBounds().toBBoxString()

        // Se consultan las señales en el perímetro
        fotos_aereas = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "fotos_aereas", "id": datos}, 'JSON')

        // Se agregan a la capa
        capa_fotos_aereas.addData(fotos_aereas)
    })

    // Se agregan los datos a la capa
    capa_fotos_aereas.addData(fotos_aereas)
    
    // Si tiene activa la opción, centra el dibujo en la capa
    if(opciones["Fotos_Aereas"][2]) mapa.fitBounds(capa_via.getBounds())

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
            var incidente = feature.properties

            var contenido =
            `
            <table width='100%'>
                <thead>
                    <caption><h4>Evento ${incidente["codigo"]}</h4></caption>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Tipo</b></td>
                        <td>${incidente["tipo_atencion"]}</td>
                    </tr>
                    <tr>
                        <td><b>Abscisa</b></td>
                        <td>${incidente["abscisa_real"]}</td>
                    </tr>
                    <tr>
                        <td><b>Fecha</b></td>
                        <td>${incidente["fechaincidente"]}</td>
                    </tr>
                    <tr>
                        <td><b>Hora</b></td>
                        <td>${incidente["horaincidente"]}</td>
                    </tr>
                    <tr>
                        <td><b>Lesionados</b></td>
                        <td>${incidente["heridos"]}</td>
                    </tr>
                    <tr>
                        <td><b>Víctimas fatales</b></td>
                        <td>${incidente["muertos"]}</td>
                    </tr>
                </tbody>
            </table>
            `

            // Se retorna el marcador
            return L.marker(latlng, {
                icon: L.ExtraMarkers.icon({
                    // icon: 'plus sign',
                    // prefix: 'icon',
                    // iconColor: '#B3B1EB'
                    innerHTML: feature.properties["icono_svg"],
                    // circle, square, star, penta
                    shape: feature.properties["forma_marcador"],
                    // 'red', 'orange-dark', 'orange', 'yellow', 'blue-dark', 'cyan', 'purple', 'violet', 'pink', 'green-dark', 'green', 'green-light', 'black', or 'white'
                    markerColor: feature.properties["color_marcador"],
                })
            }).bindPopup(contenido)
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
            let obra = feature.properties

            // Ícono
            var icono = new L.Icon({
                "iconUrl": `${$("#url_base").val()}img/iconos/inventario/obras/icono.svg`,
                "iconSize": [76, 76],
                "iconAnchor": [38, 30],
            })
            
            // Marcador
            return L.marker(latlng, {
                "tags": [(obra.colmatacion > 25) ? "No cumple" : "Cumple"],
                "icon": icono,
                "rotationAngle": obra.direccion
            })
        },
        onEachFeature: function(feature, layer) {
            let obra = feature.properties

            // Contenido del popup
            var contenido =
            `
                <h4><b>Obra de arte ${(obra.numero) ? obra.numero : ""}</b></h4>
                <b>Abscisa:</b> ${(obra.abscisa) ? obra.abscisa : ""}<br>
                <b>Altura:</b> ${(obra.altura) ? obra.altura : ""}<br>
                <b>Anchura:</b> ${(obra.ancho) ? obra.ancho : ""}<br>
                <b>Encole (I/D):</b> ${(obra.encole_i_d) ? obra.encole_i_d : ""}<br>
                <b>Descole (I/D):</b> ${(obra.descole_i_d) ? obra.descole_i_d : ""}<br>
                <b>Longitud:</b> ${(obra.longitud) ? obra.longitud : ""}<br>
                <b>Material:</b> ${(obra.material) ? feature.properties.material : ""}<br>
                <b>Colmatación:</b> ${(obra.colmatacion) ? obra.colmatacion : ""}<br>
                <b>Comentario:</b> ${(obra.comentario) ? obra.comentario : ""}<br>
            `

            // Se agrega el contenido al popup
            layer.bindPopup(contenido, {maxHeight: 400})
        },
    })

    var control = L.control.tagFilterButton({
        data: ['No cumple'],
        icon: `<img src="${$("#url_base").val()}img/iconos/filtro.png">`,
        filterOnEveryClick: true,
    })
    control.addTo(mapa)

    // Cuadro del perímetro del que va a cargar los datos
    var perimetro = mapa.getBounds().toBBoxString()

    // Consulta de las obras de arte
    let obras = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "obras", "id": {"id_sector": null, "id_via": null, "perimetro": perimetro}}, 'JSON')

    // Se agregan los datos a la capa
    capas_obras.addData(obras)

    // Cuando se mueva el mapa
    mapa.on('moveend', function(e) {
        cerrar_notificaciones()
        
        // Se limpian las señales
        capas_obras.clearLayers()

        // Si el zoom es menor o igual a 15, muestra mensaje
        if(mapa.getZoom() <= 13){
            imprimir_notificacion(`<span uk-icon='icon: info'></span> Acerque más el mapa`, "info")
            return false
        }

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
            let senal = feature.properties
            
            // Código del ícono
            var codigo = String(senal.codsen).toUpperCase()

            // Ícono
            var smallIcon = new L.Icon({
                "iconSize": [21, 21],
                "iconUrl": `${$("#url_base").val()}img/iconos/inventario/senales_verticales/${codigo}.svg`,
            })
            
            // Marcador
            return L.marker(latlng, {icon: smallIcon});
        },
        onEachFeature: function(feature, layer) {
            let senal = feature.properties

            // Contenido del popup
            var contenido =
                `
                <center><h4>Señal ${(senal['codseñal']) ? senal['codseñal'] : ''}</h4></center>
                <div style="display: inline-block; width: 55%; vertical-align: middle;">
                    <b>Vía:</b> ${(senal['via']) ? senal['via'] : ''}<br/>
                    <b>Abscisa:</b> ${(senal['kilómetro']) ? senal['kilómetro'] : ''}<br/>
                    <b>Margen:</b> ${(senal['costado']) ? senal['costado'] : ''}<br/>
                    <b>Color:</b> ${(senal['color']) ? senal['color'] : ''}<br/>
                    <b>Medición:</b> ${(senal['medición']) ? senal['medición'] : ''}<br/>
                    <b>Observación:</b> ${(senal['observ']) ? senal['observ'] : ''}<br/>
                    <b>Tipo de papel:</b> ${(senal['papel']) ? senal['papel'] : ''}<br/>
                    <b>Fecha instalación:</b> ${(senal['fechainsta']) ? senal['fechainsta'] : ''}<br/>
                </div>
                
                <div style="display: inline-block; width: 40%;">
                    <img src="${$("#url_base").val()}archivos/inventario/senales_verticales/${senal.archivo}" />
                </div>

                <!--<b>Fecha</b> ${(senal['fechainspe']) ? senal['fechainspe'] : ''}<br>-->
                `

            // Carga de información al popup
            layer.bindPopup(contenido, {maxHeight: 420, minWidth: 320})
        },
    })

    // Cuadro del perímetro del que va a cargar los datos
    var perimetro = mapa.getBounds().toBBoxString()

    // Consulta de las señales verticales
    let senales_verticales = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "senales_verticales", "id": {"id_sector": null, "id_via": filtros.id_via, "perimetro": perimetro}}, 'JSON')

    // Se agregan los datos a la capa
    capa_senales_verticales.addData(senales_verticales)

    // Cuando se mueva la capa
    mapa.on('moveend', function(e) {
        cerrar_notificaciones()

        // Se limpian las señales
        capa_senales_verticales.clearLayers()

        // Si el zoom es menor o igual a 15, muestra mensaje
        if(mapa.getZoom() <= 15){
            imprimir_notificacion(`<span uk-icon='icon: info'></span> Acerque más el mapa`, "info")
            return false
        }

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
    // Información de los predios
    var capa_predios = new L.geoJson(null, {
        style: function(feature) {
            return {
                "color": `#${feature.properties['color']}` ,
                "weight": 4,
                "opacity": 1,
                "fillOpacity": 0.5,
            }
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
                        <td>${feature.properties['abscisa_inicial']}</td>
                    </tr>
                    <tr>
                        <td><b>Abscisa final</b></td>
                        <td>${feature.properties['abscisa_final']}</td>
                    </tr>
                    <tr>
                        <td><b>Propietario</b></td>
                        <td>${feature.properties['propietario']}</td>
                    </tr>
                    <tr>
                        <td><b>Área requerida</b></td>
                        <td>${feature.properties['area_requerida']}</td>
                    </tr>
                    <tr>
                        <td><b>Cédula catastral</b></td>
                        <td>${feature.properties['no_catastral'].toString()}</td>
                    </tr>
                    <tr>
                        <td><b>Estado</b></td>
                        <td>${feature.properties['estado'].toString()}</td>
                    </tr>
                </table>
            `

            // Se agrega el contenido al popup
            layer.bindPopup(contenido, {"minWidth": 320})

            // Polígono
            var poligono = L.polygon(feature.geometry.coordinates).bindPopup(contenido)

            // var titulo = L.marker(layer.getBounds().getCenter(), {
            //     icon: L.divIcon({
            //         className: 'uk-text-center',
            //         html: `<strong style="color: white;">${feature.properties['ficha_predial']}</strong>`,
            //         iconSize: [250, 40]
            //     })
            // }).addTo(mapa)
        },
    })

    // // Cuadro del perímetro del que va a cargar los datos
    // var perimetro = mapa.getBounds().toBBoxString()

    // Consulta de los predios
    var predios = ajax(`${$("#url").val()}/predios/obtener`, {"tipo": "listado"}, 'JSON')

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
    // Se oculta el filtro
    $(`.leaflet-bar.easy-button-container.leaflet-control`).hide()
    
    // Datos
    var datos = filtros.opciones.datos

    // Información de las señales verticales
    var capa_senales_horizontales = new L.geoJson(null, {
        style: function (feature){
            let senal = feature.properties
            var color
            var color_verde = "rgba(21,116,36,1.0)"
            var color_rojo = "rgba(255,0,0,1.0)"
            var promedio = senal.promedio

            // Color de la vía
            if(senal.color == "Blanco" && promedio < 140) color = color_rojo, tag = "No cumple"
            if(senal.color == "Blanco" && promedio >= 140) color = color_verde, tag = "Cumple"
            if(senal.color == "Amarillo" && promedio < 120) color = color_rojo, tag = "No cumple"
            if(senal.color == "Amarillo" && promedio >= 120) color = color_verde, tag = "Cumple"

            return {
                tags: [tag],
                opacity: 1,
                color: color,
                lineCap: 'square',
                lineJoin: 'bevel',
                weight: 6,
                fillOpacity: 0,
            }
        },
        onEachFeature: function (feature, layer) {
            let senal = feature.properties
            
            var contenido =
            `
            <b>Kilómetro:</b> ${parseInt(senal.entero)/1000}<br>
            <b>Fecha de medición:</b> ${$("#fecha_activa").val()}<br>
            <b>Promedio:</b> ${senal.promedio}<br>
            `
            return layer.bindPopup(contenido, {maxHeight: 400})
        },
    })

    // Control de filtro
    var control = L.control.tagFilterButton({
        data: ['No cumple'],
        icon: `<img src="${$("#url_base").val()}img/iconos/filtro.png">`,
        filterOnEveryClick: true,
    }).addTo(mapa)

    // Se muestra el control
    $('.leaflet-top.leaflet-left').show()

    // Consulta de las señales horizontales
    let senales_horizontales = ajax(`${$("#url").val()}/mediciones/obtener`, {"tipo": "senales_horizontales", "id": datos}, 'JSON')

    // Se agregan los datos a la capa
    capa_senales_horizontales.addData(senales_horizontales)

    // Se retorna la capa
    return capa_senales_horizontales
}