<div class="admin-header">
	<h1>Change image</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<form action="" method="post" enctype="multipart/form-data">
		<label>Image</label>
		<div class="file-input-wrap cf">
			<?php if (!empty($this->view->imageformarker[0]['source'])): ?>				
				<div class="small-image-preview" style="background-image: url(<?php echo $this->view->imageformarker[0]['source']?>)"></div>
			<?php endif ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[source]"/>
				</div>
		</div>

		<input type="submit" value="Update" class="save-item">
	</form>
</div>
