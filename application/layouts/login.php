<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo Path::urlBase(); ?>/">
		<title>Admin Login</title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link href="public/css/admin/login.css" type="text/css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

	</head>
<body style="background: #FFF;">

    <div class="logo-login">
        <img src="images/admin/logo.png">
    </div>

    <div class="login-form">

    	<?php echo Alert::show() ?>

        <form class="form-horizontal" role="form" method="POST">

            <div class="form-group">

                <label>Username</label>
                <input type="text" name="username" id="username">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password">

            </div>


            <button class="button full-button">Log in</button>

        </form>
    </div>
</body>

</html>
