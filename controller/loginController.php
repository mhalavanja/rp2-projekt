<?php

//require_once(__SITE_PATH . "/model/User.php");

class loginController extends BaseController
{
    function index()
    {
        if (!isset($_SESSION["user"])) {
            $this->registry->template->title = "Login";
            $this->registry->template->loginError = false;
            $this->registry->template->show("login");
        } else {
            header('Location: ' . __SITE_URL . '/index.php?rt=products');
        }
    }

    function processLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user = null;
        try {
            $user = User::where("username", $username)[0];
        } catch (Exception $e) {
            $this->registry->template->loginError = true;
            $this->registry->template->show("login");
        }
        if (!password_verify($password, $user -> getPassword_hash())) {
            $this->registry->template->loginError = true;
            $this->registry->template->show("login");
        } else {
            $_SESSION["user"] = $user;
            header('Location: ' . __SITE_URL . '/index.php?rt=products');
        }
    }

    function processLogout()
    {
        $_SESSION["user"] = null;
        header('Location: ' . __SITE_URL . '/index.php?');
    }
}