<div class="admin-header">
	<h1>Add Member</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
	<?php Alert::show() ?>

	<form action="admin-team/save" method="post" enctype="multipart/form-data">

		<label>Name:</label>
		<input type="text" name="title" placeholder="Name">

		<label for="subtitle">Position:</label>
		<input type="text" name="subtitle" placeholder="Position">

		<input type="submit" value="Add" class="save-item">
	</form>
</div>
