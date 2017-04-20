<div class="admin-header">
	<h1>Maps</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin-map/create" class="button right">Add map</a>
	</div>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<ul class="border">
		<?php foreach ($this->view->maps as $map){ ?>

			<li>
				<a href="admin-map/edit/<?php echo $map['id'] ?>"><?php echo $map['title']; ?></a>
			</li>

		<?php } ?>
	</ul>
</div>