<div class="login-form-wrap">
    <div class="login-form">
        <div class="logo-login">
            <img src="images/gosushi-logo.svg">
        </div>

    	<?php echo Alert::show() ?>

        <form class="form-horizontal" role="form" method="POST">

            <div class="form-group">

                <label>Username</label>
                <input type="text" name="username" id="username" placeholder="username" required>
            </div>

            <button class="button full-button">Send reset link</button>
        </form>
    </div>
</div>