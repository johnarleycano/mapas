<div uk-grid>
	<!-- Días del mes -->
    <div id="eventos_diarios_dias" class="uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
    	<ul class="uk-nav-default uk-nav-parent-icon margen_mapa" uk-nav></ul>
    </div>
	
	<!-- Mapa -->
    <div id="eventos_diarios_mapa" class="uk-width-expand">
    	<div id="cont_mapa"></div>
    </div>
</div>

<script type="text/javascript">
	// Variables
	var anio = parseInt("<?php echo $this->uri->segment(3); ?>")
	var mes = parseInt("<?php echo $this->uri->segment(4); ?>")

	cargando(`Cargando el consolidado de eventos del mes y dibujando los eventos del día en el mapa para el mes de ${nombre_mes(mes)} de ${anio}...`)

	$(document).ready(function(){
		$("#eventos_diarios_dias>ul").load("<?php echo site_url('operaciones/cargar_interfaz'); ?>", {"tipo": "dias_mes", "anio": anio, "mes": mes})
	})
</script>