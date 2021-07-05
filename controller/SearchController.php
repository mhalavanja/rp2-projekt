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
        //        $starHotels = getStarHotels($hotels);
//        $_SESSION["starHotels"] = $starHotels;
        $_SESSION["hotels"] = $hotels;
        header('Location: ' . __SITE_URL . '/search');
    }

    function searchDetails()
    {
        $hotel_id = $_POST['hotel_id'] ?? null;

        if (!$hotel_id || !preg_match('/^hotel_[0-9]+$/', $hotel_id)) {
            exit();
        }

        $hotelId = substr($hotel_id, 8);
        $hotel = Hotel::find($hotelId);
        $bookings = Booking::where("id_hotel", $hotelId);

        $this->registry->template->reviews = getReviewsForHotel($bookings);
        $this->registry->template->starHotel = getStarHotel($hotel);
        $this->registry->template->numOfSoldHotels = sizeof($bookings);
        $this->registry->template->show("hotel");
    }
}