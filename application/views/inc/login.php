<form class="form-signin" role="form" action="<?php echo site_url();?>" method="post">        
    <input type="text" name="uname" class="form-control" placeholder="Email address or Username" required autofocus>
    <input type="password" name="pass" class="form-control" placeholder="Password" required>
    <!--<label class="checkbox">
        <input type="checkbox" value="remember-me"> Biarkan saya tetap masuk
    </label>-->
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <button class="btn btn-lg btn-success btn-block" type="button">Sign Up</button>
</form>