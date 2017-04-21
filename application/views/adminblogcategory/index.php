<div class="admin-header">
	<h1>Categories</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin-blogcategory/create" class="button right">Add new</a>
	</div>
</div>

<div class="admin-content">
    <?php Alert::show() ?>

	<ul class="border">
	<?php foreach ($this->view->categories as &$category): ?>
		<li><a href="admin-blogcategory/edit/<?php echo $category['id'] ?>"><b><?php echo $category['title'] ?></a></li>
	<?php endforeach ?>
	</ul>
	
	
</div>