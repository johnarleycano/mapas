<!-- Sectores -->
<?php if(in_array("filtro_superior", $opciones) && in_array("sectores", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-form-small" id="sector">
        <option value="0">Todos los sectores</option>
        <?php foreach ($this->filtros_model->obtener("sectores") as $sector) { ?>
            <option value="<?php echo $sector->Pk_Id; ?>"><?php echo "$sector->Codigo"; ?></option>
        <?php } ?>
    </select>
<?php } ?>

<!-- Vías -->
<?php if(in_array("filtro_superior", $opciones) && in_array("vias", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="via">
        <option value="0">Elija primero un sector...</option>
    </select>
<?php } ?>

<!-- Calzadas -->
<?php if(in_array("filtro_superior", $opciones) && in_array("calzadas", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="calzada">
        <option value="0">Elija primero una vía...</option>
    </select>
<?php } ?>

<!-- Costados -->
<?php if(in_array("filtro_superior", $opciones) && in_array("costados", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="costado">
        <option value="0">Elija primero una vía...</option>
    </select>
<?php } ?>

<!-- Año de los incidentes -->
<?php if(in_array("filtro_superior", $opciones) && in_array("anios_incidentes", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_anio_incidente_filtro"></select>
<?php } ?>

<!-- Meses de los incidentes -->
<?php if(in_array("filtro_superior", $opciones) && in_array("meses_incidentes", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_mes_incidente_filtro"></select>
<?php } ?>

<!-- Tipos de atención -->
<?php if(in_array("filtro_superior", $opciones) && in_array("tipos_atencion_incidentes", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_tipo_atencion_filtro"></select>
<?php } ?>

<script type="text/javascript">
    function cargar_vias()
    {
        datos = {
            url: "<?php echo site_url('configuracion/obtener'); ?>",
            tipo: "vias",
            id: $("#sector").val(),
            elemento_padre: $("#sector"),
            elemento_hijo: $("#via"),
            mensaje_padre: "Elija primero un sector",
            mensaje_hijo: "Todas las vías"
        }
        cargar_lista_desplegable(datos)

        // limpiar_lista($("#calzada"), "Elija primero una vía...")
        // limpiar_lista($("#costado"), "Elija primero una calzada...")
    }

    $(document).ready(function(){
        select_por_defecto("sector", 1)
        cargar_vias(1)
        select_por_defecto("via", 3)
        

        $("#sector").on("change", cargar_vias)
        $("#via").on("change", cargar_calzadas)
        // $("#calzada").on("change", cargar_costados)
    })
</script>