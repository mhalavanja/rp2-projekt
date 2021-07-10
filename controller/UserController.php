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
        $oldUsername = $user->getUsername();
        $newUsername = $_POST["username"];
        if ($newUsername !== $oldUsername && UserService::getUserByProperty("username", $newUsername)) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "Username already exists!";
            $this->registry->template->show("profile");
            return;
        }
        $user->setName($_POST["name"]);
        $user->setLastname($_POST["lastname"]);
        $user->setUsername($newUsername);
        $user->setEmail($_POST["email"]);

        UserService::updateUser($user);
        header('Location: ' . __SITE_URL . '/index.php?rt=users/index');
    }
}