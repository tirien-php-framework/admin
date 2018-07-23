<div class="admin-header">
	<h1>Add image</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">

	<?php Alert::show() ?>

	<form class="upload-image-form" action="admin-gallery-images/save/<?php echo $this->view->galleryId, isset($this->view->imageId) ? "/".$this->view->imageId : "";?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="redirect_uri" value="<?php echo !empty($_GET['redirect']) ? $_GET['redirect'] : 'admin-gallery/edit/'. $this->view->galleryId ?>">
	
		
			<label>Image</label>
			<div class="gallery-wrap"> 
				<?php if (isset($this->view->galleryimage)): ?> 
					<img style="width:100%" class="small-preview" src="public/<?php echo $this->view->galleryimage->getSource() ?>"/>
				<?php else: ?>
					<div class="fileUpload" >
					    <span>Choose images</span>
					    <input type="file" class="upload" name="source[]" multiple="multiple"/>
					</div>
				<?php endif ?>
			</div>
			<div class="cf"></div>
		 
			<?php if (isset($this->view->galleryimage)): ?> 
				<?php if (empty($_GET['redirect'])): ?>
					
					<label>Title</label>
					<input name="title" type="text" value="<?php echo (isset($this->view->galleryimage)) ? $this->view->galleryimage->getTitle() : '' ?>">

					<label>Thumbnail</label>
					<div class="file-input-wrap cf">
						<?php if(!empty($this->view->galleryimage->getThumb())): ?>
							<div class="small-image-preview" style="background-image: url(<?php echo $this->view->galleryimage->getThumb() ?>)"></div>
							<input type="checkbox" name="delete_thumb" value="1">Delete this file?
						<?php else: ?>
							<div class="fileUpload">
								<span>Choose file</span>
								<input type="file" name="elements[thumb]"/>
							</div>
						<?php endif ?>
					</div>				

					<!-- <label>Blur</label>
					<div class="file-input-wrap cf">
						<?php if(!empty($this->view->galleryimage->getBlur())): ?>
							<div class="small-image-preview" style="background-image: url(<?php echo $this->view->galleryimage->getBlur() ?>)"></div>
							<input type="checkbox" name="delete_blur" value="1">Delete this file?
						<?php else: ?>
							<div class="fileUpload">
								<span>Choose file</span>
								<input type="file" name="elements[blur]"/>
							</div>
						<?php endif ?>
					</div> -->
								
					<label>Text</label>
					<textarea name="text"><?php echo (isset($this->view->galleryimage)) ? $this->view->galleryimage->getText() : '' ?></textarea>

				<?php endif ?>
			<?php endif ?>
		 
		<input name="gallery_id" type="hidden" value="<?php echo $this->view->galleryId ?>">
		<input name="gallery_width" type="hidden" value="<?php echo $this->view->gallery['width'] ?>">
		<input name="gallery_height" type="hidden" value="<?php echo $this->view->gallery['height'] ?>">
		<input name="thumb_width" type="hidden" value="<?php echo $this->view->gallery['thumb_width'] ?>">
		<input name="thumb_height" type="hidden" value="<?php echo $this->view->gallery['thumb_height'] ?>">
		<input name="manual_crop" type="hidden" value="false">
		<!--
			<label>Large</label><input class="lower" name="large[]" type="file" multiple >
		

		
			<label>Visible</label><input name="visible" type="checkbox" <?php echo (isset($this->view->galleryimage)) && $this->view->galleryimage->getVisible() ? 'checked' : '' ?>>
				
		-->
		<?php if (!isset($this->view->galleryimage)): ?> 
			<div class="action-wrap cf">
				<button class="button submit-auto-crop save-item long-button">Save with automatic crop</button>
				<button class="button submit-manual-crop save-item long-button">Save with manual crop</button>
			</div>
		<?php endif ?>

			<br><br>

			<div class="action-wrap cf">
				<?php if (!empty($_GET['redirect'])): ?>
					<a href="<?php echo $_GET['redirect'] ?>" class="button back-button">Back to Gallery</a>
				<?php else: ?>
					<a href="admin-gallery/edit/<?php echo $this->view->galleryId ?>" class="button back-button">Back to Gallery</a>
				<?php endif ?>
				<?php if (isset($this->view->galleryimage)): ?> 
					<button type="submit" class="button save-item long-button">Save</button>
				<?php endif ?>
			</div>
	
	</form>
</div>

<script type="text/javascript">
	
	$(".submit-auto-crop").click(function(e) {	
		e.preventDefault();	
		if( $(".upload-image-form input[type=file]").get(0).files.length == 0 ){
			alert("Select file to upload");
		}
		else{
			$(".upload-image-form").submit();
		}
	});

	$(".submit-manual-crop").click(function(e) {		
		e.preventDefault();

		if( $(".upload-image-form input[type=file]").get(0).files.length == 0 ){
			alert("Select file to upload");
		}
		else if( $(".upload-image-form input[type=file]").get(0).files.length > 1 ){
			alert("Only one image at the time can be upoaded with manual crop");
		}
		else{
			$("input[name='manual_crop']").val("true")
			$(".upload-image-form").submit();
		}
	});

</script>