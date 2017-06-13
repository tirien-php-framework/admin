<div class="admin-header">
	<h1>Lead</h1>
	<span class="last-update"></span>
</div>

<div class="admin-content">
	
		<?php
			echo '<label>Date</label><input disabled type="text" value="'.$this->view->lead['dti'].'">';
			foreach ($this->view->lead['data'] as $label=>$data) {
				echo '<label>'.ucwords( str_replace("_", " ", $label) ).'</label><input disabled type="text" value="'.$data.'">';
			}
		?>

		<div class="action-wrap">
			<a class="button remove-item" href="admin/lead-delete/<?php echo $this->view->lead['id'] ;?>">Delete</a>
		</div>
	
</div>