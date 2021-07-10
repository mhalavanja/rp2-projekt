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
        $userId = $_SESSION["user"]->getId();
        $hotel_id = null;
        if (isset($_POST['hotel_id'])) $hotel_id = $_POST['hotel_id'];
        elseif (isset($_SESSION['hotel_id'])) {
            $hotel_id = $_SESSION['hotel_id'];
            $_SESSION['hotel_id'] = null;
        }

        if (!$hotel_id || !preg_match('/^hotel_[0-9]+$/', $hotel_id)) {
            exit();
        }

        $hotelId = substr($hotel_id, 8);
        $hotel = Hotel::find($hotelId);
        $bookings = Booking::where("id_hotel", $hotelId);
        $bookingId = getSaleIdForUserIfTheyCanReview($userId, $bookings);

        $this->registry->template->canReview = (bool)$bookingId;
        $this->registry->template->reviews = getReviewsForHotel($bookings);
        $this->registry->template->bookingId = $bookingId;
        $this->registry->template->starHotel = getStarHotel($hotel);
        $this->registry->template->numOfSoldHotels = sizeof($bookings);
        $this->registry->template->show("hotel");
    }

    function newHotel()
    {
        $this->registry->template->show("new-hotel");
    }

    function processNewHotel()
    {
        if (!isset($_POST['name']) || !isset($_POST['description']) || !isset($_POST['price']) ||
            empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price'])) {
            $this->registry->template->error = true;
            $this->registry->template->show("new-hotel");
            return;
        }
        $hotel = new Hotel();
        $hotel->setName($_POST['name']);
        $hotel->setId_user($_SESSION["user"]->getId());
        Hotel::save($hotel);
        header('Location: ' . __SITE_URL . '/hotels');
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

    function processBuy()
    {
        $hotelId = $_POST["hotelId"] ?? null;
        $userId = $_SESSION["user"]->getId();
        if (!$userId) header('Location: ' . __SITE_URL);
        if (!$hotelId) exit();
        $booking = new Booking();
        $booking->setId_hotel($hotelId);
        $booking->setId_user($userId);
        Booking::save($booking);
        header('Location: ' . __SITE_URL . '/search');
    }
}