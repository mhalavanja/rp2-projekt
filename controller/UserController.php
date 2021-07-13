<?php
// Includeamo usluge za usere.
require __SITE_PATH . "/service/UserService.php";
// Naslijeđujemo od baznog controllera.
class UserController extends BaseController
{
    // Defaultni index provjerava je li ulogiran postojeći korisnik
    // i ako jest, prikazuje njegov korisnički profil.
    function index()
    {
        $user = $_SESSION["user"];
        $this->registry->template->user = $user;
        $this->registry->template->show("profile");
    }
    // Korisniku dajemo mogućnost updateanja svojih korisničkih podataka te ovisno o tome što se mijenja
    // i jesu li izmjene u konfliktu s nekim od postojećih podataka, vraćamo odgovarajuće poruke.
    function processProfile()
    {
        $user = $_SESSION["user"];
        if($user->getUsername() === $_POST["username"] && $user->getName() === $_POST["name"] && $user->getLastname() === $_POST["lastname"] && $user->getEmail() === $_POST["email"]){
            $_SESSION["proccessInfoMessage"] = "Nothing to change!";
            header('Location: ' . __SITE_URL .'/user');
            return;
        }
        $newUsername = $_POST["username"];
        if ($newUsername !== $user->getUsername() && UserService::getUserByUsername($newUsername)) {
            $_SESSION["proccessErrorMessage"] = "Username already exists!";
            header('Location: ' . __SITE_URL .'/user');
            return;
        }
        $user->setName($_POST["name"]);
        $user->setLastname($_POST["lastname"]);
        $user->setUsername($newUsername);
        $user->setEmail($_POST["email"]);

        UserService::updateUser($user);
        $this->registry->template->proccessSuccess = true;
        $_SESSION["proccessSuccessMessage"] = "Profile updated successfully!";
        header('Location: ' . __SITE_URL .'/user');
        return;
    }
}