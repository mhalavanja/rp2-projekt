<?php
require_once __SITE_PATH . '/util/starHotelUtil.php';
require_once __SITE_PATH . '/util/reviewUtil.php';

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
        $hotel = null;
        $rooms = null;
        if (isset($_GET['hotelId'])) {
            $hotelId = $_GET['hotelId'];
            $hotel = Hotel::find($hotelId);
            $rooms = Room::where("id_hotel", $hotelId);
        }
        else {
            echo "AAAAAAAAAA";
            exit(1);
        }
//        else if (isset($_SESSION['hotel']) && isset($_SESSION['rooms'])) {
//            $hotel = $_SESSION['hotel'];
//            $rooms = $_SESSION['rooms'];
////            $_SESSION['hotel'] = null;
//        }
        $_SESSION['hotel'] = $hotel;
        $_SESSION['rooms'] = $rooms;
        $this->registry->template->hotel = $hotel;
        $this->registry->template->rooms = $rooms;
        $this->registry->template->show("hotel");
    }

    function visited()
    {
        $bookings = Booking::where("id_user", $_SESSION["user"]->getId());
        $hotels = [];
        foreach ($bookings as $booking) {
            $hotel = Hotel::find($booking->getId_hotel());
            $hotels[] = $hotel;
        }
        $this->registry->template->starHotels = getStarHotels($hotels);
        $this->registry->template->show("visited");
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
}