<div class="admin-header">
	<h1>SEO</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin/seo/add" class="button right">Add Seo Page</a>
	</div>	
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<ul >
		<?php foreach( $this->view->seo as $seo ){ ?>

			<?php echo '<li><a href="admin/seo/edit/'.$seo['id'].'">'.$seo['title'].'</a></li>';?>

		<?php } ?>
	</ul>
</div>