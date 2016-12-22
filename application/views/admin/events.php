<div class="admin-header">
	<h1>Events</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin/events/create" class="button right">Add Event</a>
	</div>	
</div>

<div class="admin-content">
	<ul >
		<?php foreach( $this->view->events as $event ){ ?>

			<?php echo '<li><a href="admin/events/edit/'.$event['id'].'">'.$event['title'].'</a></li>';?>

		<?php } ?>
	</ul>
</div>