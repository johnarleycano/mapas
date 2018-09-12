<div id='cont_mapa'></div>

<script type="text/javascript">
	
	function generar_marcador(punto) {
	swal(`Has elegido crear un marcador en las coordenadas ${punto.latlng.toString()}`);
		
		imprimir(punto)
	    imprimir(`Has elegido crear un marcador en las coordenadas ${punto.latlng}`)
	    
	    // popup
	    //     .setLatLng(punto.latlng)
	    //     .setContent()
	    //     .openOn(mapa)
	}

	function dibujar_mapa(mapa){
		var id_sector = ($("#select_sector_filtro").val()) ? $("#select_sector_filtro").val() : null
		var id_via = ($("#select_via_filtro").val()) ? $("#select_via_filtro").val() : null

		
		// mapa.removeLayer(capa_vias);
		if (capa_vias) { capa_vias.clearLayers(); }
		
		var capa_vias = new L.geoJson(null, {
	         style: {
			    "color": "#555555",
			    "weight": 5,
			    "opacity": 1
			}
	    })
		
		vias = ajax("<?php echo site_url('filtros/obtener') ?>", {"tipo": "vias_geometria", "id": {id_sector: id_sector, id_via: id_via}}, 'JSON')
	    // imprimir(vias)

		mapa.eachLayer(function (layer) {
		   mapa.removeLayer(layer);
		})

		capa_vias.addData(vias).addTo(mapa)
		
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(mapa)

		var mini_mapa = new L.TileLayer('http://{s}.www.toolserver.org/tiles/bw-mapnik/{z}/{x}/{y}.png', {minZoom:0, maxZoom: 13})
		new L.Control.MiniMap(mini_mapa, { toggleDisplay: true }).addTo(mapa)

        mapa.fitBounds(capa_vias.getBounds())
	}

	var mapa = L.map('cont_mapa', {
		center: [6.176188, -75.354868],
		zoom: 15,
		minZoom: 5,
		maxZoom: 17,

	})

	var escala = L.control.scale({ position: 'bottomright', imperial: false});
    mapa.addControl(escala);

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	  maxZoom: 18,
	  attribution: 'Map data © OpenStreetMap contributors, ' +
	    'CC-BY-SA, ' +
	    'Imagery © Mapbox',
	  id: 'mapbox.light'
	}).addTo(mapa);

	dibujar_mapa(mapa)

	var popup = L.popup()
	mapa.on('click', generar_marcador)

	$("select").on("change", function(){
		dibujar_mapa(mapa)

	})
</script>