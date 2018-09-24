<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Título que viene desde el controlador de cada interfaz -->
<title><?php echo $titulo; ?> | Mapas</title>

<!-- Estilos -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilos.css" />

<?php if(ENVIRONMENT === 'development') { ?>
	<!-- Estilos -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/uikit.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/fontawesome-all.css" />

	<!-- Scripts -->
	<script src="<?php echo base_url(); ?>js/uikit.js"></script> <!-- Scripts para UI Kit -->
	<script src="<?php echo base_url(); ?>js/uikit-icons.js"></script> <!-- Scripts para UI Kit -->
	<script src="<?php echo base_url(); ?>js/fontawesome-all.js"></script>
	<script src="<?php echo base_url(); ?>js/sweetalert.min.js"></script>
<?php } ?>

<?php if(ENVIRONMENT === 'production') { ?>
	<!-- Estilos -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/uikit.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/fontawesome-all.min.css" />

	<!-- Scripts -->
	<script src="<?php echo base_url(); ?>js/uikit.min.js"></script> <!-- Scripts para UI Kit -->
	<script src="<?php echo base_url(); ?>js/uikit-icons.min.js"></script> <!-- Scripts para UI Kit -->
	<script src="<?php echo base_url(); ?>js/fontawesome-all.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php } ?>

<!-- Estilos -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/leaflet.css" />
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.css' rel='stylesheet' />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/L.Control.Locate.min.css">

<!-- Scripts -->
<script src="<?php echo base_url(); ?>js/jquery-3.2.1.min.js"></script> <!-- jQuery -->
<script src="<?php echo base_url(); ?>js/leaflet/leaflet.js"></script>
<script src="<?php echo base_url(); ?>js/leaflet/bing.js"></script>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.js'></script>
<script src="<?php echo base_url(); ?>js/leaflet/minimap.js"type="text/javascript"></script>		
<script src="<?php echo base_url(); ?>js/leaflet/geometryutil.js"></script>
<script src="<?php echo base_url(); ?>js/funciones_mapas.js"></script>
<script src="<?php echo base_url(); ?>js/leaflet/hash.js"></script>
<script src="<?php echo base_url(); ?>js/funcion.js"></script>
<script src="<?php echo base_url(); ?>js/leaflet/L.Control.Locate.min.js"></script>