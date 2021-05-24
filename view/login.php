<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<p <?php if (!$loginError) echo "hidden" ?>> Wrong username or password!</p>
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
        <button type="submit" name="Login">Login</button>
        <button type="submit" name="Register">Register</button>
    </div>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>