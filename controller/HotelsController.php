<?php
require __SITE_PATH . "/service/HotelService.php";
require __SITE_PATH . "/service/ReviewService.php";

class HotelsController extends BaseController
{
    function index()
    {
        $hotels = Hotel::all();
        $this->registry->template->hotels = $hotels;
        $this->registry->template->show("landing");
    }

    #Metoda za prikaz jednog hotela na kojeg se klikne nakon sto se obavi search sa početne stranice.
    #Dohvatimo reviewove i sobe za dani hotel, spremimo ih u session i proslijedimo u view
    function hotel()
    {
        if (isset($_GET['hotelId'])) {
            $hotelId = $_GET['hotelId'];
            $hotel = Hotel::find($hotelId);
            $rooms = Room::where("id_hotel", $hotelId);
            $reviews = ReviewService::getReviewForHotelId($hotelId);
        }
        else {
            echo "[ERROR] hotelId nije bio postavljen.";
            exit(1);
        }
        $_SESSION['hotel'] = $hotel;
        $_SESSION['rooms'] = $rooms;
        $_SESSION['reviews'] = $reviews;

        $this->registry->template->hotel = $hotel;
        $this->registry->template->rooms = $rooms;
        $this->registry->template->reviews = $reviews;
        $this->registry->template->show("hotel");
    }

    #Metoda koja za danog usera prosljeduje viewu njegove bookinge
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

    #Metoda koja dohvaca i prosljeduje potrebne informacije za admine hotela
    function info()
    {
        $_SESSION['hotelInfo'] = Hotel::where("id", $_SESSION["user"]->getisAdmin());
        $_SESSION['hotelRooms'] = Room::where("id_hotel", $_SESSION["user"]->getisAdmin());
        $_SESSION['hotelBookings'] = Booking::where("id_hotel", $_SESSION["user"]->getisAdmin());
        $this->registry->template->show("info");
    }

    #Metoda za dodavanje reviewa i updateanje ocjene hotela i broja komentara za dani hotel
    function addReview(){
        $rating = $_POST["rating"];
        $comment = $_POST["comment"] ?? "";
        ReviewService::addReview($_POST["bookingId"],$_POST["hotelId"],$rating,$comment);
        $_SESSION['commentMessage']="Review updated";
        header('Location: ' . __SITE_URL . '/hotels/userBookings');
    }
}