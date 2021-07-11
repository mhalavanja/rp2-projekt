<?php
require_once __SITE_PATH . '/util/starHotelUtil.php';
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
        $price = $_POST["price"] ?? null;
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
}