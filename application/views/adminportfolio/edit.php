<div class="admin-header">
	<h1>Edit portfolio</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<form action="admin-portfolio/update/<?php echo $this->view->portfolio['id']; ?>" method="post" enctype="multipart/form-data">

		<label>Title</label>
		<input type="text" name="title" placeholder="Location title" value="<?php echo $this->view->portfolio['title']; ?>">

		<label for="subtitle">Sub Title:</label>
		<textarea placeholder="Sub Title" name="subtitle"><?php echo $this->view->portfolio['subtitle']; ?></textarea>

		<label for="description">Description:</label>
		<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1"><?php echo $this->view->portfolio['description']; ?></textarea>

		<label for="location">Location:</label>
		<input type="text" name="location" placeholder="Location" value="<?php echo $this->view->portfolio['location']; ?>">
		
		<label for="address">Address:</label>
		<textarea placeholder="Address" name="address"><?php echo $this->view->portfolio['address']; ?></textarea>
		
		<label for="website">Website:</label>
		<input type="text" name="website" placeholder="Website" value="<?php echo $this->view->portfolio['website']; ?>">

		<label>Thumb Image</label>
		<div class="file-input-wrap cf">
			<?php if (!empty($this->view->portfolio['thumb'])): ?>
				<div class="small-image-preview" style="background-image: url(<?php echo $this->view->portfolio['thumb']?>)"></div>
				<input type="checkbox" name="delete_thumb" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[thumb]"/>
				</div>
			<?php endif ?>
		</div>

		<label>Logo</label>
		<div class="file-input-wrap cf">
			<?php if (!empty($this->view->portfolio['logo'])): ?>
				<div class="small-image-preview" style="background-image: url(<?php echo $this->view->portfolio['logo']?>)"></div>
				<input type="checkbox" name="delete_logo" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[logo]"/>
				</div>
			<?php endif ?>
		</div>

		<label>Video</label>
		<div class="file-input-wrap cf">
			<?php if (!empty($this->view->portfolio['video'])): ?>
				<video id="propertyVideo" width="200px" height="100%" controls autoplay>
					<source src="<?php echo $this->view->portfolio['video'] ?>" type="video/mp4">
					Your browser does not support the video tag.
				</video><br>
				<input type="checkbox" name="delete_video" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[video]"/>
				</div>
			<?php endif ?>
		</div>

		<label>Video Image</label>
		<div class="file-input-wrap cf">
			<?php if (!empty($this->view->portfolio['video_image'])): ?>
				<div class="small-image-preview" style="background-image: url(<?php echo $this->view->portfolio['video_image']?>)"></div>
				<video id="propertyVideo" width="200px" height="100%" controls autoplay>
					<source src="<?php echo $this->view->portfolio['video_image'] ?>" type="video/mp4">
					Your browser does not support the video tag.
				</video><br>
				<input type="checkbox" name="delete_video_image" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[video_image]"/>
				</div>
			<?php endif ?>
		</div>
		
		<input type="submit" value="Update" class="save-item fixed-save-button">

		<a href="admin-portfolio/remove/<?php echo $this->view->portfolio['id']; ?>" class="button remove-item">Delete portfolio</a>
	</form>

	<div class="cf">
		<br><hr><br>
	</div>

	<form action="admin-gallery/save/<?php echo $this->view->gallery['id'] ?>" enctype="multipart/form-data" method="post">

		<label><?php echo $this->view->gallery['title'] ?></label>
		<input name="title" disabled type="hidden" value="<?php echo $this->view->gallery['title'] ?>">
		<input name="redirect_uri" type="hidden" value="<?php echo Path::pageUrl() ?>">

			<br><br>
			<div class="action-wrap">
				<a class="button" style="margin-left: 0px;" href="admin-gallery-images/edit/<?php echo $this->view->gallery['id'] ?>?redirect=<?php echo Path::pageUrl() ?>">Add image</a>
			</div>

			<br><br><br>

			<div class="cf"></div>


		<?php if (!empty($this->view->galleryImages) ){ ?>		
				<div class="gallery-wrap"> 
					<ul class="image-list cf">
					<?php foreach ($this->view->galleryImages as $image){ ?>
							<li class="items-order" >
								<div class="buttons">
									<div class="button remove-image delete" data-gallery-id="<?php echo $this->view->gallery['id'] ?>" data-image-id="<?php echo $image['id'] ?>" data-redirect="<?php echo Path::urlUri() ?>">Delete</div>
								</div>
								<div style="background-image: url('public/<?php echo $image['source']."?v=".time() ?>');height: 110px;background-position: center;background-size: cover;" onclick="window.location = 'admin-gallery-images/edit/<?php echo $this->view->gallery['id'] ?>/<?php echo $image['id'] ?>?redirect=<?php echo Path::urlUri() ?>'"></div>
	 
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
	<br>

	<script>

		$('.image-list').sortable();

		$('.remove-image').click(function(e){
			e.preventDefault();
	  	
			if (confirm("Are you sure you want remove image?")) {
				window.location = "admin-gallery-images/remove/"+$(this).data('gallery-id')+"/"+$(this).data('image-id')+"?redirect="+$(this).data('redirect');
			}
			
		})

	</script>	
</div>