<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="public/admin/js/t.tooltips.js"></script>
<link rel="stylesheet" href="public/admin/js/t.tooltipdots/t.tooltipdots.css" type="text/css">
<style>
	.tooltipPoint span{
		font-size: 16px;
	}
	.tooltipPoint{
		width: 27px;
		height: 27px;
	}
</style>
<div class="admin-header">
	<h1>Image with Markers</h1>
	<span class="last-update"></span>	
	<div class="button-wrap">	
		<a href="admin/imagewithmarkers/add" class="button right">Add item</a>
		<a href="admin/changeimage" class="button right">Change Image</a>
	</div>
</div>
<?php
	if( !empty($_GET['message']) ) {
		echo '<span class="responseMessage">'.$_GET['message'].'</span>';
	} 
?>

<div class="admin-content">

	<?php Alert::show() ?>

	<div class="tooltipsWrap">
		<?php if (count($this->view->imageformarker)): ?>
			<img src="<?php echo $this->view->imageformarker[0]['source'] ?>" alt="Map" style="width:100%" >
		<?php else: ?>
			<a href="admin/changeimage" class="button">Add Image</a>
		<?php endif ?>
		<div class="locations-tooltip" style="position:absolute; background:white; color:#333; border:1px solid #333; padding:5px; white-space:nowrap; font-size:12px; z-index:999"></div>
	</div>

	<ul>
	<?php 
		if (!empty($this->view->imagewithmarkers)) {
			foreach( $this->view->imagewithmarkers as $location ){

				echo '<form enctype="multipart/form-data" method="post" action="admin/imagewithmarkers/'.$location['id'].'">';
				echo '<li class="showLi">'; 
				echo '<a class="showLi">'; 
				echo '<span style="cursor:pointer" data-target = "'.$location['id'].'">Location - '.$location['className'].' - '.$location['order_number'].' - '.$location['title'].'</span><br/>';
				echo '<div style="display:none" class = "newsHidde panel-'.$location['id'].'" >';
				echo '<label>Lat (%)</label><input class="x" type="text" name="locations[x]" value="'.$location['x'].'">';
				echo '<label>Lng (%)</label><input class="y" type="text" name="locations[y]" value="'.$location['y'].'">';
				echo '<label style="margin-top:5px">Title</label><input type=text style="width:533px;margin-top:5px" name="locations[title]" value="'.$location['title'].'">';

				// echo '<label style="margin-top:5px">Link</label><input type=text style="width:533px;margin-top:5px" name="locations[link]" value="'.$location['link'].'">';

				echo '<label style="margin-top:5px">Order Number</label><input type=text style="width:533px;margin-top:5px" name="locations[order_number]" value="'.$location['order_number'].'">';
				echo '<div class="cf"><label style="margin-top:5px">Title Position</label>
					<div class="select-style"><select style="width: 260px;margin-top: 10px;" name="locations[position]" >
						<option value="" '.($location['position'] == "" ? 'selected="selected"' : '').'>TOP</option>
						<option value="down" '.($location['position'] == "down" ? 'selected="selected"' : '').'>BOTTOM</option>	
						<option value="right" '.($location['position'] == "right" ? 'selected="selected"' : '').'>RIGHT</option>	
					</select></div></div>';
				echo '<div class="cf"><label style="margin-top:5px">Category</label>
					<div class="select-style"><select style="width: 260px;margin-top: 10px;" name="locations[className]" >
						<option value="parks" '.($location['className'] == "parks" ? 'selected="selected"' : '').'>Parks</option>
						<option value="grocery-stores" '.($location['className'] == "grocery-stores" ? 'selected="selected"' : '').'>Grocery Stores</option>
					
						<option value="specialty-markets" '.($location['className'] == "specialty-markets" ? 'selected="selected"' : '').'>Specialty Markets</option>
						<option value="schools" '.($location['className'] == "schools" ? 'selected="selected"' : '').'>Schools</option>
						<option value="restaurants" '.($location['className'] == "restaurants" ? 'selected="selected"' : '').'>Restaurants</option>
						<option value="convenience" '.($location['className'] == "convenience" ? 'selected="selected"' : '').'>Convenience</option>
						<option value="subway" '.($location['className'] == "subway" ? 'selected="selected"' : '').'>Subway & Bus</option>
						<option value="shopping" '.($location['className'] == "shopping" ? 'selected="selected"' : '').'>Shopping</option>		
					</select></div></div>';
				echo '<div class="cf"><input type="submit" value="Update" class="save-item"></div>';
				echo '<div class="cf" style="padding-bottom: 20px;"><a style="float: left;margin-left: 20px;" href="admin/imagewithmarkers/delete/'.$location['id'].'" class="button remove-item">delete</a></div>';
				echo "</div>";
				echo '</a>';
				echo '</li>';
				echo '</form>';
		 	} 
		}
	 ?>
	</ul>
</div>
<script>
    tooltipsData = [
   		<?php foreach ($this->view->imagewithmarkers as $key => $value) { ?>
    		{ x:"<?php echo $value['x'] ?>", y:"<?php echo $value['y'] ?>", content:"<?php echo $value['title'] ?>", orderNumber:"<?php echo $value['order_number'] ?>", className:"<?php echo $value['className'] ?>",position:"<?php echo $value['position'] ?>",}
    		
    	<?php if ( count($this->view->imagewithmarkers)-1 > $key) {
    			echo ',';
    		}
    	}  ?>    	
    ] 
    
    drawTooltips(".tooltipsWrap", tooltipsData);

</script>

<script>
	$('.showLi').click(function(event) {
		// $(this).toggle();
		$(this).children('.newsHidde').toggle();
	});
	$('.newsHidde').click(function(event) {
		// $(this).toggle();
		$(this).toggle();
	});

	$('[data-target]').click(function(e){
		e.preventDefault();
		$('.panel-'+$(this).data('target')).stop(true,true).fadeToggle("slow");
		
	});
</script>