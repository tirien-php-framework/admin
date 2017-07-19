<div class="admin-header">
	<h1>Edit location</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
		<?php Alert::show() ?>

	<form action="admin-location/update/<?php echo $this->view->location['id'] ?>" method="post" enctype="multipart/form-data">
		<label>Title</label>
		<input type="text" name="title" placeholder="Location title" value="<?php echo $this->view->location['title'] ?>">

		<label for="category">Category:</label>
		<input type="text" name="category" placeholder="Category"value="<?php echo $this->view->location['category'] ?>">
		
		<div class="input-wrap">
			<label>Adress:</label>
			<input type="text" name="address" placeholder="Address for finding location" id="address" value="<?php echo $this->view->location['address'] ?>"/>

		<div id="locate" class="button dark item">Locate</div>

		<div class="static-map-wrap" style="height: auto;z-index: 1;">
			<div id="map" style="width: 100%;min-height: 300px;margin-bottom: 24px;"></div>								
		</div>

		<label for="latitude">Latitude:</label>
			<input type="text" name="latitude" placeholder="Latitude" id="latitude" value="<?php echo $this->view->location['latitude'] ?>"/>
		<label for="longitude">Longitude:</label>
			<input type="text" name="longitude" placeholder="Longitude" id="longitude" value="<?php echo $this->view->location['longitude'] ?>"/>

		<label for="longitude">Zoom:</label>
			<input type="text" name="zoom" id="zoom" placeholder="zoom" value="<?php echo $this->view->location['zoom'] ?>"/>

		<input type="hidden" id="mapImage"/>

		<label for="description">Description:</label>
		<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1"><?php echo $this->view->location['description'] ?></textarea>
		
		<label for="phone">Phone:</label>
		<input type="text" name="phone" placeholder="Phone" value="<?php echo $this->view->location['phone'] ?>">

		<label>URL</label>
		<input type="text" name="url" placeholder="Url" value="<?php echo $this->view->location['url'] ?>">

		<label>Image</label>
		<div class="file-input-wrap cf">
			<?php if (!empty($this->view->location['image'])): ?>				
				<div class="small-image-preview" style="background-image: url(<?php echo $this->view->location['image']?>)"></div>
				<input type="checkbox" name="delete_image" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[image]"/>
				</div>
			<?php endif ?>
		</div>

		<label>Thumb Image</label>
		<div class="file-input-wrap cf">
			<?php if (!empty($this->view->location['thumb'])): ?>
				<div class="small-image-preview" style="background-image: url(<?php echo $this->view->location['thumb']?>)"></div>
				<input type="checkbox" name="delete_thumb_image" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[thumb]"/>
				</div>
			<?php endif ?>
		</div>

		<label>Marker Image</label>
		<div class="file-input-wrap cf">
			<?php if (!empty($this->view->location['marker_image'])): ?>
				<div class="small-image-preview" style="background-image: url(<?php echo $this->view->location['marker_image']?>)"></div>
				<input type="checkbox" name="delete_marker_image" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[marker_image]"/>
				</div>
			<?php endif ?>
		</div>

		<div class="cf">
			<label>Custom color:</label>
			<input type="text" name="custom_color" id="color_value" class="jscolor {valueElement:color_value,value:'<?php echo $this->view->location['custom_color']?>', closable:true,closeText:'Close'}">
		</div>
		<br>

		<div class="cf">
			<label>Map</label>

			<div class="select-style">
				<select name="map_id">
					<option value="0">Choose map</option>
				
					<?php foreach ($this->view->maps as $map): ?>						
						<option value="<?php echo $map['id'] ?>"<?php echo ($map['id'] == $this->view->location['map_id']) ? "selected" : "" ?>><?php echo $map['title'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>

		<input type="submit" value="Update" class="save-item">

		<a href="admin-location/delete/<?php echo $this->view->location['id'] ?>" class="button remove-item">Delete location</a>
	</form>

	<script src='public/scripts/admin/jscolor.min.js'></script>
	<script src="https://maps.googleapis.com/maps/api/js"></script>
	<script>
		$('#latitude').keyup(function(event) {
			var lat = $(this).val();
			initMap(lat, $('#longitude').val());
		});

		$('#longitude').keyup(function(event) {
			var lng = $(this).val();
			initMap($('#latitude').val(), lng);
		});

		var map;
		var markers = [];
		var deleteMarkers;

		function initMap(lat = null, lng = null) {
			var mapDiv = document.getElementById('map');
			var lat = lat != null ? parseFloat(lat) : <?php echo $this->view->location['latitude'] ?>;
			var lng = lng != null ? parseFloat(lng) : <?php echo $this->view->location['longitude'] ?>;

			map = new google.maps.Map(mapDiv, {
				center: { lat: lat, lng: lng },
				zoom: <?php echo $this->view->location['zoom'];?> ,
				scrollwheel: false,
			});

			document.getElementById('locate').addEventListener('click', function() {
		    	var address = document.getElementById("address").value;
				codeAddress(address,'true',map);
				map.setZoom(<?php echo $this->view->location['zoom'];?>);

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
			var mapSrc = 'https://maps.googleapis.com/maps/api/staticmap?center='+lat+','+lng+'&zoom='+zoom+'&scale=2&size=640x300&maptype=roadmap&key=AIzaSyCvMo4tix_7-gqUXt4QQuA8buWLcxzLyMw&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xf17201%7Clabel:%7C'+lat+','+lng

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
