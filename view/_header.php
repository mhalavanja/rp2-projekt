<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <title><?php if (isset($title)) echo $title; else echo "Hotel booking"; ?></title>
    <link rel="stylesheet" href="<?php echo __SITE_URL; ?>/static/bootstrap/bootstrap.min.css">
    <script rel="stylesheet" src="<?php echo __SITE_URL; ?>/static/bootstrap/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo __SITE_URL; ?>/static/jquery-min.js"></script>
</head>
<body>
<nav class="navbar navbar-light" style="background-color: SkyBlue;">
    <div class="container-fluid">
        <h1 class="nav-item"><a class="nav-link link-dark" href="<?php echo __SITE_URL; ?>/hotels">HOTEL BOOKING</a></h1>
        <div class="navbar">
            <?php
            if (isset($_SESSION["user"])) {
                echo '<div class="d-flex">';
                echo '<span class="me-3 h3" href=" ">' . $_SESSION["user"]->getUsername() . '</span>'; ?>
                <form action="<?php echo __SITE_URL; ?>/login/processLogout">
                    <input class="btn btn-outline-danger" type="submit" value="Logout"/>
                </form>
                <?php
                echo '</div>';
            } else {
                ?>
                <button class="btn btn-outline-primary me-1" id="loginbtn">Log in</button>

                <div id="login" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Login</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php if (isset($loginError) && isset($loginErrorMessage) && $loginError) {
                                    echo '<p class="alert alert-danger">' . $loginErrorMessage . "</p>";
                                ?>
                                <script>document.getElementById("login").style.display = "block";</script><?php } ?>
                                <form method="post" action="<?php echo __SITE_URL . '/login/processLoginForm' ?>">
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input class="form-control" id="username" name="username" type="text"
                                            required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input class="form-control" id="password" name="password" type="password"
                                            required="required">
                                    </div>
                                    <br>
                                    <div class="float-end">
                                        <input class="btn btn-primary" type="submit" name="login" value="Login"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="float-end btn btn-outline-primary" id="joinbtn">Join us</button>

                <div id="join" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Register</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php if (isset($registerError) && isset($registerErrorMessage) && $registerError) {
                                    echo '<p class="alert alert-danger">' . $registerErrorMessage . "</p>";
                                ?>
                                <script>document.getElementById("join").style.display = "block";</script><?php } ?>
                                <form method="post" action="<?php echo __SITE_URL . '/login/processRegister' ?>">
                                    <div class="form-group">
                                        <label for="email">Email adress:</label>
                                        <input class="form-control" id="email" name="email" type="email" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input class="form-control" id="username" name="username" type="text"
                                            required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input class="form-control" id="password" name="password" type="password"
                                            required="required">
                                    </div>
                                    <br>
                                    <div class="float-end">
                                        <input class="btn btn-primary" type="submit" name="register" value="Register"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>

<script>

    var loginModal = document.getElementById("login");

    var loginBtn = document.getElementById("loginbtn");

    var joinModal = document.getElementById("join");

    var joinBtn = document.getElementById("joinbtn");

    var loginSpan = document.getElementsByClassName("btn-close")[0];
    var joinSpan = document.getElementsByClassName("btn-close")[1];


    loginBtn.onclick = function () {
        loginModal.style.display = "block";
    }

    joinBtn.onclick = function () {
        joinModal.style.display = "block";
    }

    loginSpan.onclick = function () {
        loginModal.style.display = "none";
        <?php unset($loginError); ?>
    }

    joinSpan.onclick = function () {
        joinModal.style.display = "none";
        <?php unset($registerError); ?>
    }

    window.onclick = function (event) {
        if (event.target == loginModal) {
            loginModal.style.display = "none";
            <?php unset($loginError); ?>
        }
        if (event.target == joinModal) {
            joinModal.style.display = "none";
            <?php unset($registerError); ?>
        }
    }
</script>
