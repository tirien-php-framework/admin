<div class="admin-header">
	<h1>Category</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
    <?php Alert::show() ?>
	
	<form action="admin-blogcategory/save/<?php echo !empty($this->view->category['id']) ? $this->view->category['id'] : 'new' ?>" method="post" enctype="multipart/form-data">

		<label>Title</label>
		<input type="text" name="title" value="<?php echo  $this->view->category['title'] ?>">

		<label>Subtitle</label>
		<input type="text" name="subtitle" value="<?php echo $this->view->category['subtitle'] ?>">

		<label>Excerpt</label>
		<textarea name="excerpt" class="htmlEditorTools" rows="5"><?php echo $this->view->category['excerpt'] ?></textarea>

		<label>Description</label>
		<textarea name="description" class="htmlEditor" rows="15" data-page-name="category" data-page-id="<?php echo !empty($this->view->category['id']) ? $this->view->category['id'] : 'new' ?>" id="editor-<?php echo  str_replace('.', '', !empty($this->view->category['id']) ? $this->view->category['id'] : 'new')  ?>"><?php echo $this->view->category['description'] ?></textarea>

		<label>Thumbnail</label>
		<div class="file-input-wrap cf">
			<?php if(!empty($this->view->category['thumb'])): ?>
				<div class="small-image-preview" style="background-image: url(<?php echo $this->view->category['thumb'] ?>)"></div>
				<input type="checkbox" name="delete_thumb" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[thumb]"/>
				</div>
			<?php endif ?>
		</div>

		<label>Menu Order</label>

		<div class="select-style">
			<select name="menu_order">
				<?php foreach ($this->view->categories as $key => $value): ?>
					<option value="<?php echo $key ?>" <?php if($key==$this->view->category['menu_order']):?> selected <?php endif ?>><?php echo $key ?></option> 
				<?php endforeach ?>
			
				<?php if (empty($this->view->category['id'])): ?>
					<option value="0" selected>0</option>
				<?php endif ?>
			</select>
		</div>
		<div class="cf"></div>
		<br>

		<label>SEO Title</label>
		<input type="text" name="seo_title" value="<?php echo $this->view->category['seo_title'] ?>">

		<label>SEO Description</label>
		<input type="text" name="seo_description" value="<?php echo $this->view->category['seo_description'] ?>">

		<label>SEO Keywords</label>
		<input type="text" name="seo_keyword" value="<?php echo $this->view->category['seo_keyword'] ?>">

		<input type="submit" value="Save" class="save-item">

		<?php if (!empty($this->view->category['id'])): ?>
			<a class="button remove-item" href="admin-blogcategory/remove/<?php echo $this->view->category['id'] ?>">Delete</a>
		<?php endif ?>
	</form>
	
	<script>
		
		$('input[name="title"]').keyup(function() {
			$('input[name="slug"]').val($(this).val().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, ""));
		})
	</script>
	
	
</div>
