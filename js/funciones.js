/**
 * Método para realizar consultas y carga
 * de información mediante Ajax
 * 
 * @param  [string]  url            Url del controlador y método que consultará
 * @param  [string]  datos          Datos que enviará. Normalmente en formato JSON
 * @param  [string]  tipo_respuesta La respuesta que retorna. Se da en Ajax o HTML
 * @param  [boolean] async          paso de datos síncrono o asíncrono
 * 
 * @return [array]                Respuesta con los datos
 * 
 */
function ajax(url, datos, tipo_respuesta, async = false){
    //Variable de exito
    var exito;

    // Esta es la petición ajax que llevará 
    // a la interfaz los datos pedidos
    $.ajax({
        url: url,
        data: datos,
        type: "POST",
        dataType: tipo_respuesta,
        async: async,
        success: function(respuesta){
            //Si la respuesta no es error
            if(respuesta){
                //Se almacena la respuesta como variable de éxito
                exito = respuesta;
            } else {
                //La variable de éxito será un mensaje de error
                // exito = 'error';
                exito = respuesta;
            } //If
        },//Success
        error: function(respuesta){
            //Variable de exito será mensaje de error de ajax
            exito = respuesta;
        }//Error
    });//Ajax

    //Se retorna la respuesta
    return exito;
}

/**
 * Imprime mensaje en consola
 * 
 * @param  [string] mensaje Mensaje a imprimir
 * 
 * @return [void]
 */
function imprimir(mensaje, tipo = null)
{
    switch(tipo) {
        case "tabla":
            console.table(mensaje)
        break;

        case "tiempo_inicio":
            console.time(mensaje)
        break;

        case "tiempo_final":
            console.timeEnd(mensaje)
        break;

        case "grupo":
            console.group(mensaje)
        break;

        default:
            console.log(mensaje)
    }
}