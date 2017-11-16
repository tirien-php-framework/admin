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

    <div class="login-wrap">
        <?php if ( !empty($this->view->resetPassword) ): ?>
            <?php $this->viewContent() ?>
        <?php endif ?>
            
        <?php if (empty($this->view->resetPassword)): ?>
            <div class="login-form-wrap">
                <div class="login-form">
                    <div class="logo-login">
                        <img src="images/logo.png">
                    </div>

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

                        <?php if (isset($_SESSION['login']['forgot_password']) && $_SESSION['login']['forgot_password'] >= 3): ?>
                            <a href="admin-forgot-password" class="button full-button reset-link">Forgot password</a>
                        <?php endif ?>


                        <button class="button full-button">Log in</button>

                    </form>
                </div>

            </div>
        <?php endif ?>

        <div class="login-background" style="background-image: url('images/image.jpg');"></div>
    </div>


</body>

</html>
