<div class="admin-header">
	<h1>Locations</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin-location/create" class="button right">Add location</a>
	</div>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<ul class="border">
		<?php foreach ($this->view->locations as $location){ ?>

			<li>
				<a href="admin-location/edit/<?php echo $location['id'] ?>"><?php echo $location['title']; ?></a>
			</li>

		<?php } ?>
	</ul>
</div>