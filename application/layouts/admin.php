<!DOCTYPE html>

<html>

	<head>
		<base href="<?php echo Path::urlBase(); ?>/">
		<title>Admin</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<link href="public/admin/css/admin.css" type="text/css" rel="stylesheet" />
		<script src="public/admin/js/admin.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	</head>
		<script>
		    $(function() {

		        tinymce.init({
		        	oninit : "setPlainText",
		        	selector:'.htmlEditor',
		        	plugins: ["link charmap code media table image paste"],
	                fontsize_formats: "8px 10px 12px 13px 14px 15px 16px 18px 24px 36px",
		        	toolbar1: "styleselect | fontsizeselect | bold italic alignleft aligncenter alignright alignjustify bullist numlist table charmap | link unlink media image uploadimage | code",
		        	menubar : false,
	                document_base_url : "<?php echo Path::urlBase()."/"?>",
		        	setup: function(editor) {
				        editor.addButton('uploadimage', {
				            title: 'Upload image',
				            text: '+',
				            icon: false,
				            onclick: function() {
				                tinyUploadImage(editor);
				            }
				        });
				    }
		        });

		        function tinyUploadImage(editor){
					
		        	// tinyMCE.get(editor.id).execCommand('mceInsertContent',false,'<img style="position: relative; float: left;" src="<?php echo Path::urlBase(); ?>/images/marker.png">');

		        	var overlay = $("<div>").addClass("tiny-upload-overlay").css({
		        		position: 'fixed',
		        		width: '100%',
		        		height: '100%',
		        		top: 0,
		        		left: 0,
		        		background: "rgba(0,0,0,0.4)",
		        		zIndex: 9999
		        	});

		        	overlay.append('<iframe src="admin/tiny-upload-image?editor_id='+editor.id+'" frameborder="0" style="width:100%;height:100%">');

		        	overlay.find("iframe").scroll(function(event) {
		        		event.stopPropagation();
		        	});

		        	$("body").append(overlay);

		        }

		    });
	    </script>
	    <style>
		    header .logo {
		    	margin:0;
		    	display: block;
		    }
		    .header-top{
			    padding: 47px 20px 60px;
			    box-sizing: border-box;
			    display: block;
			    text-align: center;
			}
			.header-top h1{
			    font-size: 2.7em;
			    color: #4a4a4a;
			    display: block;
			}

	    </style>
	<body>

	<div class="loader"></div>

	<header class="cf">
		<a href="admin" class="logo">
			<div class="header-top">
				<h1>ADMIN</h1>
			</div>
		</a>

		<div class="header-menu cf">

				<ul class="cf">
					<li <?php echo Router::$action == "events" ? "class='active'" : ""  ?> >
						<a href="admin/events">Event</a>
					</li>
					<li <?php echo Router::$action == "page" ? "class='active'" : ""  ?> >
						<a href="admin/page">Page</a>
					</li>
					<li <?php echo Router::$action == "lead" ? "class='active'" : ""  ?> >
						<a href="admin/leads">Lead</a>
					</li>
					<li <?php echo Router::$controller == "admingallery" ? "class='active'" : ""  ?> >
						<a href="admin-gallery">Galleries</a>
					</li>
				</ul>

				<ul class="account cf">
					<li>
						<a href="admin/logout" class="logout">Logout</a>
					</li>
				</ul>
			</div>
		</header>

		<div class="admin-content-wrap cf">
			<?php $this->viewContent() ?>

		</div>

	</body>

</html>



