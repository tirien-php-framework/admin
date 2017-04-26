<div class="admin-header">
	<h1>Edit Event</h1>
</div>

<div class="admin-content">

	<?php Alert::show() ?>

	<form action="admin/seo/update/<?php echo $this->view->seo['id']; ?>" method="post" enctype="multipart/form-data">
		<label>Uri</label>
		<input type="text" name="uri" value="<?php echo $this->view->seo['uri'] ?>">
        
		<label>Title</label>
		<input type="text" name="title" value="<?php echo $this->view->seo['title'] ?>">
        
        <label>Description</label>
        <textarea id="content" name="description" runat="server" rows="3" maxlength="160"><?php echo $this->view->seo['description'] ?></textarea>

		<label>Keyword</label>
		<input type="text" name="keywords" value="<?php echo $this->view->seo['keywords'] ?>">

		<label>Image</label>
		<div class="file-input-wrap cf">
			<?php if (!empty($this->view->seo['image'])): ?>				
				<div class="small-image-preview" style="background-image: url(<?php echo $this->view->seo['image']?>)"></div>
				<input type="checkbox" name="delete_image" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[image]"/>
				</div>
			<?php endif ?>
		</div>

		<div class="action-wrap">
			<input type="submit" value="Update" class="save-item">
			<a href="admin/seo/delete/<?php echo $this->view->seo['id']; ?>" class="confirm-action button remove-item">Delete</a>
		</div>
	</form>
</div>