<!DOCTYPE html >
<html>
<head>
	<base href="<?php echo Path::urlBase(); ?>/">
	<link rel="stylesheet" href="css/admin/admin.css">

	<script src="public/js/admin/jquery-1.11.1.min.js"></script>
	<script>

		$(function(){
			<?php if(!empty($this->view->uploadedImage)) { ?>

				window.parent.tinyMCE.get("<?php echo $_GET['editor_id'] ?>").execCommand('mceInsertContent',false,'<img style="position: relative; float: left;" src="<?php echo $this->view->uploadedImage ?>">');

				$(window.parent.document).find(".tiny-upload-overlay").fadeOut(function() {
					$(this).remove();
				});

			<?php } ?>
			
			$(".close").click(function(event) {
				$(window.parent.document).find('.tiny-upload-overlay').remove();
			});
		
			$(".thumb img").click(function(event) {
				window.parent.tinyMCE.get("<?php echo $_GET['editor_id'] ?>").execCommand('mceInsertContent',false,'<img style="position: relative; float: left;" src="'+$(this).attr("src")+'">');
			});
		
			$(".delete-image").click(function(e) {
				e.preventDefault();
				$.post('admin/tiny-delete-image/', {path:$(this).data('path')});
				$(this).parent().remove();
			});

			$("[type='file']").change(function(event) {
				$(this).parents("form").submit();
			});
		
		})

	</script>

	<style>

		.close{
			display: block; 
			text-align: right; 
			position: absolute; 
			top: 5px; 
			right: 5px;
			font-size: 16px;
		}

		form {
			display: inline-block; 
			background: white; 
			padding: 30px; 
			position: relative;
		}

		.thumb {
			display:inline-block;
			position: relative;
			cursor: pointer;
		}

		.thumb img {
			height:80px;
		}

		.delete-image {
			display: block; 
			text-align: right; 
			position: absolute; 
			top:0;
			right:0;
			padding: 3px;
			background: white;
			font-size: 16px;
			line-height: 0.7em;
		}
		.delete-image:hover {
			background: red;
			color: white;
		}

		button{
			zoom: 0.3;
			position: absolute;
		}

		.fileUpload{
			margin-top: 20px;
		}

	</style>

</head>
<body style="background:none;">

	<div style="display:table; width: 100%; height: 100%; position: fixed;">
		<div style="display:table-cell; vertical-align:middle; text-align:center; height:100%;">
		
			<form action="" method="post" enctype="multipart/form-data">

				<a href="#" class="close">X</a>

				<div style="max-width: 500px;overflow-y:scroll;height:350px;">
					
					<?php 
						$images = glob("././public/uploads/tiny/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
					?>

					<?php foreach ($images as $image){ ?>
						<div href="" class="thumb">
							<div class="delete-image" data-path="<?php echo urlencode( str_replace("././public/uploads/tiny/", "", $image) ) ?>">x</div>
							<img src="<?php echo str_replace("././public/", "", $image) ?>">
						</div>
					<?php } ?>

				</div>
				
			    <div class="fileUpload" style="overflow:visible">
					<span>Add image</span>
					<input type="file" class="upload" name="file[]" multiple>
				</div>

			</form>
				
		</div>
	</div>

</body>
</html>