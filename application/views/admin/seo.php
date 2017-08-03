<div class="admin-header">
	<h1>Seo</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin/seo/add" class="button right">Add Seo Page</a>
	</div>	
</div>

<div class="admin-content seo-admin-content">
	<?php Alert::show() ?>

	<ul >
		<?php foreach( $this->view->seo as $seo ){ ?>
			<li>
				<small>/<?php echo $seo['uri'] ?></small>
				<a href="admin/seo/edit/<?php echo $seo['id'] ?>"><?php echo $seo['title'] ?></a>
			</li>
		<?php } ?>
	</ul>
</div>