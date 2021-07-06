<?php
require_once __SITE_PATH . '/util/starHotelUtil.php';
require_once __SITE_PATH . '/service/HotelService.php';

class SearchController extends BaseController
{
    function index()
    {
        $this->registry->template->starHotels = $_SESSION["starHotels"] ?? null;
        $_SESSION["starHotels"] = null;
        $this->registry->template->show("search");
    }

    function processSearch()
    {
        if(!isset($_POST["city"]) || $_POST["city"] === null || empty($_POST["city"])){
            echo "Grad je obavezno polje za pretragu hotela";
            $this->registry->template->show("landing");
        }
        $city = $_POST["city"];
        $fromDate = $_POST["fromDate"] ?? null;
        $toDate = $_POST["toDate"] ?? null;
        $price = $_POST["price"] ?? null;
        $rating = $_POST["rating"] ?? null;
        $hotels = HotelService::searchHotels($city, $fromDate, $toDate, $price, $rating);
        $_SESSION["hotels"] = $hotels;
        header('Location: ' . __SITE_URL . '/search/hotels');
    }

    function hotels()
    {
        $hotels = $_SESSION["hotels"];
        $this->registry->template->hotels = $hotels;
        $this->registry->template->show("hotels");
    }
}