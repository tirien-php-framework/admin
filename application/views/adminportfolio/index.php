<div class="admin-header">
	<h1>Portfolios</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin-portfolio/create" class="button right">Add portfolio</a>
	</div>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<ul>
		<?php foreach ($this->view->portfolios as $portfolio){ ?>

			<li>
				<a href="admin-portfolio/edit/<?php echo $portfolio['id'] ?>"><?php echo $portfolio['title']; ?></a>
			</li>

		<?php } ?>
	</ul>
</div>