<div uk-grid>
    <div class="uk-width-4-5">
    	<div id="cont_mapa" class="margen_mapa"></div>
    </div>
    <div class="uk-width-1-5" style="padding-left: 0px">
        <div style="/*border: 1px solid black;*/ padding: 0px 20px 20px 20px; margin: 50px 0px 0px 0px; position: fixed; top: 0px; bottom: 0px; overflow-y: auto; width: 18%;">
		    <ul class="uk-nav-default uk-nav-parent-icon" uk-nav="multiple: true" style="" uk-nav>
		        <li class="uk-active">
		        	<a href="#"><h3 class="uk-heading-divider uk-margin-small">Septiembre de <?php echo date("Y"); ?></h3></a>
		        </li>

		        <!-- Recorrido de los días corridos del mes -->
		        <?php foreach ($this->operaciones_model->obtener("dias_mes_actual") as $dia) { ?>
		        	<li class="uk-parent">
			            <a href="#">
			            	<strong><?php echo $dia->numero; ?></strong>
			            	<?php foreach ($this->operaciones_model->obtener("eventos_dia", $dia->numero) as $evento) { ?>
			            		<span class="uk-badge green" style="background-color: red;"><?php echo $evento->cantidad; ?></span>
		        			<?php } ?>
			            </a>
			            <ul class="uk-nav-sub">
			                <li><a href="#">Sub item</a></li>
			                <li><a href="#">Sub item</a></li>
			            </ul>
			        </li>
		        <?php } ?>
		    </ul>
		</div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// Opciones: [0]: incluir; [1]: dibujar; [2]: centrar
		var opciones = {
			"Vias": [true, true, false],
			"Abscisas": [true],
			"Incidentes": [false],
			"Senales_Verticales": [false],
		}

		var mapa = generar_mapa("cont_mapa")
		marcar(mapa, opciones)

		$("select").on("change", function(){
			marcar(mapa, opciones)
		})

		// UIkit.accordion();

		// Al dar clic sobre cualquier parte del mapa, ejecuta
		// la función para generar un marcador
    	// mapa.on('click', generar_marcador)
	})
</script>