<nav id="menu_superior" class="uk-navbar uk-navbar-container uk-margin" uk-navbar>
    <!-- Ícono que activa el menú lateral -->
    <a class="uk-navbar-toggle" href="#" uk-toggle="target: #offcanvas-nav" title="Visualice el menú principal" uk-tooltip="pos: right">
        <span uk-navbar-toggle-icon></span>
    </a>

    <!-- Filtro superior -->
    <div class="uk-navbar-center" id="filtro_superior">
        <?php if($filtro_superior) $this->load->view("filtros/superior"); ?>
    </div>
</nav>