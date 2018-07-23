<div class="admin-header">
	<h1>Team</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin-team/create" class="button right">Add member</a>
	</div>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<ul class="sortable" data-link="admin-team/saveorder">
		<?php foreach ($this->view->team as $team){ ?>

			<li data-id="<?php echo $team['id'] ?>" class="items-order no-transition">
				<a href="admin-team/edit/<?php echo $team['id'] ?>"><?php echo $team['title']; ?></a>
			</li>

		<?php } ?>
	</ul>
</div>