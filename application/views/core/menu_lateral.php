<div class="uk-offcanvas-content">
    <div id="offcanvas-nav" uk-offcanvas="overlay: false; mode: push; flip: false;">
        <div id="menu_lateral" class="uk-offcanvas-bar">
            <ul class="uk-nav uk-nav-default">
                <li class="uk-active">
                    <a href="<?php echo site_url(''); ?>">
                        <i class="fas fa-home fa-lg"></i>&nbsp;&nbsp;&nbsp;INICIO
                    </a>
                </li>
                
                <li class="uk-nav-divider"></li>
                <li class="uk-parent">
                    <a href="#">
                        <i class="fas fa-globe fa-lg"></i>&nbsp;&nbsp;&nbsp;MAPAS BASE</li>
                    </a>

                    <ul class="uk-nav-sub">
                        <div class="uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
                            <label class="enlace">
                                <input class="uk-radio" type="radio" name="mapas_base" id="bing"> Bing
                            </label>
                            
                            <label class="enlace">
                                <input class="uk-radio" type="radio" name="mapas_base" id="open_street"> Open Street
                            </label>
                            
                            <label class="enlace">
                                <input class="uk-radio" type="radio" name="mapas_base" id="open_street_dark"> Open Street Dark
                            </label>
                        </div>
                    </ul>
                </li>

                <li class="uk-parent">
                    <a href="#">
                        <i class="fas fa-map fa-lg"></i>&nbsp;&nbsp;&nbsp;CARTOGRAFÍA BASE</li>
                    </a>

                    <ul class="uk-nav-sub">
                        <div class="uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
                            <label class="enlace">
                                <input class="uk-checkbox" name="cartografia_base" type="checkbox" id="vias">&nbsp;&nbsp;&nbsp;
                                Vías
                            </label>

                            <label class="enlace">
                                <input class="uk-checkbox" name="cartografia_base" type="checkbox" id="kilometros">&nbsp;&nbsp;&nbsp;
                                Kilómetros
                            </label>

                            <?php if(ENVIRONMENT == 'development'){ ?>
                                <label class="enlace">
                                    <input class="uk-checkbox" name="cartografia_base" type="checkbox" id="abscisas">&nbsp;&nbsp;&nbsp;
                                    Abscisas
                                </label>
                            <?php } ?>
                        </div>
                    </ul>
                </li>
                
                <li class="uk-nav-divider"></li>
                <li class="uk-parent">
                    <a href="#">
                        <i class="fas fa-car fa-lg"></i>&nbsp;&nbsp;&nbsp;OPERACIONES</li>
                    </a>

                    <ul class="uk-nav-sub">
                        <div class="uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
                            <?php if(ENVIRONMENT == 'development'){ ?>
                                <label class="enlace">
                                        <input class="uk-checkbox" type="checkbox" checked>&nbsp;&nbsp;&nbsp;
                                        <a href="<?php echo site_url('operaciones/eventos'); ?>" class="uk-link-text">Eventos diarios</a>
                                </label>
                            <?php } ?>

                            <label class="enlace">
                                <?php if(ENVIRONMENT == 'development'){ ?>
                                    <input class="uk-checkbox" type="checkbox">&nbsp;&nbsp;&nbsp;
                                <?php } ?>
                                
                                <a href="<?php echo site_url('operaciones/incidentes'); ?>">Incidentes</a>
                            </label>
                        </div>
                    </ul>
                </li>

                <li class="uk-parent">
                    <a href="#">
                        <i class="fas fa-map fa-lg"></i>&nbsp;&nbsp;&nbsp;INVENTARIO</li>
                    </a>
                    
                    <ul class="uk-nav-sub">
                        <div class="uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
                            <label class="enlace">
                                <?php if(ENVIRONMENT == 'development'){ ?>
                                    <input class="uk-checkbox" type="checkbox" checked>&nbsp;&nbsp;&nbsp;
                                <?php } ?>
                                
                                <a href="<?php echo site_url('inventario/senales_verticales'); ?>" class="uk-link-text">Señales verticales</a>
                            </label>
                        </div>
                    </ul>
                </li>

                <li class="uk-parent">
                    <a href="#">
                        <i class="fas fa-paper-plane fa-lg"></i>&nbsp;&nbsp;&nbsp;RECORRIDOS</li>
                    </a>
                    
                    <ul class="uk-nav-sub">
                        <div class="uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
                            <label class="enlace">
                                <?php if(ENVIRONMENT == 'development'){ ?>
                                    <input class="uk-checkbox" type="checkbox" checked>&nbsp;&nbsp;&nbsp;
                                <?php } ?>

                                <a href="<?php echo site_url('inventario/fotos_aereas'); ?>" class="uk-link-text">Aéreos</a>
                            </label>
                        </div>
                    </ul>
                </li>

                <li class="uk-nav-divider"></li>
                <li><a href="#<?php // echo site_url('configuracion'); ?>"><i class="fas fa-cog fa-lg"></i>&nbsp;&nbsp;&nbsp;Configuración</a></li>
                <li><a href="<?php echo site_url('sesion/cerrar'); ?>"><i class="fas fa-sign-out-alt fa-lg"></i>&nbsp;&nbsp;&nbsp;Salir</a></li>
            </ul>
        </div>
    </div>
</div>    