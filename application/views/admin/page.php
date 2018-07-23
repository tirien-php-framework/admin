<div class="admin-header">
	<h1>Pages</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<ul >
		<?php foreach( $this->view->pages as $page ){ ?>

			<?php echo '<li><a href="admin/page/edit/'.$page['id'].'">'.$page['title'].'</a></li>';?>

		<?php } ?>
	</ul>

	<div class="cf" style="display: none;">
		<br><br><br><br>
		<form action="admin/page/add-page" method="post" accept-charset="utf-8">
			<h2>Add new page</h2>
		
			<label>Page name</label>
			<input type="text" name="title">

            <div class="cf"></div>
        	
        	<input type="submit" value="Add page" class="save-item ">
		</form>
	</div>
</div>