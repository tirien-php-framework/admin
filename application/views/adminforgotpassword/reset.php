<div class="login-form-wrap">
    <div class="login-form">
        <div class="logo-login">
            <img src="images/gosushi-logo.svg">
        </div>

    	<?php echo Alert::show() ?>

        <form class="form-horizontal" role="form" method="POST">

            <div class="form-group">

                <label>New password</label>
                <input type="text" name="password" id="password" placeholder="New password" required>

                <label>Repeat passwod</label>
                <input type="text" name="repeat_passwod" id="repeat_passwod" placeholder="Repeat passwod" required>
            </div>

            <button class="button full-button">Reset password</button>
        </form>
    </div>
</div>