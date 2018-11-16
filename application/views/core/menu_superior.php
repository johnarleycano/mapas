<nav id="menu_superior" class="uk-navbar uk-navbar-container uk-margin" uk-navbar>
    <?php if(in_array("menu_lateral", $opciones)){ ?>
        <!-- Ícono que activa el menú lateral -->
        <a class="uk-navbar-toggle" href="#" uk-toggle="target: #offcanvas-nav" title="Visualice el menú principal">
            <span uk-navbar-toggle-icon></span>
        </a>
    <?php } ?>
    
	<!-- Título del mapa -->
    <div class="uk-navbar-right" id="filtro_superior">
    	<ul class="uk-navbar-nav" id="titulo_mapa">
    		<li class="uk-active"><a href="#"><b><?php echo $titulo_mapa; ?></b></a></li>
    	</ul>
    </div>

    <div class="uk-navbar-right" id="filtro_superior">
        <!-- Filtro superior -->
        <?php if(in_array("filtro_superior", $opciones)) $this->load->view("core/menu_superior_filtros"); ?>
    </div>
</nav>