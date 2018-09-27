<?php if(isset($filtros["sectores"])){ ?>
    <!-- Sector -->
    <select class="uk-select uk-form-width-medium uk-form-small" id="select_sector_filtro">
        <option value="0">Todos los sectores</option>
        <?php foreach ($this->filtros_model->obtener("sectores") as $sector) { ?>
            <option value="<?php echo $sector->Pk_Id; ?>"><?php echo "$sector->Codigo"; ?></option>
        <?php } ?>
    </select>
<?php } ?>

<?php if(isset($filtros["vias"])){ ?>
    <!-- Vías -->
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_via_filtro">
        <option value="0">Elija primero un sector...</option>
    </select>
<?php } ?>

<?php if(isset($filtros["costados"])){ ?>
    <!-- Costado -->
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_costado_filtro">
        <option value="0">Elija primero una vía...</option>
    </select>
<?php } ?>

<?php if(isset($filtros["anios_incidentes"])){ ?>
    <!-- Año de los incidentes -->
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_anio_incidente_filtro"></select>
<?php } ?>

<?php if(isset($filtros["meses_incidentes"])){ ?>
    <!-- Meses de los incidentes -->
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_mes_incidente_filtro"></select>
<?php } ?>

<?php if(isset($filtros["tipos_atencion"])){ ?>
    <!-- Tipos de atención -->
    <select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_tipo_atencion_filtro"></select>
<?php } ?>