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
    var kilómetros = ajax(`${$("#url").val()}/configuracion/obtener`, {"tipo": "puntos_kilometros", "id": {"id_sector": filtros.id_sector, "id_via": filtros.id_via}}, 'JSON')

    // Arreglo que contiene los puntos
    var puntos = new Array()

    // Recorrido de los kilómetros
    $.each(kilómetros, function(key, abscisa) {
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
            // Alerta con información
            swal(
                `Vía: ${abscisa.Via}
                Abscisa: ${abscisa.Abscisa}`
            )
        })

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
        style: function(feature){

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
    // Se consultan las vías  
    var vias = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id": {"id_sector": filtros.id_sector, "id_via": filtros.id_via}}, 'JSON')

    // Se agrega la capa de vías
    var capa_vias = new L.geoJson(vias, {
        style: {
            "color": "#FACD00",
            "weight": 5,
            "opacity": 1
        }
    })

    // Se retorna la capa
    return capa_vias
}