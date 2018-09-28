<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
    function cargar_anios()
    {
        // Consulta de los años
        var anios = ajax("<?php echo site_url('operaciones/obtener'); ?>", {"tipo": "anios_incidentes"}, "JSON")

        // Se recorren los meses
        $.each(anios, function(key, anio) {
            // Se agrega el año al select
            $("#select_anio_incidente_filtro").append(`<option value="${anio.Numero}">${anio.Numero}</option>`)
        })
    }

    function cargar_meses()
    {
        // Se consultan los meses que tienen incidentes
        var meses = ajax("<?php echo site_url('operaciones/obtener'); ?>", {"tipo": "meses_incidentes", "id": $("#select_anio_incidente_filtro").val()}, "JSON")
        
        // Se limpia el select
        $("#select_mes_incidente_filtro").html("")

        // Se recorren los meses
        $.each(meses, function(key, mes) {
            // Se agrega el mes al filtro
            $("#select_mes_incidente_filtro").append(`<option value="${mes.Numero}">${mes.Numero}</option>`)
        })
    }

    function cargar_tipos_atencion()
    {
        var datos = {
            "anio": $("#select_anio_incidente_filtro").val(),
            "mes": $("#select_mes_incidente_filtro").val(),
            "id_tipo_atencion": $("#select_tipo_atencion_filtro").val(),
        }
        // imprimir(datos)
    
        // Se consultan los tipos de atención y se agrega option para todos los tipos
        var tipos_atencion = ajax(`${$("#url").val()}/operaciones/obtener`, {"tipo": "tipos_atencion_incidente", "id": datos}, "JSON")
        // imprimir(tipos_atencion)

        // Se limpia el select
        $("#select_tipo_atencion_filtro").html("").append(`<option value="">Todos</option>`)

        // Se recorren los registros
        $.each(tipos_atencion, function(key, tipo_atencion) {
            // Se agrega al select
            $("#select_tipo_atencion_filtro").append(`<option value="${tipo_atencion.Pk_Id}">${tipo_atencion.Nombre}</option>`)
        })
    }

    $(document).ready(function(){
        cargar_anios()
        cargar_meses()
        cargar_tipos_atencion()

        // Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
        var opciones = {
            "Vias": [true, true, true],
            "Abscisas": [true],
            "Incidentes": [true, true, true],
            "Mapa_Base": "open_street",
        }
        
        var mapa = generar_mapa("cont_mapa", {zoom: 18, minZoom: 15, maxZoom: 18})
        marcar(mapa, opciones)

        $("#select_anio_incidente_filtro").on("change", function(){
            cargar_meses()
            cargar_tipos_atencion()

            marcar(mapa, opciones)
        })

        $("#select_mes_incidente_filtro").on("change", function(){
            cargar_tipos_atencion()
        
            marcar(mapa, opciones)
        })

        $("#select_tipo_atencion_filtro").on("change", function(){
            marcar(mapa, opciones)
        })
    })
</script>