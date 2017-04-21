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
			<img src="<?php echo $this->view->imageformarker[0]['source'] ?>" id="tooltipsMap" alt="Map" style="width:100%" >
		<?php else: ?>
			<a href="admin/changeimage" class="button">Add Image</a>
		<?php endif ?>
		<div class="locations-tooltip" style="position:absolute; background:white; color:#333; border:1px solid #333; padding:5px; white-space:nowrap; font-size:12px; z-index:999"></div>
	</div>

	<ul>
	<?php if (!empty($this->view->imagewithmarkers)): ?>
		<?php foreach( $this->view->imagewithmarkers as $location ): ?>

				<form enctype="multipart/form-data" method="post" action="admin/imagewithmarkers/<?php echo $location['id'] ?>">
				<li class="showLi"> 
				<a class="showLi"> 
				<span style="cursor:pointer" data-target = "'.$location['id'].'"> Location - <?php echo $location['className'].' - '.$location['order_number'].' - '.$location['title'] ?></span><br/>
				<div style="display:none" class = "newsHidde panel-<?php echo $location['id'] ?>" >
				<label>Lat (%)</label><input class="x" type="text" name="locations[x]" value="<?php echo $location['x'] ?>">
				<label>Lng (%)</label><input class="y" type="text" name="locations[y]" value="<?php echo $location['y'] ?>">

				<label style="margin-top:5px">Order Number</label><input type=text style="width:533px;margin-top:5px" name="locations[order_number]" value="<?php echo $location['order_number'] ?>">
				<label style="margin-top:5px">Title</label><input type=text style="width:533px;margin-top:5px" name="locations[title]" value="<?php echo $location['title'] ?>">

				<label style="margin-top:5px">Url</label><input type=text style="width:533px;margin-top:5px" name="locations[link]" value="<?php echo $location['link'] ?>">
				<label style="margin-top:5px">Address</label><input type=text style="width:533px;margin-top:5px" name="locations[address]" value="<?php echo $location['address'] ?>">
				<label style="margin-top:5px">Phone</label><input type=text style="width:533px;margin-top:5px" name="locations[phone]" value="<?php echo $location['phone'] ?>">
				<label style="margin-top:5px">Description</label><input type=text style="width:533px;margin-top:5px" name="locations[description]" value="<?php echo $location['description'] ?>">

				<div class="cf"><label style="margin-top:5px">Title Position</label>
					<div class="select-style"><select style="width: 260px;margin-top: 10px;" name="locations[position]" >
						<option value="" <?php echo ($location['position'] == "" ? 'selected="selected"' : '') ?>>TOP</option>
						<option value="down" <?php echo ($location['position'] == "down" ? 'selected="selected"' : '') ?>>BOTTOM</option>	
						<option value="right" <?php echo ($location['position'] == "right" ? 'selected="selected"' : '') ?>>RIGHT</option>	
					</select></div></div>
				<div class="cf"><label style="margin-top:5px">Category</label>
					<div class="select-style"><select style="width: 260px;margin-top: 10px;" name="locations[className]" >
						<option value="parks" <?php echo ($location['className'] == "parks" ? 'selected="selected"' : '') ?>>Parks</option>
						<option value="grocery-stores" <?php echo ($location['className'] == "grocery-stores" ? 'selected="selected"' : '') ?>>Grocery Stores</option>
					
						<option value="specialty-markets" <?php echo ($location['className'] == "specialty-markets" ? 'selected="selected"' : '') ?>>Specialty Markets</option>
						<option value="schools" <?php echo ($location['className'] == "schools" ? 'selected="selected"' : '') ?>>Schools</option>
						<option value="restaurants" <?php echo ($location['className'] == "restaurants" ? 'selected="selected"' : '') ?>>Restaurants</option>
						<option value="convenience" <?php echo ($location['className'] == "convenience" ? 'selected="selected"' : '') ?>>Convenience</option>
						<option value="subway" <?php echo ($location['className'] == "subway" ? 'selected="selected"' : '') ?>>Subway & Bus</option>
						<option value="shopping" <?php echo ($location['className'] == "shopping" ? 'selected="selected"' : '') ?>>Shopping</option>		
					</select></div></div>
				<div class="cf"><input type="submit" value="Update" class="save-item"></div>
				<a style="float: left;margin-left: 20px;" href="admin/imagewithmarkers/delete/<?php echo $location['id'] ?>" class="button remove-item">delete</a>
				<div class="cf" style="padding-bottom: 20px;"></div>
				</div>
				</a>
				</li>
				</form>
			<?php endforeach ?>
		<?php endif ?>
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
	$('span').click(function(event) {
		// $(this).toggle();
		$(this).parent().parent().children('.newsHidde').toggle();
		$(this).parent().parent().children('.newsHidde').toggleClass('openDraw');
	});

	$('#tooltipsMap').click(function(e) {
		var x = e.pageX - $(this).offset().left;
		var y = e.pageY - $(this).offset().top;

		var xp = x*100/$(this).width();
		var yp = y*100/$(this).height();
		console.log($('.openDraw').length);
		
		if ($('.openDraw').length != 1) {
			alert("Open one element for editing!");
		}
		else {
			$('.openDraw').first().children().children('input[name="locations[x]"]').attr('value', xp.toFixed(1));
			$('.openDraw').first().children().children('input[name="locations[y]"]').attr('value', yp.toFixed(1));
		}
	});
</script>