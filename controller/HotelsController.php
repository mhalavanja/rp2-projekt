<?php
require_once __SITE_PATH . '/util/starHotelUtil.php';
require_once __SITE_PATH . '/util/reviewUtil.php';
require __SITE_PATH . "/service/HotelService.php";

//TODO: Ovaj i sve ostale controllere i viewove treba promijeniti
class HotelsController extends BaseController
{
    function index()
    {
//        if(!$_SESSION["user"]) header('Location: ' . __SITE_URL . 'login');
        $hotels = Hotel::all();
        $this->registry->template->hotels = $hotels;
//        $this->registry->template->starHotels = getStarHotels($hotels);
        $this->registry->template->show("landing");
    }

    function hotel()
    {
        if (isset($_GET['hotelId'])) {
            $hotelId = $_GET['hotelId'];
            $hotel = Hotel::find($hotelId);
            $rooms = Room::where("id_hotel", $hotelId);
            $reviews = Review::where("id_hotel", $hotelId);
        }
        else {
            echo "[ERROR] hotelId nije bio postavljen.";
            exit(1);
        }
//        else if (isset($_SESSION['hotel']) && isset($_SESSION['rooms'])) {
//            $hotel = $_SESSION['hotel'];
//            $rooms = $_SESSION['rooms'];
////            $_SESSION['hotel'] = null;
//        }
        $_SESSION['hotel'] = $hotel;
        $_SESSION['rooms'] = $rooms;
        $_SESSION['reviews'] = $reviews;
        $this->registry->template->hotel = $hotel;
        $this->registry->template->rooms = $rooms;
        $this->registry->template->reviews = $reviews;
        $this->registry->template->show("hotel");
    }

    function userBookings()
    {
        $_SESSION['bookings']= Booking::where("id_user", $_SESSION["user"]->getId());
        $_SESSION['hotels'] = [];
        foreach ($_SESSION['bookings'] as $booking) {
            $hotel = Hotel::find($booking->getId_hotel());
            $_SESSION['hotels'][]= $hotel;
        }
        $this->registry->template->show("userBookings");
    }

    function info()
    {
        $_SESSION['hotelInfo'] = Hotel::where("id", $_SESSION["user"]->getisAdmin());
        $_SESSION['hotelRooms'] = Room::where("id_hotel", $_SESSION["user"]->getisAdmin());
        $_SESSION['hotelBookings'] = Booking::where("id_hotel", $_SESSION["user"]->getisAdmin());
        //$hotelComments = Cooments::where("id_hotel",$_SESSION["user"]->getisAdmin());
        $this->registry->template->show("info");
    }

    function processReview()
    {
        $rating = $_POST["rating"] ?? null;
        $comment = $_POST["comment"] ?? null;
        $booking = new Booking();
        $booking->setId_user($_SESSION["user"]->getId());
        $booking->setId($_POST["bookingId"]);
        $booking->setId_hotel($_POST["hotel_id"]);
        $booking->setRating($rating);
        $booking->setComment($comment);
        $_SESSION["hotel_id"] = "hotel_" . $_POST["hotel_id"];
        Booking::save($booking);
        header('Location: ' . __SITE_URL . '/hotels/hotel');
    }

    function addReview(){
        $rating = $_POST["rating"];
        $comment = $_POST["comment"] ?? "";
        HotelService::updateReview($_POST["bookingId"],$_POST["hotelId"],$rating,$comment);
        $_SESSION['commentMessage']="Review updated";
        header('Location: ' . __SITE_URL . '/hotels/userBookings');
    }
}