<!-- Sectores -->
<?php if(in_array("filtro_superior", $opciones) && in_array("sectores", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-form-small" id="select_sector_filtro">
        <option value="0">Todos los sectores</option>
        <?php foreach ($this->filtros_model->obtener("sectores") as $sector) { ?>
            <option value="<?php echo $sector->Pk_Id; ?>"><?php echo "$sector->Codigo"; ?></option>
        <?php } ?>
    </select>
<?php } ?>

<!-- Vías -->
<?php if(in_array("filtro_superior", $opciones) && in_array("vias", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_via_filtro">
        <option value="0">Elija primero un sector...</option>
    </select>
<?php } ?>

<!-- Costados -->
<?php if(in_array("filtro_superior", $opciones) && in_array("costados", $filtros)){ ?>
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_costado_filtro">
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