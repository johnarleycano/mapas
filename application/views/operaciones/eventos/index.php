<div uk-grid>
	<!-- Mapa -->
    <div class="uk-width-4-5">
    	<div id="cont_mapa" class="margen_mapa"></div>
    </div>

	<!-- Eventos diarios -->
    <div class="uk-width-1-5" id="cont_dias">
	    <ul class="uk-nav-default uk-nav-parent-icon" 
    	style="
		    padding: 0px 20px 20px 20px;
			margin: 50px 0px 0px 0px;
			position: fixed;
			top: 0px;
			bottom: 0px;
			overflow-y: auto ;
			width: 18%;
		" uk-nav>
	    </ul>
    </div>
</div>

<script type="text/javascript">
	var anio = "<?php echo $this->uri->segment(3); ?>"
	var mes = "<?php echo $this->uri->segment(4); ?>"

	cargando(`Cargando el consolidado de eventos del mes y dibujando los eventos del día en el mapa para el mes de ${nombre_mes(mes)}...`)

	$(document).ready(function(){
		$("#cont_dias>ul").load("<?php echo site_url('operaciones/cargar_interfaz'); ?>", {"tipo": "dias_mes", "anio": anio, "mes": mes})
	})
</script>