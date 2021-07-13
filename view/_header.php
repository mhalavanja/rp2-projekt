<!-- Početak stranice. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <title>Hotel Booking</title>
    <!-- Koristimo bootstrap za dizajn i cijeli je dostupan u mapi static/bootstrap, -->
    <!-- a pojedine elemente dizajna pozivamo tijekom cijelog koda, i ovog i ostalih. -->
    <link rel="stylesheet" href="<?php echo __SITE_URL; ?>/static/bootstrap/bootstrap.css">
    <script rel="stylesheet" src="<?php echo __SITE_URL; ?>/static/bootstrap/bootstrap.bundle.js"></script>
    <!-- jQuery je također lokalni dokument i dostupan u mapi static. -->
    <script type="text/javascript" src="<?php echo __SITE_URL; ?>/static/jquery.js"></script>
</head>
<body>
<nav class="navbar navbar-light" style="background-color: SkyBlue;">
    <div class="container-fluid">
        <h1 class="nav-item"><a class="nav-link link-dark" href="<?php echo __SITE_URL; ?>/hotels">HOTEL BOOKING</a></h1>
        <div class="navbar">
            <?php
            // Ako su podaci o useru postavljeni u sessionu, prikazujemo pripadno korisničko ime uz gumb za logout,
            if (isset($_SESSION["user"])) {
                echo '<div class="d-flex">';
                echo '<span class="me-3 h3" href=" ">' . $_SESSION["user"]->getUsername() . '</span>'; ?>
                <form action="<?php echo __SITE_URL; ?>/login/processLogout">
                    <input class="btn btn-outline-danger" type="submit" value="Logout"/>
                </form>
                <?php
                echo '</div>';
            } else {
            // a ako nisu, prikazujemo gumbove za login i registraciju.
                ?>
                <button class="btn btn-outline-primary me-1" id="loginbtn">Log in</button>
                <!-- U slučaju da se korisnik odluči ulogirati, prikazuje se prozor za unos podataka logina -->
                <!-- i ovisno o podacima koje unese se ili ulogira ili se prikazuje odgovarajuća poruka o grešci. -->
                <div id="login" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Login</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php if (isset($_SESSION['loginErrorMessage'])) {
                                    echo '<p class="alert alert-danger">' . $_SESSION['loginErrorMessage'] . "</p>";
                                    $_SESSION['loginErrorMessage'] = null;
                                ?>
                                <script>document.getElementById("login").style.display = "block";</script><?php } ?>
                                <form method="post" action="<?php echo __SITE_URL . '/login/processLogin' ?>">
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
                <!-- U slučaju da se korisnik odluči registrirati, prikazuje se prozor za unos podataka za registriranje -->
                <!-- i ide se na obradu registracije na način opisan u controlleru. -->
                <div id="join" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Register</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php if (isset($_SESSION['registerErrorMessage'])) {
                                    echo '<p class="alert alert-danger">' . $_SESSION['registerErrorMessage'] . "</p>";
                                    $_SESSION['registerErrorMessage'] = null;
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
    // Frontend dio rada ovisno o tome što korisnik odabere kliknuti na stranici.
    var loginModal = document.getElementById("login");

    var loginBtn = document.getElementById("loginbtn");

    var joinModal = document.getElementById("join");

    var joinBtn = document.getElementById("joinbtn");

    var loginSpan = document.getElementsByClassName("btn-close")[0];
    var joinSpan = document.getElementsByClassName("btn-close")[1]
    // Prikaz prozora za unos podataka za login.
    if(loginBtn !== null && loginBtn !== undefined){
        loginBtn.onclick = function () {
            loginModal.style.display = "block";
        }
    }
    // Prikaz prozora za unos podataka za registraciju.
    if(joinBtn !== null && joinBtn !== undefined){
        joinBtn.onclick = function () {
            joinModal.style.display = "block";
        }
    }
    // Micanje prozora za login.
    if(loginSpan !== null && loginSpan !== undefined){
        loginSpan.onclick = function () {
            loginModal.style.display = "none";
            <?php unset($loginError); ?>
        }
    }
    // Micanje prozora za registraciju.
    if(joinSpan !== null && joinSpan !== undefined){
        joinSpan.onclick = function () {
            joinModal.style.display = "none";
            <?php unset($registerError); ?>
        }
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
