<?php
require_once __SITE_PATH . '/service/HotelService.php';

class SearchController extends BaseController
{
    function processSearch()
    {
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

    function hotels()
    {
        $hotels = $_SESSION["hotels"];
        $this->registry->template->hotels = $hotels;
        $this->registry->template->show("hotels");
    }

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

        usort($hotels, "cmp");

        $message = [$_GET["sortBy"], ];
        $this->sendJSONandExit($hotels);
    }

    function city()
    {
//        $this->sendJSONandExit(CityService::getAllCities());
        $this->sendJSONandExit("A");
    }

    private function sendJSONandExit($message)
    {
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($message);
        flush();
        exit(0);
    }
}