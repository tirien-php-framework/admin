<div class="admin-header">
	<h1>Leads setting</h1>
</div>

<div class="admin-content">
	
	<?php Alert::show() ?>

	<form action="admin/leads-setting" method="post">
		<label>Email</label>
		<input type="text" name="email" placeholder="Email" value="<?php echo $this->view->leadsSetting['email'] ?>">
        
		<label>Subject</label>
		<input id="timepicker" name="subject" type="text" placeholder="Subject" value="<?php echo $this->view->leadsSetting['subject'] ?>">

        <label>Body</label>
        <textarea name="body" rows="4" placeholder="Body"><?php echo $this->view->leadsSetting['body'] ?></textarea>

		<div class="action-wrap">
			<input type="submit" value="Update" class="save-item">
		</div>
	</form>


</div>
