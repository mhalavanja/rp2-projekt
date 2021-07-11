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
            $this->registry->template->proccessInfo = true;
            $this->registry->template->proccessInfoMessage = "Nothing to change!";
            $this->registry->template->show("profile");
            return;
        }
        $newUsername = $_POST["username"];
        if ($newUsername !== $user->getUsername() && UserService::getUserByUsername($newUsername)) {
            $this->registry->template->proccessError = true;
            $this->registry->template->proccessErrorMessage = "Username already exists!";
            $this->registry->template->show("profile");
            return;
        }
        $user->setName($_POST["name"]);
        $user->setLastname($_POST["lastname"]);
        $user->setUsername($newUsername);
        $user->setEmail($_POST["email"]);

        UserService::updateUser($user);
        $this->registry->template->proccessSuccess = true;
        $this->registry->template->proccessSuccessMessage = "Profile updated successfully!";
        $this->registry->template->show("profile");
        return;
        //header('Location: ' . __SITE_URL . '/user');
    }
}