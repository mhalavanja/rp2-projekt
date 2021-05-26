<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<p <?php if (!isset($loginError) ||  !$loginError) echo "hidden" ?>> Wrong username or password!</p>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/processLogin' ?>">
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
    <div>
        <input type="submit" name="Login" value="Login"/>
        <input type="submit" name="Register" value="Register"/>
    </div>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>