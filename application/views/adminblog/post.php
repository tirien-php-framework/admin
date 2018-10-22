<div class="admin-header">
	<h1><?php echo $this->view->post['title'] ? $this->view->post['title'] : "Create" ?></h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
    <?php Alert::show() ?>

	<form action="admin-blog/save/<?php echo !empty($this->view->post['id']) ? $this->view->post['id'] : 'new' ?>" method="post" enctype="multipart/form-data">

		<label>Title</label>
		<input type="text" name="title" value="<?php echo $this->view->post['title'] ?>">

		<label>Sub title</label>
		<input type="text" name="sub_title" value="<?php echo $this->view->post['sub_title'] ?>">

		<label>Source</label>
		<input type="text" name="autor" value="<?php echo $this->view->post['autor'] ?>">
		
		<label>Url</label>
		<input type="text" name="uri_id" value="<?php echo $this->view->post['uri_id'] ?>">

		<label>Excerpt</label>
		<textarea name="excerpt" rows="5"><?php echo $this->view->post['excerpt'] ?></textarea>

		<label>Content</label>
		<textarea name="content" class="htmlEditor" rows="15" data-page-name="blog" data-page-id="<?php echo !empty($this->view->post['id']) ? $this->view->post['id'] : 'new' ?>" id="editor-<?php echo  str_replace('.', '', !empty($this->view->post['id']) ? $this->view->post['id'] : 'new')  ?>"><?php echo $this->view->post['content'] ?></textarea>

		<div class="cf">
			<label>Blog Category</label>
			<div class="select-style">
				<select name="blog_category_id">
					<?php foreach ($this->view->categories as &$category): ?>
						<option value="<?php echo $category['id'] ?>" <?php if ($category['id']==$this->view->post['blog_category_id']): ?> selected <?php endif ?>><?php echo $category['title'] ?></option>
					<?php endforeach ?>
					<option value="0">Choose category</option>
				</select>				
			</div>
		</div>

		<div class="gallery-wrap">
			<ul class="image-list cf">
			<label>Thumbnail</label>
			<li class="items-order">
			<img src="<?php echo $this->view->post['thumb'] ?>"/>
			</li>
			<div class="fileUpload">
			    <span>Choose file</span>
			    <input type="file" class="upload"  name="elements[thumb]"/>
			</div>
			</ul>
		</div>

		<label>PDF</label>
		<div class="file-input-wrap cf">
			<?php if(!empty($this->view->post['pdf'])): ?>
				<a href="<?php echo $this->view->post['pdf'] ?>"><div class="small-image-preview" style="background-image: url('images/admin/pdf-icon.svg')"></div></a>
				<input type="checkbox" name="delete_pdf" value="1">Delete this file?
			<?php else: ?>
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="elements[pdf]"/>
				</div>
			<?php endif ?>
		</div>

		<label>SEO Title</label>
		<input type="text" name="meta_title" value="<?php echo $this->view->post['meta_title'] ?>">

		<label>SEO Description</label>
		<input type="text" name="meta_description" value="<?php echo $this->view->post['meta_description'] ?>">

		<label>SEO Keywords</label>
		<input type="text" name="meta_keyword" value="<?php echo $this->view->post['meta_keyword'] ?>">

		<label>Created time (Option)</label>
		<input type="text" name="created_at" id="datetimepicker1" value="<?php echo $this->view->post['created_at'] ?>">

		<label>Visible</label>
		<div class="select-style">
			<select name="visible">
				<option value="1" <?php if($this->view->post['visible']): ?> selected <?php endif ?>>Visible</option>
				<option value="0" <?php if(!$this->view->post['visible']): ?> selected <?php endif ?>>Not Visible</option>
			</select>				
		</div>

		<div class="cf"></div>

		<input type="submit" value="Save" class="save-item fixed-save-button">

		<?php if (!empty($this->view->post['id'])): ?>
			<a class="button remove-item" href="admin-blog/remove/<?php echo $this->view->post['id'] ?>">Delete</a>
		<?php endif ?>

	</form>
	
</div>
<script src="scripts/admin/timepicker.js"></script>
<link href="css/admin/timepicker.css" type="text/css" rel="stylesheet" />

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
        	dateFormat: 'yy-mm-dd', 
		    timeFormat: "HH:mm:ss"
        });
    });
</script>