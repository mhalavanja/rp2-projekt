<?php

require __SITE_PATH . "/service/UserService.php";

class UserController extends BaseController
{

    function index()
    {
        $user = $_SESSION["user"];
        $this->registry->template->user = $user;
        $this->registry->template->show("profile");
    }

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
        //header('Location: ' . __SITE_URL . '/user');
    }
}