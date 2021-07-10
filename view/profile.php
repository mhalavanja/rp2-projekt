<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';
if (!isset($_SESSION["user"])) return;
else $user = $_SESSION["user"];
?>
    <?php if (isset($error) && isset($errorMessage) && $error) echo '<p class="alert alert-danger">' . $errorMessage . "</p>"; ?>
    <div class="justify-content-center d-flex">
        <form method="post" class="w-25" action="<?php echo __SITE_URL . '/index.php?rt=users/processProfile' ?>">
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
                <input class="form-control" id="username" type="text"
                    name="username"
                    value="<?php echo $user->getUsername() ?>">
            </div>
            <br>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" id="email" type="email" name="email"
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
require_once __SITE_PATH . '/view/_footer.php'; ?>
