<div id="cont_mapa" class="margen_mapa"></div>

<script type="text/javascript">
	$(document).ready(function(){
		// Variables
	    let sector = parseFloat($("#select_sector_filtro").val())
	    let via = parseFloat($("#select_via_filtro").val())
	    let id_sector = (sector || sector > 0) ? sector : null
	    let id_via = (via || via > 0) ? via : null

		var mapa = generar_mapa("cont_mapa")
		marcar(mapa, "incidentes")

	 //    var kilometros = ajax(`${$("#url").val()}/filtros/obtener`, {"tipo": "vias_geometria", "id": {"id_sector": id_sector, "id_via": id_via}}, 'JSON')

  //   var lineas = []

		// new L.geoJson(kilometros, {
	 //        style: {
	 //            "color": "#555555",
	 //            "weight": 5,
	 //            "opacity": 1
	 //        },
	 //        onEachFeature: function(feature, layer) {
	 //            let km = feature.geometry.coordinates

	 //            for (i = 0; i < km.length; i++) {
	 //                lineas.push(km[i].reverse())
	 //            }

	 //            L.polyline(lineas, 
	 //                {color: 'red'}
	 //            )
	 //        },
	 //    })

		$("select").on("change", function(){
			marcar(mapa, "incidentes")
		})
	})
</script>