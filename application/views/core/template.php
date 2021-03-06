<!DOCTYPE html>
<html>
	<head>
		<!-- Cabecera con todos los estilos y scripts -->
        <?php $this->load->view('core/header'); ?>
	</head>
	<body>
        <!-- 1. Menú superior -->
        <?php if(in_array("menu_superior", $opciones)) $this->load->view('core/menu_superior/index'); ?>

        <!-- 2. Menú inferior -->
        <?php if(in_array("menu_interno", $opciones)) $this->load->view('core/menu_interno/index'); ?>

        <!-- 3. Menú lateral -->
        <?php if(in_array("menu_lateral", $opciones)) $this->load->view('core/menu_lateral/index'); ?>

        <!-- Interfaz de espera de carga -->
        <div id="cargando" class="uk-hidden" uk-grid>
            <div class="uk-width-1-1">
                <img src="<?php echo base_url(); ?>img/cargando.gif" class="uk-align-center">
                <div class="uk-text-lead uk-text-center"></div>
            </div>
        </div>

    	<!-- Contenedor principal -->
        <div id="contenedor_principal">
            <!--Se carga el contenido principal -->
            <?php $this->load->view($contenido_principal); ?>
        </div>

        <!-- Input que entrega url base para archivos en JS -->
        <input type="hidden" id="url" value="<?php echo site_url(''); ?>">
        <input type="hidden" id="url_base" value="<?php echo base_url(''); ?>">

        <script type="text/javascript">
            $(document).ready(function(){
                // Si el menú superior está activado
                if("<?php echo in_array('menu_superior', $opciones) ?>"){
                    // Se agregan clases
                    $("#cont_mapa").addClass("margen_mapa")
                }
            })
        </script>
	</body>
</html>