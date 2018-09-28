<nav id="menu_superior" class="uk-navbar uk-navbar-container uk-margin" uk-navbar>
    <!-- Ícono que activa el menú lateral -->
    <a class="uk-navbar-toggle" href="#" uk-toggle="target: #offcanvas-nav" title="Visualice el menú principal">
        <span uk-navbar-toggle-icon></span>
    </a>
    
	<!-- Título del mapa -->
    <div class="uk-navbar-right" id="filtro_superior">
    	<ul class="uk-navbar-nav" id="titulo_mapa">
    		<li class="uk-active"><a href="#"><b><?php echo $titulo_mapa; ?></b></a></li>
    	</ul>
    </div>

    <!-- Filtro superior -->
    <div class="uk-navbar-right" id="filtro_superior">
        <?php if($filtro_superior) $this->load->view("filtros/superior"); ?>
    </div>
</nav>