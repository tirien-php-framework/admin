<div class="admin-header">
	<h1>Edit <?php echo $this->view->pageTitle ?> Page</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">

	<?php Alert::show() ?>

	<form enctype="multipart/form-data" method="post" action="<?php echo ml::p() ?>admin/page/save/<?php echo $this->view->pageId ?>">

			<?php foreach( $this->view->elements as $element ){ 

				$p = ml::p();
				$lang_sufix = !empty($p) ? '_'.trim($p,'/') : '';

				switch($element['type_id']){
					case ELEMENT_TYPE_TEXTLINE:
					echo '<label title="'.$element['id'].'">'.$element['title'].'</label>';
					echo '<input type="text" name="elements['.$element['id'].']" value="'.htmlspecialchars( $element['content'.$lang_sufix] ).'">';
					break;

					case ELEMENT_TYPE_TEXTAREA:
					echo '<label title="'.$element['id'].'">'.$element['title'].'</label>';
					echo '<textarea name="elements['.$element['id'].']">'.$element['content'.$lang_sufix].'</textarea>';
					break;

					case ELEMENT_TYPE_IMAGE:

					echo '<div class="gallery-wrap">';
					echo '<ul class="image-list cf">';
					echo '<label title="'.$element['id'].'">'.$element['title'].'</label>';
					echo '<li class="items-order">';
					echo '<div class="buttons">';

					if( !empty($element['content'.$lang_sufix]) ){
						echo '<a style="padding: 0px;" href="admincrop/?image='.urlencode($element['content'.$lang_sufix]).'&width='.urlencode($element['width']).'&height='.urlencode($element['height']).'&redirect_uri='.urlencode('admin/page/edit/'.$this->view->pageId).'"><div class="button remove-image delete">Crop</div></a>';
					}

					echo '</div>';
					echo '<img title="'.$element['id'].'" src="'.$element['content'.$lang_sufix].'?v='.time().'"/>';
					echo '</li>';
					echo '<div class="fileUpload">
							    <span>Choose file</span>
							    <input type="file" class="upload" name="elements['.$element['id'].']" />
							</div>';
					echo "</ul>";
					echo "</div>";

					break;	

					case ELEMENT_TYPE_LINK:
					echo '<label title="'.$element['id'].'">'.$element['title'].'</label>';
					echo '<input type="text" disabled style="width: 300px;margin-right: 10px;" name="elements['.$element['id'].']" value="'.$element['content'.$lang_sufix].'">';

					echo '<div class="fileUpload" style="overflow:visible">
							    <span>Choose file</span>
							    <input type="file" class="upload" name="elements['.$element['id'].']" />
							</div>';
					break;	

					case ELEMENT_TYPE_HTML:
					echo '<label title="'.$element['id'].'">'.$element['title'].'</label>';
					echo '<textarea name="elements['.$element['id'].']" class="htmlEditor">'.$element['content'.$lang_sufix].'</textarea>';
					break;

					case ELEMENT_TYPE_SUBTITLE:
					echo '<h2>'.$element['title'].'</h2>';
					break;

				}

			} ?>

       <div class="action-wrap">
            <input type="submit" value="Save" class="save-item">
        </div>
	</form>

	<div class="cf" style="display: block;">
		<br><br><br><br>
		<form action="admin/page/add-element" method="post" accept-charset="utf-8">
			<h2>Add new element</h2>
		
			<label>Element name</label>
			<input type="text" name="title">

			<input type="hidden" name="page_id" value="<?php echo $this->view->pageId ?>">		
		
			<label>Element type</label>
			<div class="select-style">
				<select name="type_id">
					<option value="<?php echo ELEMENT_TYPE_TEXTLINE ?>">Textline</option>
					<option value="<?php echo ELEMENT_TYPE_TEXTAREA ?>">Textarea</option>
					<option value="<?php echo ELEMENT_TYPE_IMAGE ?>">Image</option>
					<option value="<?php echo ELEMENT_TYPE_LINK ?>">Link</option>
					<option value="<?php echo ELEMENT_TYPE_HTML ?>">Html</option>
					<option value="<?php echo ELEMENT_TYPE_SUBTITLE ?>">Subtitle</option>
				</select>
			</div>

            <div class="cf"></div>
        	
        	<input type="submit" value="Add element" class="save-item ">
		</form>
	</div>
</div>
