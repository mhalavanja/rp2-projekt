<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <title><?php if (isset($title)) echo $title; else echo "ebuy"; ?></title>
    <link rel="stylesheet" href="<?php echo __SITE_URL; ?>/static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo __SITE_URL; ?>/static/header.css">
    <script type="text/javascript" src="<?php echo __SITE_URL; ?>/static/jquery-min.js"></script>    
    </head>
<body>
<br>
<h1>HOTEL BOOKING</h1>
<h2><?php if (isset($_SESSION["user"])) {
    echo "Pozdrav ". $_SESSION["user"] -> getUsername(); ?>
        <form action="<?php echo __SITE_URL; ?>/login/processLogout">
            <input type="submit" value="Logout" />
        </form>
    <?php
    }
    else{?>
        <button id="loginbtn">Log in</button>

            <div id="login" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <?php if (isset($error) && isset($errorMessage) && $error) echo '<p class="alert alert-danger">' . $errorMessage . "</p>"; ?>

                    <form method="post" action="<?php echo __SITE_URL . '/login/processLoginForm' ?>">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input class="form-control" id="username" name="username" type="text">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input class="form-control" id="password" name="password" type="password">
                        </div>
                        <br>
                        <div class="float-end">
                            <input class="btn btn-primary" type="submit" name="login" value="Login"/>
                        </div>
                        <br>
                    </form>
                </div>
            </div>

        <button id="joinbtn">Join us</button>

            <div id="join" class="modal">
                <div class= "modal-content">
                    <span class="close">&times</span>
                    <p>Join form</p>
                </div>
            </div>
</h2>
<?php } ?>

<script>

var loginModal = document.getElementById("login");

var loginBtn = document.getElementById("loginbtn");

var joinModal = document.getElementById("join");

var joinBtn = document.getElementById("joinbtn");

var loginSpan = document.getElementsByClassName("close")[0];
var joinSpan = document.getElementsByClassName("close")[1];


loginBtn.onclick = function() {
    loginModal.style.display = "block";
}

joinBtn.onclick = function() {
    joinModal.style.display = "block";
}

loginSpan.onclick = function() {
    loginModal.style.display = "none";
}

joinSpan.onclick = function() {
    joinModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == loginModal) {
        loginModal.style.display = "none";
    }
    if (event.target == joinModal) {
        joinModal.style.display = "none";
    }
}
</script>

<?php
if (isset($_SESSION["user"])) require "_navBar.php";
