<?php

class LoginController extends BaseController
{
    function index()
    {
        if (!isset($_SESSION["user"])) {
            $this->registry->template->title = "Login";
            $this->registry->template->error = false;
            $this->registry->template->show("login");
        } else {
            header('Location: ' . __SITE_URL . '/search/index');
        }
    }

    function processLoginForm()
    {
        if (isset($_POST["register"])) $this->processRegister();
        if (isset($_POST["login"])) $this->processLogin();
    }

    function processLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user = User::where("username", $username);
        if (!$user || sizeof($user) > 1) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "Wrong username or password!";
            $this->registry->template->show("login");
            return;
        }
        $user = $user[0];
        if (!password_verify($password, $user->getPassword_hash())) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "Wrong username or password!";
            $this->registry->template->show("login");
        } elseif (!$user->getHas_registered()) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "You have to finish the registration first!";
            $this->registry->template->show("login");
        } else {
            $_SESSION["user"] = $user;
            header('Location: ' . __SITE_URL . '/hotels/index');
        }
    }

    function processLogout()
    {
        $_SESSION["user"] = null;
        header('Location: ' . __SITE_URL);
    }

    function processRegister()
    {
        $email = $_POST["email"] ?? null;
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $username = $_POST["username"] ?? null;
        $password = $_POST["password"] ?? null;
        if (!$email || !$username || !$password) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "Enter all the fields!";
            $this->registry->template->show("login");

        } elseif (User::where("username", $username)) {
            $this->registry->template->error = true;
            $this->registry->template->errorMessage = "Username already exists!";
            $this->registry->template->show("login");
        } else {
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword_hash(password_hash($password, PASSWORD_DEFAULT));
            $link = '<a href = "http://' . $_SERVER["HTTP_HOST"] . __SITE_URL . "/login/finishRegistration&sequence=";
            $sequence = "";

            for ($i = 0; $i < random_int(10, 20); $i++) $sequence .= chr(random_int(97, 122));
            $link .= $sequence . '">link</a>';
            $user->setRegistration_sequence($sequence);
            User::save($user);
            $subject = "Registration for hotelChain";
            $body = "Click on the followinng " . $link . " to finish your registration for hotelChain!";
            $headers = "Content-type: text/html\r\n";
            $headers .= "To: " . $email . "\r\n";
            $headers .= 'From: HotelChain <hotel@chain.com>' . "\r\n";
            if (mail($email, $subject, $body, $headers)) {
                echo "Check your mail to finish a registration :)";
                return;
            } else "Something's wrong: " . var_dump(error_get_last());
        }
    }

    function finishRegistration()
    {
        $sequence = $_GET["sequence"] ?? null;
        echo $sequence;
        $user = User::where("registration_sequence", $sequence);
        if ($user) $user = $user[0];
        $user->setHas_registered(true);
        User::save($user);
        $_SESSION["user"] = $user;
        header('Location: ' . __SITE_URL);
    }
}