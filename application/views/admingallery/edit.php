<div class="admin-header">
	<h1>Edit Gallery</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">

	<?php Alert::show() ?>

<form action="admin-gallery/save/<?php echo $this->view->gallery['id'] ?>" enctype="multipart/form-data" method="post">

	<label><?php echo $this->view->gallery['title'] ?></label>
	<input name="title" type="text" value="<?php echo $this->view->gallery['title'] ?>">
		
		<div class="action-wrap">
			<a class="button" style="margin-left: 0px;" href="admin-gallery-images/edit/<?php echo $this->view->gallery['id'] ?>">Add image</a>
		</div>

		<br><br><br>

		<div class="cf"></div>


	<?php if (!empty($this->view->galleryImages) ){ ?>		
			<div class="gallery-wrap"> 
				<ul class="image-list cf">
				<?php foreach ($this->view->galleryImages as $image){ ?>
						<li class="items-order" >
							<div class="buttons">
								<div class="button remove-image delete" data-gallery-id="<?php echo $this->view->gallery['id'] ?>" data-image-id="<?php echo $image['id'] ?>">Delete</div>
							</div>
							<div style="background-image: url('public/<?php echo $image['source']."?v=".time() ?>');height: 110px;background-position: center;background-size: cover;" onclick="window.location = 'admin-gallery-images/edit/<?php echo $this->view->gallery['id'] ?>/<?php echo $image['id'] ?>'"></div>
 
							<input type="hidden" name="order[]" value="<?php echo $image['id'] ?>">
						</li>
				<?php  } ?>
			</div>	
					
		<div class="action-wrap">
			<input type="submit" value="Save" class="save-item">
		</div>

	<?php }else{ ?>
		<div style="text-align:center; color:#ccc; margin-top:0px">No uploaded images</div>
	<?php } ?>


	</form>
</div>

<script>

	$('.image-list').sortable();

	$('.remove-image').click(function(e){
		e.preventDefault();
  	
		if (confirm("Are you sure you want remove image?")) {
			window.location = "admin-gallery-images/remove/"+$(this).data('gallery-id')+"/"+$(this).data('image-id');
		}
		
	})

</script>
