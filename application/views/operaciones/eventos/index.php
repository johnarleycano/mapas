<div uk-grid>
	<!-- Mapa -->
    <div id="cont_eventos_diarios_mapa">
    <!-- <div class="uk-width-4-6"> -->
    	<div id="cont_mapa"></div>
    </div>

	<!-- Eventos diarios -->
    <div id="cont_eventos_diarios_dias">
    <!-- <div class="uk-width-2-6" id="cont_dias"> -->
	    <ul class="uk-nav-default uk-nav-parent-icon margen_mapa" 
    	style="
			bottom: 0px;
			margin: 0px 0px 0px 0px;
			overflow-y: auto ;
		    padding-left: 15px;
		    padding-right: 15px;
			top: 0px;
			z-index: 300;
		" uk-nav>
	    </ul>
    </div>
</div>

<script type="text/javascript">
	var anio = "<?php echo $this->uri->segment(3); ?>"
	var mes = "<?php echo $this->uri->segment(4); ?>"

	cargando(`Cargando el consolidado de eventos del mes y dibujando los eventos del día en el mapa para el mes de ${nombre_mes(mes)}...`)
	
	// function obtener_nuevos_eventos_mes(){
	// 	imprimir(`Consultando nuevos eventos del anio ${anio} y mes ${mes}`)
	// }

	$(document).ready(function(){
		// setInterval(obtener_nuevos_eventos_mes,1000);
		$("#cont_eventos_diarios_dias>ul").load("<?php echo site_url('operaciones/cargar_interfaz'); ?>", {"tipo": "dias_mes", "anio": anio, "mes": mes})
	})
</script>