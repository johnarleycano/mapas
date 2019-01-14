<li class="uk-active">
	<!-- Título del mes -->
	<a href="#"><h3 class="uk-heading-divider uk-margin-small"></h3></a>
</li>

<?php
// Si el año y mes son los actuales, carga los días transcurridos del mes actual, sino, carga todos los días del mes
$dia = ($anio == date("Y") && $mes == date("m")) ? date("d") : cal_days_in_month(CAL_GREGORIAN, $mes, $anio) ;

// Recorrido de los días
for ($dia; $dia > 0; $dia--) {
?>
	<li class="uk-parent <?php echo ($dia == date("d")) ? "uk-open": ""; ?>" onClick="javascript:cargar_eventos(<?php echo $dia; ?>)">
		<a href="#">
			<!-- Día -->
			<b><?php echo str_pad($dia, 2, "0", STR_PAD_LEFT); ?></b>&nbsp;
			
			<?php
			// Recorrido de las clasificaciones de atención
			foreach ($this->operaciones_model->obtener("eventos_dia", "$anio-$mes-$dia") as $evento) {
				echo "<span class='uk-badge' style='background-color: $evento->color;' title='{$evento->nombre}' uk-tooltip='pos: top-right'>$evento->total</span>&nbsp;";
			}

			// Heridos
			$heridos = $this->operaciones_model->obtener("eventos_victimas", "$anio-$mes-$dia", "heridos");
			if($heridos->total > 0) echo "<span class='uk-badge' style='background-color: #992024; float: right;' title='Lesionados' uk-tooltip='pos: top-right'>$heridos->total</span>&nbsp;";
			
			// Muertos
			$muertos = $this->operaciones_model->obtener("eventos_victimas", "$anio-$mes-$dia", "muertos");
			if($muertos->total > 0) echo "<span class='uk-badge' style='background-color: black; float: right;' title='Víctimas fatales' uk-tooltip='pos: top-right'>$muertos->total</span>&nbsp;";
			?>
		</a>

		<!-- Detalle de los incidentes -->
		<ul class="uk-nav-sub" id="detalle<?php echo intval($dia); ?>"></ul>
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
        "id_tipo_atencion": null,
        "anio": anio,
        "mes": mes,
        "dia": dia,
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

		$(`#detalle${dia}`).load("<?php echo site_url('operaciones/cargar_interfaz'); ?>", {"tipo": "detalle_eventos", "fecha": `${anio}-${mes}-${dia}`})
        
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