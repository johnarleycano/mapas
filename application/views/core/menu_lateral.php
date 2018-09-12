<div class="uk-offcanvas-content">
    <div id="offcanvas-nav" uk-offcanvas="overlay: false; mode: push; flip: false;">
        <div id="menu_lateral" class="uk-offcanvas-bar">
            <ul class="uk-nav uk-nav-default">
                <li class="uk-active"><a href="<?php echo site_url(''); ?>">INICIO</a></li>
                
                <!-- <li class="uk-parent">
                    <a href="#">REPORTES</a>
                    <ul class="uk-nav-sub">
                        <li><a href="#">Sub item</a></li>
                        <li><a href="#">Sub item</a></li>
                    </ul>
                </li> -->

                <li class="uk-nav-header">OPERACIONES</li>
                <li><a onCLick="javascript:historico_accidentes(mapa)"><i class="far fa-paper-plane fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;Accidentes</a></li>
                <li><a href="<?php // echo site_url('mediciones/ver'); ?>"><i class="fas fa-list-alt fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;Ver mediciones</a></li>
                
                <li class="uk-nav-header">INVENTARIO</li>
                <li><a href="<?php // echo site_url('basculas/pesaje'); ?>"><i class="fas fa-truck fa-lg"></i>&nbsp;&nbsp;&nbsp;Pesaje</a></li>
                
                <!-- Menús pendientes de habilitar -->
                <?php // if(ENVIRONMENT === 'development'){ ?>
                <li><a onCLick="javascript:certificados_calibracion()"><i class="fas fa-server fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;Cert. calibración</a></li>
                    
                    <li class="uk-nav-header">INVENTARIO</li>
                    <li><a onCLick="javascript:medir_roceria()"><i class="far fa-paper-plane fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;Agregar</a></li>
                    <li><a href="<?php // echo site_url('mediciones/ver'); ?>"><i class="fas fa-list-alt fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;Ver</a></li>

                    <li class="uk-nav-header">MANTENIMIENTO</li>
                    <li><a onCLick="javascript:medir_roceria()"><i class="far fa-paper-plane fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;Iniciar</a></li>
                    <li><a href="<?php // echo site_url('mediciones/ver'); ?>"><i class="fas fa-list-alt fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;Ver</a></li>
                <?php // } ?>
                
                <!-- <li class="uk-nav-header"></li> -->
                <li class="uk-nav-divider"></li>
                <li><a href="<?php // echo site_url('reportes'); ?>"><i class="far fa-clipboard fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;Reportes</a></li>
                <li><a href="<?php // echo site_url('configuracion'); ?>"><i class="fas fa-cog fa-lg"></i>&nbsp;&nbsp;&nbsp;Configuración</a></li>
                
                <li class="uk-nav-divider"></li>
                <!-- <li class="uk-nav-header"></li> -->
                <li><a href="<?php // echo site_url('sesion/cerrar'); ?>"><i class="fas fa-sign-out-alt fa-lg"></i>&nbsp;&nbsp;&nbsp;Salir</a></li>
            </ul>
        </div>
    </div>
</div>

<div id="cont_datos"></div>
<!-- POINT(-75.54699649 6.316925437) -->




<script type="text/javascript">
    function historico_accidentes(mapa)
    {
        imprimir(mapa)
        $("select").on("change", function(){
            historico_accidentes(mapa)

        })

        let id_sector = ($("#select_sector_filtro").val()) ? $("#select_sector_filtro").val() : null
            id_via = ($("#select_via_filtro").val()) ? $("#select_via_filtro").val() : null
            circulos = new Array()

        // Se consultan los puntos
        let puntos = ajax("<?php echo site_url('operaciones/obtener') ?>", {"tipo": "historico_accidentes", "id": {id_sector: id_sector, id_via: id_via}}, 'JSON')

        mapa.eachLayer(function (layer) {
            // imprimir(layer)
           // mapa.removeLayer(layer);
        })

        $.each(puntos, function(key, punto) {
            let circulo = L.circleMarker(
                [punto.Latitud, punto.Longitud],
                {
                    radius: punto.Total_Accidentes * 2,
                     color: "#D72121",
                }
            )
            .on("click", function(){
                swal(`Abscisa: ${punto.Abscisa}
                     Accidentes: ${punto.Total_Accidentes} `)
            })
            circulos.push(circulo)
        })

        L.layerGroup(circulos).addTo(mapa)
    }

    $(document).ready(function(){
        
    })
</script>