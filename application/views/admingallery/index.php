<div class="admin-header">
	<h1>Galleries</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin-gallery/add" class="button right">Add Gallery</a>
	</div>
</div>

<div class="admin-content">

	<form method="post" action="admin-gallery-images/save_order">

		<ul <?php if($this->view->galleryManagement) echo 'class="sortable"' ?>>
			<?php foreach ($this->view->galleries as $gallery){ ?>

				<li data-gallery="<?php echo $gallery['id'] ?>">
					<a href="admin-gallery/edit/<?php echo $gallery['id'] ?>"><?php echo $gallery['title']; ?></a>

					<?php if($this->view->galleryManagement) { ?>
						<a class="remove-list-item" href="admin-gallery/remove/<?php echo $gallery['id'] ?>" >x</a>
					<?php } ?>

				</li>

			<?php } ?>
		</ul>

		<?php if($this->view->galleryManagement) { ?>
			<a class="button " style="margin:20px 0" href="admin-gallery/add">add new</a>
			<a class="button saveOrder" style="margin:20px 0" href="admin-gallery/saveorder">save order</a>		
		<?php } ?>

	</form>
</div>

<script>

	$(".saveOrder").click(function(e){
		e.preventDefault();
		order = array();
		$('li[data-gallery]').each(function(){
			order.push( $(this).data('gallery') );
		});
		$.post('admin-gallery/saveorder',{order:order}, function(data) {
  			if(data=='Success'){
  				alert("Order saved!");
  			}else{
  				alert("Saving error!");
  			}
  			
		});
	});
	
</script>