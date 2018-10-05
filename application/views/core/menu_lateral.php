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
                        <i class="fas fa-globe fa-lg"></i>&nbsp;&nbsp;&nbsp;MAPAS BASE
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
                        <i class="fas fa-map fa-lg"></i>&nbsp;&nbsp;&nbsp;CARTOGRAFÍA BASE
                    </a>

                    <ul class="uk-nav-sub">
                        <div class="uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
                            <label class="enlace uk-hidden" id="vias">
                                <input class="uk-checkbox" name="cartografia_base" type="checkbox">&nbsp;&nbsp;&nbsp;
                                Vías
                            </label>

                            <label class="enlace uk-hidden" id="municipios">
                                <input class="uk-checkbox" name="cartografia_base" type="checkbox">&nbsp;&nbsp;&nbsp;
                                Municipios
                            </label>

                            <label class="enlace uk-hidden" id="kilometros">
                                <input class="uk-checkbox" name="cartografia_base" type="checkbox">&nbsp;&nbsp;&nbsp;
                                Kilómetros
                            </label>

                            <?php if(ENVIRONMENT == 'development'){ ?>
                                <label class="enlace" id="abscisas">
                                    <input class="uk-checkbox" name="cartografia_base" type="checkbox">&nbsp;&nbsp;&nbsp;
                                    Abscisas
                                </label>
                            <?php } ?>
                        </div>
                    </ul>
                </li>
                
                <li class="uk-nav-divider"></li>
                <li class="uk-parent">
                    <a href="#">
                        <i class="fas fa-car fa-lg"></i>&nbsp;&nbsp;&nbsp;OPERACIONES
                    </a>

                    <ul class="uk-nav-sub">
                        <div class="uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
                            <?php if(ENVIRONMENT == 'development'){ ?>
                                <label class="enlace">
                                    <input class="uk-checkbox" type="checkbox" id="eventos_diarios">&nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo site_url('operaciones/eventos_diarios/').date("Y")."/".date("m"); ?>" class="uk-link-text">Eventos diarios</a>
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
                        <i class="fas fa-map fa-lg"></i>&nbsp;&nbsp;&nbsp;INVENTARIO
                    </a>
                    
                    <ul class="uk-nav-sub">
                        <div class="uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
                            <label class="enlace">
                                <input class="uk-checkbox" type="checkbox" id="senales_verticales">&nbsp;&nbsp;&nbsp;
                                <a href="<?php echo site_url('inventario/senales_verticales'); ?>" class="uk-link-text">Señales verticales</a>
                                <br>
                                
                                <input class="uk-checkbox" type="checkbox" id="obras">&nbsp;&nbsp;&nbsp;
                                <a href="<?php echo site_url('inventario/obras'); ?>" class="uk-link-text">Obras de arte</a>
                            </label>
                        </div>
                    </ul>
                </li>

                <li class="uk-parent">
                    <a href="#">
                        <i class="fas fa-paper-plane fa-lg"></i>&nbsp;&nbsp;&nbsp;RECORRIDOS
                    </a>
                    
                    <ul class="uk-nav-sub">
                        <div class="uk-margin-small uk-grid-small uk-child-width-auto uk-grid">
                            <label class="enlace">
                                <input class="uk-checkbox" type="checkbox" id="fotos_aereas">&nbsp;&nbsp;&nbsp;
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