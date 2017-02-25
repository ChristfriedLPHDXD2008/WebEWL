<h1>Unser Laden</h1>
<hr>
<style type="text/css">
	.olControlAttribution {
		bottom: 3px!important;
		font-size: 12px;
	}
	#map {
		width: 100%;
		height:400px;
		border: 2px solid rgba(0,0,0,0.6);
	}
</style>

<div id="map"></div>

<script type="text/javascript">
	var map;
	function showMap() {
		map = new OpenLayers.Map("map");
		var mapnik = new OpenLayers.Layer.OSM();
		map.addLayer(mapnik);
		map.setCenter(new OpenLayers.LonLat(14.178300000000036,51.1266)
			.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913")), 16);
		map.addLayer(new OpenLayers.Layer.Markers());
		var marker = new OpenLayers.Marker(map.getCenter());
		marker.events.register("mousedown", marker, function(evt) {
			alert("\"Pax et Bonum\" - Eine Welt Laden e.V.\nDresdener Straße 11, 01877 Bischofswerda");
			OpenLayers.Event.stop(evt);
		});
		map.layers[map.layers.length-1].addMarker(marker);
		var pin = $("#OL_Icon_37_innerImage");
		pin.attr("src", "/img/landmark.png");
		pin.height(32); pin.width(20);
		//pin.height(0); pin.width(0);
		$("#OL_Icon_37").css("top", 160)
	}
	$(document).ready(function () {
		showMap();
	});
</script>