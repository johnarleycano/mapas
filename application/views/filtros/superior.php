<!-- Sector -->
<select class="uk-select uk-form-width-medium uk-form-small" id="select_sector_filtro">
    <option value="0">Todos los sectores</option>
    <?php foreach ($this->filtros_model->obtener("sectores") as $sector) { ?>
        <option value="<?php echo $sector->Pk_Id; ?>"><?php echo "$sector->Codigo"; ?></option>
    <?php } ?>
</select>

<!-- Vía -->
<select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_via_filtro">
    <option value="0">Elija primero un sector...</option>
</select>

<!-- Costado -->
<select class="uk-select uk-form-width-medium uk-margin-small-left uk-form-small" id="select_costado_filtro">
    <option value="0">Elija primero una vía...</option>
</select>

<script type="text/javascript">
    $(document).ready(function(){
    	// Al seleccionar un sector
        $("#select_sector_filtro").on("change", function(){
            // Se consultan las vías del sector
            datos = {
                url: "<?php echo site_url('filtros/obtener'); ?>",
                tipo: "vias",
                id: $(this).val(),
                elemento_padre: $("#select_sector_filtro"),
                elemento_hijo: $("#select_via_filtro"),
                mensaje_padre: "Elija primero un sector",
                mensaje_hijo: "Todas las vías"
            }
            cargar_lista_desplegable(datos)

            limpiar_lista($("#select_costado_filtro"), "Elija primero una vía...")
        })

        // Al seleccionar una vía
        $("#select_via_filtro").on("change", function(){
            // Se consultan los costados de la vía
            datos = {
                url: "<?php echo site_url('filtros/obtener'); ?>",
                tipo: "costados",
                id: $(this).val(),
                elemento_padre: $("#select_via_filtro"),
                elemento_hijo: $("#select_costado_filtro"),
                mensaje_padre: "Elija primero una vía",
                mensaje_hijo: "Todos los costados"
            }
            cargar_lista_desplegable(datos)
        })
    })
</script>