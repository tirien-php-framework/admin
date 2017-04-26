<div class="admin-header">
	<h1>Edit Event</h1>
</div>

<div class="admin-content">
	
	<?php Alert::show() ?>

	<form action="admin/events/save" method="post">
		<label>Title</label>
		<input type="text" name="title" placeholder="Title">
        
        <label>Description</label>
        <textarea id="content" name="description" runat="server" class="htmlEditor" rows="10" placeholder="Description"></textarea>

		<label>Start date</label>
		<input id="timepicker" name="start_date" type="text" placeholder="Start date">
		
		<label>End date</label>
		<input id="timepicker2" type="text" name="end_date" placeholder="End date">

		<input type="hidden" name="status" value="1">
	
		<div class="action-wrap">
			<input type="submit" value="Create" class="save-item">
		</div>
	</form>


</div>

<script src="scripts/admin/timepicker.js"></script>
<link href="css/admin/timepicker.css" type="text/css" rel="stylesheet" />

<script>
	$('#timepicker').datetimepicker();
	$('#timepicker2').datetimepicker();
</script>