<form action="admin-gallery-images/savepage/<?php echo $this->view->galleryId ?>" enctype="multipart/form-data" method="post">
<ul>
	<li>
		<label>Title</label><input name="title" type="text" value="<?php echo (isset($this->view->projectgalleryimage)) ? $this->view->projectgalleryimage->getTitle() : '' ?>">
	</li>
	<li>
		<label>Text</label><input name="text" type="text" value="<?php echo (isset($this->view->projectgalleryimage)) ? $this->view->projectgalleryimage->getText() : '' ?>">
	</li>
	<li>
		<label>Image</label><input class="lower" name="source[]" type="file" multiple >
		<div style="float: left;margin-left: 172px;" class="inputNote">( attach large image )</div>
	</li>
	<!-- <li>
		<label>Thumb</label><input class="lower" name="thumb[]" type="file" multiple >
	</li> -->
	<input name="gallery_id" type="hidden" value="<?php echo $this->view->galleryId ?>">
	<!--<li>
		<label>Large</label><input class="lower" name="large[]" type="file" multiple >
	</li>

	<li>
		<label>Visible</label><input name="visible" type="checkbox" <?php echo (isset($this->view->projectgalleryimage)) && $this->view->projectgalleryimage->getVisible() ? 'checked' : '' ?>>
			</li>
	<li>-->
		<div class="cf"></div>
		<button type="submit">Save</button>
		<a href="admin-gallery/editpage/<?php echo $this->view->galleryId ?>" class="button">back to gallery</a>
	</li>
</ul>
</form>
