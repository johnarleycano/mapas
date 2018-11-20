<nav id="menu_interno" class="uk-navbar uk-margin" uk-navbar>
<!-- <nav id="menu_interno" class="uk-navbar uk-navbar-container uk-margin" uk-navbar> -->
    <div class="uk-navbar-center">
        <!-- Filtro superior -->
        <?php if(in_array("filtro_interno", $opciones)) $this->load->view("core/menu_interno/filtros"); ?>
    </div>
</nav>