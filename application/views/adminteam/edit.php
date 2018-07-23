<div class="admin-header">
	<h1>Edit member</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<form action="admin-team/update/<?php echo $this->view->team['id']; ?>" method="post" enctype="multipart/form-data">

		<label>Name:</label>
		<input type="text" name="title" placeholder="Name" value="<?php echo $this->view->team['title']; ?>">

		<label for="subtitle">Position:</label>
		<input type="text" name="subtitle" placeholder="Position"  value="<?php echo $this->view->team['subtitle']; ?>">

		<input type="submit" value="Update" class="save-item">

		<a href="admin-team/remove/<?php echo $this->view->team['id']; ?>" class="button remove-item">Delete member</a>
	</form>

	<div class="cf">
		<br><hr><br>
	</div>


	<script>
		$('.image-list').sortable();
	</script>	
</div>