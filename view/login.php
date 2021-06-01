<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<p <?php if (!isset($loginError) ||  !$loginError) echo "hidden" ?>> Wrong username or password!</p>
<p <?php if (!isset($registrationError) ||  !$registrationError) echo "hidden" ?>> Enter all the fields!</p>
<p <?php if (!isset($hasRegistered) ||  $hasRegistered) echo "hidden" ?>> You have to finish the registration first!</p>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/processLoginForm' ?>">
    <div>
        <label for="username">Username:</label>
        <input id="username" name="username" type="text">
    </div>
    <br>
    <div>
        <label for="password">Password:</label>
        <input id="password" name="password" type="password">
    </div>
    <br>
    <br>
    <div>
        First time using ebuy? <br>
        <label for="email">Email adress:</label>
        <input id="email" name="email" type="email">
    </div>
    <br>
    <div>
        <input type="submit" name="login" value="Login"/>
        <input type="submit" name="register" value="Register"/>
    </div>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>