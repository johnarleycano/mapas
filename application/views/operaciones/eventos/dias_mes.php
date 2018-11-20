<!-- Mes -->
<li class="uk-active">
	<a href="#"><h3 class="uk-heading-divider uk-margin-small"></h3></a>
</li>
<?php
// Si el año y mes son los actuales, carga los días transcurridos del mes actual, sino, carga todos los días del mes
$dia = ($anio == date("Y") && $mes == date("m")) ? date("d") : cal_days_in_month(CAL_GREGORIAN, $mes, $anio) ;

// Recorrido de los días
for ($dia; $dia > 0; $dia--) {
?>
	<li class="uk-parent <?php echo ($dia == date("d")) ? "uk-open": ""; ?>" onClick="javascript:cargar_eventos(<?php echo $dia; ?>)" >
	    <a href="#">
			<!-- Día -->
			<strong><?php echo str_pad($dia, 2, "0", STR_PAD_LEFT); ?></strong>

			<!-- Recorrido de los accidentes -->
        	<?php foreach ($this->operaciones_model->obtener("accidentes_dia", array("anio" => $anio, "mes" => $mes, "dia" => $dia)) as $evento) { ?>
        		<?php if($evento->total > 0){ ?>
        			<span class="uk-badge" style="background-color: <?php echo $evento->color; ?>;" title="<?php echo $evento->nombre; ?>"><?php echo $evento->total; ?></span>
				<?php } ?>
			<?php } ?>

			<!-- Recorrido de los incidentes -->
        	<?php foreach ($this->operaciones_model->obtener("incidentes_dia", array("anio" => $anio, "mes" => $mes, "dia" => $dia)) as $evento) { ?>
        		<?php if($evento->total > 0){ ?>
        			<span class="uk-badge" style="background-color: <?php echo $evento->color; ?>;" title="<?php echo $evento->nombre; ?>"><?php echo $evento->total; ?></span>
				<?php } ?>
			<?php } ?>
	    </a>

		<!-- Detalle de los incidentes -->
		<ul class="uk-nav-sub" id="cont_detalle<?php echo intval($dia); ?>"></ul>
	</li>
<?php } ?>

<script type="text/javascript">
	// Día
	var dia = parseInt("<?php echo date("d"); ?>")

	// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
	var capas = {
		// Capas
		"Mapa_Base": "google_streets",
		"Eventos_Diarios": [true, true],
		"Kilometros": [true],
		"Municipios": [true, true],
		"Vias": [true, true, true],
        
        // Opciones
        "anio": anio,
        "mes": mes,
        "dia": dia,
        "id_tipo_atencion": null,
	}

	// Creación del mapa
	var mapa = crear("cont_mapa", {zoom: 10, minZoom: 11, maxZoom: 18})

	/**
	 * Carga de eventos del día
	 * 
	 * @param  {int} 		dia 	[Día de los eventos]
	 * @return {[type]}     [description]
	 */
	function cargar_eventos(dia)
	{
		
		// Variables
		var anio = "<?php echo $anio; ?>"
		var mes = "<?php echo $mes; ?>"

		// Se actualiza el día en las opciones a enviar
		capas["dia"] = dia

		// Título del anel derecho
		$("h3").text(`${nombre_mes(mes)} de ${anio}`)

		$(`#cont_detalle${dia}`).load("<?php echo site_url('operaciones/cargar_interfaz'); ?>", {"tipo": "detalle_eventos", "fecha": `${anio}-${mes}-${dia}`})
        
		// Dibujo del mapa
		dibujar_capas(mapa, capas)

		// cerrar_notificaciones()

	}

	function obtener_nuevos_eventos(){
		imprimir(`Consultando nuevos eventos del día ${dia}`)

		// Se consultan los eventos del día
		
		$(`#cont_detalle${dia}`).load("<?php echo site_url('operaciones/cargar_interfaz'); ?>", {"tipo": "detalle_eventos", "fecha": `${anio}-${mes}-${dia}`})

	}

	$(document).ready(function(){
   		// Se quita el mensaje de carga
   		cargando()
		
		// setInterval(obtener_nuevos_eventos,1000);

		// Carga de eventos del día
		cargar_eventos(dia)
	})
</script>