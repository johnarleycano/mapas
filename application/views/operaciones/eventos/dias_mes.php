<!-- Mes -->
<li class="uk-active">
	<a href="#"><h3 class="uk-heading-divider uk-margin-small"></h3></a>
</li>
<?php
// Si el año o mes no son los actuales, carga todo los dias del mes, sino, carga los días transcurridos del mes actual
$dia = ($anio == date("y") || $mes == date("m")) ? date("d") : cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

// Recorrido de los días
for ($dia; $dia > 0; $dia--) {
?>
	<li class="uk-parent <?php echo ($dia == date("d")) ? "uk-open": ""; ?>" onClick="javascript:cargar_eventos(<?php echo str_pad($dia, 2, "0", STR_PAD_LEFT); ?>)" >
	    <a href="#">
			<!-- Día -->
			<strong><?php echo str_pad($dia, 2, "0", STR_PAD_LEFT); ?></strong>

			<!-- Recorrido de los accidentes -->
        	<?php foreach ($this->operaciones_model->obtener("accidentes_dia", array("anio" => $anio, "mes" => $mes, "dia" => $dia)) as $evento) { ?>
        		<?php if($evento->total > 0){ ?>
        			<span class="uk-badge green" style="background-color: <?php echo $evento->color; ?>;" title="<?php echo $evento->nombre; ?>"><?php echo $evento->total; ?></span>
				<?php } ?>
			<?php } ?>

			<!-- Recorrido de los incidentes -->
        	<?php foreach ($this->operaciones_model->obtener("incidentes_dia", array("anio" => $anio, "mes" => $mes, "dia" => $dia)) as $evento) { ?>
        		<?php if($evento->total > 0){ ?>
        			<span class="uk-badge green" style="background-color: <?php echo $evento->color; ?>;" title="<?php echo $evento->nombre; ?>"><?php echo $evento->total; ?></span>
				<?php } ?>
			<?php } ?>
	    </a>
	    <!-- <ul class="uk-nav-sub">
	        <li><a href="#">Sub item</a></li>
	        <li>
	            <a href="#">Sub item</a>
	            <ul>
	                <li><a href="#">Sub item</a></li>
	                <li><a href="#">Sub item</a></li>
	            </ul>
	        </li>
	    </ul> -->
	</li>
<?php } ?>

<script type="text/javascript">
	// Día
	var dia = parseInt("<?php echo date("d"); ?>")

	// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
	var capas = {
		// Capas
		"Mapa_Base": "open_street",
		"Eventos_Diarios": [true, true],
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
        
		// Dibujo del mapa
		dibujar_capas(mapa, capas)
	}

	$(document).ready(function(){
   		// Se quita el mensaje de carga
   		cargando()

		// Carga de eventos del día
		cargar_eventos(dia)
	})
</script>