<div class="admin-header">
	<h1>Edit Event</h1>
</div>

<div class="admin-content">

	<?php Alert::show() ?>

	<form action="admin/events/update/<?php echo $this->view->event['id']; ?>" method="post">
		<label>Title</label>
		<input type="text" name="title" value="<?php echo $this->view->event['title'] ?>">
        
        <label>Description</label>
        <textarea id="content" name="description" runat="server" class="htmlEditor" rows="10"><?php echo $this->view->event['description'] ?></textarea>

		<label>Start date</label>
		<input id="timepicker" name="start_date" type="text" value="<?php echo $this->view->event['start_date'] ?>">
		
		<label>End date</label>
		<input id="timepicker2" type="text" name="end_date" value="<?php echo $this->view->event['end_date'] ?>">

		<label>Visibility</label>
		<select name="status" >
			<option value="0" <?php echo ($this->view->event['status'] == 0 ? "selected" : "") ?>>Non Visible</option>
			<option value="1" <?php echo ($this->view->event['status'] == 1 ? "selected" : "") ?>>Visible</option>
		</select>
	
		<div class="action-wrap">
			<input type="submit" value="Update" class="save-item">
			<a href="admin/events/delete/<?php echo $this->view->event['id']; ?>" class="confirm-action button remove-item">Delete</a>
		</div>
	</form>


</div>

<script src="scripts/timepicker.js"></script>
<link href="css/timepicker.css" type="text/css" rel="stylesheet" />

<script>
	$('#timepicker').datetimepicker();
	$('#timepicker2').datetimepicker();
</script>