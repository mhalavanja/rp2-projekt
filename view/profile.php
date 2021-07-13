<?php
// Uključujemo header i navigacijsku traku.
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';
// Provjeravamo je li korisnik ulogiran.
if (!isset($_SESSION["user"])) return;
else $user = $_SESSION["user"];
?>
    <?php
    // Provjeravamo kako je prošlo procesiranje i ovisno o tome što je ono vratilo,
    // ispisujemo odgovarajuću poruku o (ne)uspjehu.
    if (isset($_SESSION["proccessErrorMessage"])) {
        echo '<div class="alert alert-danger" role="alert">
                ' . $_SESSION["proccessErrorMessage"] . '
            </div>';
        $_SESSION["proccessErrorMessage"] = null;
    }
    if (isset($_SESSION["proccessSuccessMessage"])) {
        echo '<div class="alert alert-success" role="alert">
                ' . $_SESSION["proccessSuccessMessage"] . '
            </div>';
        $_SESSION["proccessSuccessMessage"] = null;
    }
    if (isset($_SESSION["proccessInfoMessage"])) {
        echo '<div class="alert alert-info" role="alert">
                ' . $_SESSION["proccessInfoMessage"] . '
            </div>';
        $_SESSION["proccessInfoMessage"] = null;
    }
    ?>
    <div class="justify-content-center d-flex">
        <!-- Mogućnost promjene podataka za korisnika: ime, prezime, korisničko ime i e-pošta uz gumb za slanje tih promjena. -->
        <form method="post" class="w-25" action="<?php echo __SITE_URL . '/user/processProfile' ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input class="form-control" id="name" type="text" name="name"
                    value="<?php echo $user->getName() ?>">
            </div>
            <br>
            <div class="form-group">
                <label for="lastname">Lastname:</label>
                <input class="form-control" id="lastname" type="text"
                    name="lastname"
                    value="<?php echo $user->getLastname() ?>">
            </div>
            <br>
            <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control" id="username" type="text" required
                    name="username"
                    value="<?php echo $user->getUsername() ?>">
            </div>
            <br>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" id="email" type="email" name="email" required
                    value="<?php echo $user->getEmail() ?>">
            </div>
            <br>
            <div class="justify-content-end d-flex">
                <button class="btn btn-primary" type="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
<?php
// Uključujemo footer.
require_once __SITE_PATH . '/view/_footer.php'; ?>
