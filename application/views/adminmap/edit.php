<div class="admin-header">
	<h1>Edit map</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<form action="admin-map/update/<?php echo $this->view->map['id']; ?>" method="post" enctype="multipart/form-data">

		<label>Title</label>
		<input type="text" name="title" placeholder="Location title" value="<?php echo $this->view->map['title']; ?>">

		<label for="description">Description:</label>
		<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1"><?php echo $this->view->map['description']; ?></textarea>
		
		<div class="input-wrap">
			<label>Adress:</label>
			<input type="text" name="address" placeholder="Address for finding map" id="address" value="<?php echo $this->view->map['address']; ?>"/>

		<div id="locate" class="button dark item">Locate</div>

		<div class="static-map-wrap" style="height: auto;z-index: 1;">
			<div id="map" style="width: 100%;min-height: 300px;margin-bottom: 24px;"></div>								
		</div>

		<label for="latitude">Latitude:</label>
			<input type="text" name="latitude" placeholder="Latitude" id="latitude" value="<?php echo $this->view->map['latitude']; ?>"/>
		<label for="longitude">Longitude:</label>
			<input type="text" name="longitude" placeholder="Longitude" id="longitude" value="<?php echo $this->view->map['longitude']; ?>"/>

		<input type="text" name="zoom" id="zoom" placeholder="zoom" value="<?php echo $this->view->map['zoom']; ?>" />
		<input type="hidden" id="mapImage"/>

		<input type="submit" value="Update" class="save-item">

		<a href="admin-map/remove/<?php echo $this->view->map['id']; ?>" class="button remove-item">Delete map</a>
	</form>

	<script src="https://maps.googleapis.com/maps/api/js"></script>
	<script>

	var map;
	var markers = [];
	var deleteMarkers;

	function initMap() {
		var mapDiv = document.getElementById('map');
		var lat = <?php echo $this->view->map['latitude']; ?>;
		var lng = <?php echo $this->view->map['longitude']; ?>;

		map = new google.maps.Map(mapDiv, {
			center: { lat: lat, lng: lng },
			zoom: <?php echo $this->view->map['zoom']; ?> ,
			scrollwheel: false,
		});

		document.getElementById('locate').addEventListener('click', function() {
	    	var address = document.getElementById("address").value;
			codeAddress(address,'true',map);
			map.setZoom(<?php echo $this->view->map['zoom']; ?>);

		});

		map.addListener('zoom_changed', function(event) {
		    $('#zoom').val(map.getZoom());

		    setStaticMap($('#latitude').val(), $('#longitude').val(), map.getZoom());
		});

		google.maps.event.addListener(map, 'click', function(event) {
			placeMarker(event.latLng, map);
		});
	}

	initMap();


	function placeMarker(latLng, map) {
		deleteMarkers();		

	    var marker = new google.maps.Marker({
	    	icon: 'images/map-marker-orange.png',
	        position: latLng, 
	        map: map
	    });

	    $('#latitude').val(latLng.lat());
	    $('#longitude').val(latLng.lng());
	    $('#zoom').val(map.getZoom());

	    // setStaticMap(latLng.lat(), latLng.lng(), map.getZoom());

	    // add marker in markers array
	    markers.push(marker);
	    //center map by marker
	    map.panTo(latLng);
	}

	function setStaticMap(lat,lng,zoom){
		var mapSrc = 'https://maps.googleapis.com/maps/api/staticmap?center='+lat+','+lng+'&zoom='+zoom+'&scale=2&size=640x300&maptype=roadmap&key='+_googleAPIkey+'&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xf17201%7Clabel:%7C'+lat+','+lng

		// $('#staticMapImage').attr('src',mapSrc);
		$('#mapImage').val(mapSrc);
	}

	deleteMarkers = function() {
	  	for (var i = 0; i < markers.length; i++) {
		    markers[i].setMap(null);
	  	}
	  	markers = [];
	}
	// end google map		

	// get lat and lng from  address
	geocoder = new google.maps.Geocoder();

	$('#locate').click(function(){
		var address = document.getElementById("address").value;
		codeAddress(address,'true',map);
	})
	</script>
</div>