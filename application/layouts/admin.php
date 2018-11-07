<!DOCTYPE html>

<html>

	<head>
		<base href="<?php echo Path::urlBase(); ?>/">
		<title>Admin</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<script>
			var _baseUrl = "<?php echo Path::urlBase(); ?>";
		</script>

		<link href="public/css/admin/fontello.css" type="text/css" rel="stylesheet" />
		<link href="public/css/admin/admin.min.css" type="text/css" rel="stylesheet" />
		<script src="public/scripts/admin/admin.js"></script>
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
	<body>

	<div class="loader"></div>

	<div class="top-header">
		<a href="admin" class="logo">
			<div class="header-top">
				<!-- <h1>ADMIN</h1> -->
				<img src="images/logo-black.svg">
			</div>
		</a>
	</div><!-- end top header -->

	<header class="cf">

		<div class="header-menu cf">

				<ul class="cf">
					<li <?php echo Router::$action == "page" ? "class='active'" : ""  ?> >
						<a href="admin/page"><i class="icon-newspaper"></i> Pages</a>
					</li>
					<li <?php echo Router::$action == "leads" ? "class='active'" : ""  ?> >
						<a href="admin/leads"><i class="icon-mail"></i> Leads</a>
					</li><!-- 
					<li <?php echo Router::$controller == "admingallery" ? "class='active'" : ""  ?> >
						<a href="admin-gallery"><i class="icon-picture"></i> Galleries</a>
					</li> 
					<li <?php echo Router::$controller == "adminmap" ? "class='active'" : ""  ?> >
						<a href="admin-map"><i class="icon-map-o"></i> Maps</a>
					</li> -->
					<!-- <li <?php echo Router::$controller == "adminlocation" ? "class='active'" : ""  ?> >
						<a href="admin-location"><i class="icon-location"></i> Locations</a>
					</li> 
					<li <?php echo Router::$controller == "imagewithmarkers" ? "class='active'" : ""  ?> >
						<a href="admin/imagewithmarkers"><i class="icon-file-image"></i> Image with Markers</a>
					</li> 
					<li <?php echo Router::$controller == "adminblog" ? "class='active'" : ""  ?> >
						<div class="icon-menu"><div class="center cf"></div></div>
						<a href="admin-blog">Blog & Press</a>
						<ul class="submenu">
							<li><a href="admin-blogcategory">Categories</a></li>
						</ul>
					</li> -->
					<li <?php echo Router::$controller == "admin-portfolio" ? "class='active'" : ""  ?> >
						<a href="admin-portfolio"><i class="icon-edit"></i> Portfolio</a>
					</li> 
					<li <?php echo Router::$controller == "team" ? "class='active'" : ""  ?> >
						<a href="admin-team"><i class="icon-edit"></i> Team</a>
					</li> 
					<li <?php echo Router::$controller == "seo" ? "class='active'" : ""  ?> >
						<a href="admin/seo"><i class="icon-chart-line"></i> SEO</a>
					</li> 
				</ul>

				<ul class="account cf">
					<li>
						<a href="admin/logout" class="logout"><i class="icon-logout"></i> Logout</a>
					</li>
				</ul>
			</div>
		</header>

		<div class="admin-content-wrap cf">
			<?php $this->viewContent() ?>

		</div>

	</body>

</html>



