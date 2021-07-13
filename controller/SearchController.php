<?php
// Includeamo usluge za hotele.
require_once __SITE_PATH . '/service/HotelService.php';
// Naslijeđujemo od baznog controllera.
class SearchController extends BaseController
{
    // Obrađujemo search.
    function processSearch()
    {
        // Prvo provjeravamo jesu li svi relevantni podaci za pretragu uneseni,
        // a u suprotnom prikazujemo prikladnu poruku.
        if(!isset($_POST["city"]) || $_POST["city"] === null || empty($_POST["city"])){
            $this->registry->template->error = "You have to select a city!";
            $this->registry->template->show("landing");
            return;
        }
        $city = $_POST["city"];
        $fromDate = $_POST["fromDate"] ?? null;
        $toDate = $_POST["toDate"] ?? null;
        $price = isset($_POST["price"]) && !empty($_POST["price"]) ? $_POST["price"] : null;
        $rating = $_POST["rating"] ?? null;
        // Iz baze podataka dohvaćamo hotele koji imaju karakteristike unesene u pretragu
        // i ako ih nema ispisujemo prikladnu poruku, a u suprotnom prikazujemo listu hotela i njihova obilježja.
        $hotels = HotelService::searchHotels($city, $fromDate, $toDate, $price, $rating);
        if (empty($hotels)){
            $this->registry->template->error = "There is no such hotel!";
            $this->registry->template->show("landing");
            return;
        }
        $_SESSION["hotels"] = $hotels;
        $_SESSION["fromDate"] = $fromDate;
        $_SESSION["toDate"] = $toDate;
        header('Location: ' . __SITE_URL . '/search/hotels');
    }
    // Funkcionalnost za prikaz hotela koji su u sessionu.
    function hotels()
    {
        $hotels = $_SESSION["hotels"];
        $this->registry->template->hotels = $hotels;
        $this->registry->template->show("hotels");
    }
    // Funckionalnost za sortiranje hotela na popisu koji se prikazuje i to po jednom od četiri kriterija:
    // grada, cijene, udaljenosti od centra i dobivenih ocjena (sort po gradu je defaultni i ne koristi se jer pretraga zahtijeva grad).
    public function sort()
    {
        $hotels = $_SESSION["hotels"];
        if ($_GET["sortBy"] === 'distance') {
            function cmp($hotel1, $hotel2) {
                return strcmp($hotel1->getDistance_from_city_centre(), $hotel2->getDistance_from_city_centre());
            }
        }
        else if ($_GET["sortBy"] === 'price') {
            function cmp($hotel1, $hotel2) {
                return strcmp($hotel1->getPrice(), $hotel2->getPrice());
            }
        }
        else if ($_GET["sortBy"] === 'rating') {
            function cmp($hotel1, $hotel2) {
                return strcmp($hotel1->getRating(), $hotel2->getRating());
            }
        }
        else {
            function cmp($hotel1, $hotel2) {
                return strcmp($hotel1->getCity(), $hotel2->getCity());
            }
        }
        // Koristimo built-in funkcionalnost za sortiranje.
        usort($hotels, "cmp");

        $message = [$_GET["sortBy"]];
        $this->sendJSONandExit($hotels);
    }
    // Standardna funkcija za slanje JSON-a preuzeta s materijala dostupnih na kolegiju.
    private function sendJSONandExit($message)
    {
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($message);
        flush();
        exit(0);
    }
}