<?php
// Includeamo usluge za usere.
require_once(__SITE_PATH . "/service/UserService.php");
// Naslijeđujemo od baznog controllera.
class loginController extends BaseController
{
    // Defaultni index provjerava je li ulogiran postojeći korisnik.
    function index()
    {
        if (!isset($_SESSION["user"])) {
            $this->registry->template->title = "Login";
            $this->registry->template->error = false;
            $this->registry->template->show("login");
        } else {
            header('Location: ' . __SITE_URL);
        }
    }
    // Granamo se ovisno želi li se neulogirani korisnik ulogirati ili tek registrirati.
    function processLoginForm()
    {
        if (isset($_POST["register"])) $this->processRegister();
        if (isset($_POST["login"])) $this->processLogin();
    }
    // Ako se korisnik želi ulogirati, provjeravamo odgovara li kriptirana zaporka i username
    // nečemu što imamo u bazi (također kriptirani pass),
    // a u suprotnom se ispisuje odgovarajuća poruka.
    function processLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user = User::where("username", $username);
        if (!$user || sizeof($user) > 1) {
            $_SESSION["loginErrorMessage"] = "Wrong username or password!";
            header('Location: ' . __SITE_URL .'/hotels');
            return;
        }
        $user = $user[0];
        if (!password_verify($password, $user->getPassword_hash())) {
            $_SESSION["loginErrorMessage"] = "Wrong username or password!";
            header('Location: ' . __SITE_URL .'/hotels');
        } elseif (!$user->getHas_registered()) {
            $_SESSION["loginErrorMessage"] = "You have to finish the registration first!";
            header('Location: ' . __SITE_URL .'/hotels');
        } else {
            $_SESSION["user"] = $user;
            header('Location: ' . __SITE_URL);
        }
    }
    // Ako je odabran logout, brišemo tekuće podatke o loginu u sessionu.
    function processLogout()
    {
        $_SESSION["user"] = null;
        header('Location: ' . __SITE_URL);
    }
    // Ako je odabrana registracija, korisnik na uneseni mail dobija
    // poveznicu za potvrdu računa i ako to provede uspješno i po uputama,
    // može se ulogirati.
    // Za svaku mogućnost neuspjeha ili nepravilnog unosa, korisnik dobija prikladnu poruku.
    function processRegister()
    {
        $email = $_POST["email"] ?? null;
        // Koristimo built-in funkcionalnosti da se riješimo eventualnog smeća u unosu.
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $username = $_POST["username"] ?? null;
        $password = $_POST["password"] ?? null;
        if (!$email || !$username || !$password) {
            $_SESSION["registerErrorMessage"] = "Enter all the fields!";
            header('Location: ' . __SITE_URL .'/hotels');
        } elseif (User::where("username", $username)) {
            $_SESSION["registerErrorMessage"] = "Username already exists!";
            header('Location: ' . __SITE_URL .'/hotels');
        } else {
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword_hash(password_hash($password, PASSWORD_DEFAULT));
            $link = '<a href = "http://' . $_SERVER["HTTP_HOST"] . __SITE_URL . "/login/finishRegistration&sequence=";
            $sequence = "";
            // U svrhu sigurnosti, niz za potvrdu registracije generira se nasumično.
            for ($i = 0; $i < random_int(10, 20); $i++) $sequence .= chr(random_int(97, 122));
            $link .= $sequence . '">link</a>';
            $user->setRegistration_sequence($sequence);
            User::save($user);
            $subject = "Registration for hotelChain";
            $body = "Click on the following " . $link . " to finish your registration for hotelChain!";
            $headers = "Content-type: text/html\r\n";
            $headers .= "To: " . $email . "\r\n";
            $headers .= 'From: HotelChain <hotel@chain.com>' . "\r\n";
            if (mail($email, $subject, $body, $headers)) {
                echo "Check your mail to finish a registration :)";
                return;
            } else "Something's wrong: " . var_dump(error_get_last());
        }
    }
    // Ako su koraci registracije prošli uspješno, dodajemo korisnika u bazu,
    // odnosno postaje registrirani korisnik naše službe.
    function finishRegistration()
    {
        $sequence = $_GET["sequence"] ?? null;
        $sequence = rtrim($sequence, "/");
        $user = User::where("registration_sequence", $sequence);
        if ($user) $user = $user[0];
        $user->setHas_registered(true);
        User::save($user);
        $_SESSION["user"] = $user;
        header('Location: ' . __SITE_URL . '/user');
    }
}