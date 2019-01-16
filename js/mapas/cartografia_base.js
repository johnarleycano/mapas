/**
 * Función que adiciona los mapas 
 * de la cartografía base a cada mapa
 * 
 * @param  {map}    mapa    [Objeto mapa]
 * @param  {array}  capa    [Datos de los filtros de los mapas]
 * @return
 */
function agregar_cartografia_base(mapa, filtros)
{
    // Almacenamiento de la capa
    var capa

    // Almacenamiento de los mapas
    var cartografia_base = {}

    // Si tiene activa la opción de incluir las vías
    if(typeof filtros["opciones"]["Vias"] !== 'undefined' && filtros["opciones"]["Vias"][0]){
        /***************************************************
         ***************** Dibujo de vías ******************
         **************************************************/
        $("#vias").removeClass("uk-hidden")

        // Se dibuja la capa
        var capa_vias = dibujar_vias(mapa, filtros)

        // Se agrega la capa
        cartografia_base["vias"] = capa_vias

        // Si tiene activa la opción de dibujar las vías
        if(typeof filtros["opciones"]["Vias"] !== 'undefined' && filtros["opciones"]["Vias"][1]){
            // Se adiciona la capa
            mapa.addLayer(capa_vias)

            // Se Chequea la capa
            $("#vias>input").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#vias>input").on("click", function(){
            // Si está chequeado
            if ($(this).prop('checked')){
                // Agrega la capa
                mapa.addLayer(capa_vias)
                
                // Chequea
                $(this).prop("checked", true)
            } else {
                // Quita la capa
                mapa.removeLayer(capa_vias)
                
                // Quita el check
                $(this).prop("checked", false)
            }
        })
    }

    // Si tiene activa la opción de incluir el mapa del IGAC
    if(typeof filtros["opciones"]["IGAC"] !== 'undefined' && filtros["opciones"]["IGAC"][0]){
        /***************************************************
         **************** Dibujo de mapas ******************
         **************************************************/
        $("#gobernacion_antioquia_cartografia").removeClass("uk-hidden")

        // Z-Index
        mapa.createPane('100').style.zIndex = 100

        // Mapa IGAC
        let igac = L.esri.tiledMapLayer({
            url: "http://190.109.167.188:81/arcgis/rest/services/DAP_GisAntioquia/Mapa_Referencia/MapServer",
            maxZoom: 21,
            pane: '100',
        })

        // Se agrega la capa
        cartografia_base["igac"] = igac

        // Si tiene activa la opción de dibujar las vías
        if(typeof filtros["opciones"]["IGAC"] !== 'undefined' && filtros["opciones"]["IGAC"][1]){
            // Se adiciona la capa
            mapa.addLayer(igac)

            // Se Chequea la capa
            $("#gobernacion_antioquia_cartografia>input").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#gobernacion_antioquia_cartografia>input").on("click", function(){
            // Si está chequeado
            if ($(this).prop('checked')){
                // Agrega la capa
                mapa.addLayer(igac)
                
                // Chequea
                $(this).prop("checked", true)
            } else {
                // Quita la capa
                mapa.removeLayer(igac)
                
                // Quita el check
                $(this).prop("checked", false)
            }
        })
    }

    // Si tiene activa la opción de incluir los kilómetros
    if(typeof filtros["opciones"]["Kilometros"] !== 'undefined' && filtros["opciones"]["Kilometros"][0]){
        /***************************************************
         ************** Dibujo de kilómetros ***************
         **************************************************/
        $("#kilometros").removeClass("uk-hidden")

        // Se dibuja la capa
        var capa_kilometros = dibujar_kilometros(mapa, filtros)

        // Se agrega la capa
        cartografia_base["kilometros"] = capa_kilometros

        // Si tiene activa la opción de dibujar los kilómetros
        if(typeof filtros["opciones"]["Kilometros"] !== 'undefined' && filtros["opciones"]["Kilometros"][1]){
            // Se adiciona la capa
            mapa.addLayer(capa_kilometros)

            // Se Chequea la capa
            $("#kilometros>input").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#kilometros>input").on("click", function(){
            // Si está chequeado
            if ($("#kilometros>input").prop('checked')){
                // Agrega la capa
                mapa.addLayer(capa_kilometros)
                
                // Chequea
                $(this).prop("checked", true)
            } else {
                // Quita la capa
                mapa.removeLayer(capa_kilometros)
                
                // Quita el check
                $(this).prop("checked", false)
            }
        })
    }

    // Si tiene activa la opción de incluir los municipios
    if(typeof filtros["opciones"]["Municipios"] !== 'undefined' && filtros["opciones"]["Municipios"][0]){
        /***************************************************
         ************** Dibujo de municipios ***************
         **************************************************/
        $("#municipios").removeClass("uk-hidden")

        // Se dibuja la capa
        var capa_municipios = dibujar_municipios(mapa, filtros)
        
        // Se agrega la capa
        cartografia_base["Municipios"] = capa_municipios

        // Si tiene activa la opción de dibujar los municipios
        if(typeof filtros["opciones"]["Municipios"] !== 'undefined' && filtros["opciones"]["Municipios"][1]){
            // Se adiciona la capa
            mapa.addLayer(capa_municipios)
        
            // Se Chequea la capa
            $("#municipios>input").prop("checked", true)
        }

        // Cuando se selecciona otro mapa base
        $("#municipios>input").on("click", function(){
            // Si está chequeado
            if ($(this).prop('checked')){
                // Agrega la capa
                mapa.addLayer(capa_municipios)
                
                // Chequea
                $(this).prop("checked", true)
            } else {
                // Quita la capa
                mapa.removeLayer(capa_municipios)
                
                // Quita el check
                $(this).prop("checked", false)
            }
        })
    }
}

/**
 * Dibuja la capa de puntos de kilómetros
 * 
 * @param  {map}        mapa    [Mapa]
 * @param  {array}      filtros [Filtros de información]
 * @return {layer}              [Capa de puntos de kilómetros]
 */
function dibujar_kilometros(mapa, filtros)
{
    // Se consultan los puntos por kilómetro    
    var kilometros = ajax(`${$("#url").val()}/configuracion/obtener`, {"tipo": "puntos_kilometros", "id": {"id_sector": filtros.id_sector, "id_via": filtros.id_via}}, 'JSON')

    // Arreglo que contiene los puntos
    var puntos = new Array()

    // Recorrido de los kilometros
    $.each(kilometros, function(key, kilometro) {
        // Creación del punto
        let punto = L.marker(
            [kilometro.Latitud, kilometro.Longitud],
            {
                icon: L.divIcon({
                    className: 'uk-text-center',
                    html: `<strong style="color: white;">KM ${kilometro.Abscisa/1000} + 000</strong>`,
                    iconSize: [250, 40]
                }),
            }
        )
        // Evento clic
        .on("click", function(){
            // Alerta con información
            swal(
                `Vía: ${kilometro.Via}
                Abscisa: ${kilometro.Abscisa}`
            )
        })
        .bindTooltip("<b>Vía: </b>" + kilometro.Via)

        // El punto se agrega al arreglo
        puntos.push(punto)
    })
    
    // Se retorna la capa
    return L.layerGroup(puntos) 
}

/**
 * Dibujo de la capa de municipios
 * 
 * @param  {map}    mapa        [Mapa]
 * @param  {array}  filtros     [Arreglo de filtros y opciones]
 * @return {layer}              [Capa de municipios]
 */
function dibujar_municipios(mapa, filtros){
    // Información de la capa de municipios
    var capas_municipios = new L.geoJson(null, {
        style: {
            "color": "#898989",
            "weight": 4,
            "opacity": 1,
            "fillOpacity": 0,
        },
        onEachFeature: function(feature, layer) {
            // Polígono
            return L.polygon(feature.geometry.coordinates)
        },
    })

    // Consulta de los municipios
    municipios = ajax(`${$("#url").val()}/inventario/obtener`, {"tipo": "municipios_geometria", "id": {"id_sector": null, "id_via": null}}, 'JSON')

    // Se agregan los datos a la capa
    capas_municipios.addData(municipios)

    // Se retorna la capa
    return capas_municipios
}

/**
 * Dibuja las vías
 * 
 * @param  {map}    mapa        [Mapa]
 * @param  {array}  filtros     [Arreglo con filtros]
 * @return {layer}              [Capa de vías]
 */
function dibujar_vias(mapa, filtros)
{

    // Z-Index
    mapa.createPane('150').style.zIndex = 150

    // Se consultan las vías  
    var vias = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id": {"id_sector": filtros.id_sector, "id_via": filtros.id_via}}, 'JSON')

    // Se agrega la capa de vías
    var capa_vias = new L.geoJson(vias, {
        style: {
            "color": "#FACD00",
            "weight": 5,
            "opacity": 1
        },
        pane: '150',
    })

    // Se retorna la capa
    return capa_vias
}