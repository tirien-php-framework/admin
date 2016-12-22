<div class="admin-header">
	<h1>Pages</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
	<ul >
		<?php foreach( $this->view->pages as $page ){ ?>

			<?php echo '<li><a href="admin/page/edit/'.$page['id'].'">'.$page['title'].'</a></li>';?>

		<?php } ?>
	</ul>
</div>