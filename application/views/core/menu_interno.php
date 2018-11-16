<nav id="menu_interno" class="uk-navbar uk-position-fixed uk-margin" uk-navbar>
	<!-- Título del mapa -->
    <div class="uk-navbar-center">
    	<ul class="uk-navbar-nav">
    		<center style="color: white;">FILTRO INTERNO</center>
            <!-- Filtro superior -->
            <?php if(in_array("filtro_interno", $opciones)) $this->load->view("core/menu_interno_filtros"); ?>
    	</ul>
    </div>
</nav>