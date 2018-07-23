<div class="admin-header">
	<h1>Add portfolio</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<form action="admin-portfolio/save" method="post" enctype="multipart/form-data">

		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="Title">

		<label for="subtitle">Sub Title:</label>
		<textarea placeholder="Sub Title" name="subtitle"></textarea>
		
		<label for="description">Description:</label>
		<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1"></textarea>
		
		<label for="location">Location:</label>
		<input type="text" name="location" placeholder="Location">
		
		<label for="address">Address:</label>
		<textarea placeholder="Address" name="address"></textarea>
		
		<label for="website">Website:</label>
		<input type="text" name="website" placeholder="Website">
		
		<label>Logo</label>
		<div class="file-input-wrap cf">
			<div class="fileUpload">
				<span>Choose file</span>
				<input type="file" name="elements[logo]"/>
			</div>
		</div>

		<label>Thumb</label>
		<div class="file-input-wrap cf">
			<div class="fileUpload">
				<span>Choose file</span>
				<input type="file" name="elements[thumb]"/>
			</div>
		</div>

		<label>Video</label>
		<div class="file-input-wrap cf">
			<div class="fileUpload">
				<span>Choose file</span>
				<input type="file" name="elements[video]"/>
			</div>
		</div>

		<label>Video Image</label>
		<div class="file-input-wrap cf">
			<div class="fileUpload">
				<span>Choose file</span>
				<input type="file" name="elements[video_image]"/>
			</div>
		</div>

		<input type="submit" value="Add" class="save-item">
	</form>
</div>
