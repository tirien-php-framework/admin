<div class="admin-header">
	<h1>Add location</h1>
	<span class="last-update"></span>
</div>

	<div class="admin-content">
		<?php Alert::show() ?>
		
		<form action="admin-location/save" method="post" enctype="multipart/form-data">

			<label for="title">Title:</label>
			<input type="text" name="title" placeholder="Title">

			<label for="category">Category:</label>
			<textarea name="category" class="htmlEditor" rows="15" data-page-name="category" data-page-id="new" id="editor-1"></textarea>
					
			<div class="input-wrap">
				<label>Adress:</label>
				<input type="text" name="address" placeholder="Address for finding location" id="address"/>

			<div id="locate" class="button dark item">Locate</div>

			<div class="static-map-wrap" style="height: auto;z-index: 1;">
				<div id="map" style="width: 100%;min-height: 300px;margin-bottom: 24px;"></div>								
			</div>

			<label for="latitude">Latitude:</label>
				<input type="text" name="latitude" placeholder="Latitude" id="latitude" />

			<label for="longitude">Longitude:</label>
				<input type="text" name="longitude" placeholder="Longitude" id="longitude" />

			<label for="longitude">Zoom:</label>
				<input type="text" name="zoom" id="zoom" placeholder="zoom" />

			<input type="hidden" id="mapImage"/>

			<label for="description">Description:</label>
			<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1"></textarea>			
			
			<label for="phone">Phone:</label>
			<input type="text" name="phone" placeholder="Phone">
			
			<label for="url">URL:</label>
			<input type="text" name="url" placeholder="Url">
			
			<label>Image</label>
			<div class="file-input-wrap cf">
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[image]"/>
				</div>
			</div>
			
			<label>Thumb Image</label>
			<div class="file-input-wrap cf">
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[thumb]"/>
				</div>
			</div>

			<label>Marker Image</label>
			<div class="file-input-wrap cf">
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[marker_image]"/>
				</div>
			</div>

			<div class="cf">
				<label>Custom color:</label>
				<input type="text" name="custom_color" id="color_value" class="jscolor {valueElement:color_value,value:'ffffff', closable:true,closeText:'Close'}">
			</div>
			<br>

			<div class="cf">
				<label>Map</label>

				<div class="select-style">
					<select name="map_id">
						<option value="0">Choose map</option>				
							<?php foreach ($this->view->maps as $map): ?>
								<option value="<?php echo $map['id'] ?>"><?php echo $map['title'] ?></option>
							<?php endforeach ?>
					</select>
				</div>
			</div>
		
			<input type="submit" value="Add" class="save-item">
		</form>

		<script src='public/scripts/admin/jscolor.min.js'></script>
		<script src='https://maps.googleapis.com/maps/api/js'></script>
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
			var lat = lat != null ? parseFloat(lat) : 44.786568;
			var lng = lng != null ? parseFloat(lng) : 20.44892159999995;

			map = new google.maps.Map(mapDiv, {
				center: { lat: lat, lng: lng },
				zoom: 4 ,
				scrollwheel: false,
			});

			document.getElementById('locate').addEventListener('click', function() {
		    	var address = document.getElementById("address").value;
				codeAddress(address,'true',map);
				map.setZoom(12);

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

		    setStaticMap(latLng.lat(), latLng.lng(), map.getZoom());

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
