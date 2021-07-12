<?php


class RoomController extends BaseController
{

    function processBookRoom()
    {
        $hotelId = $_GET['hotelId'];
        $hotel = $_SESSION['hotel'] ?? Hotel::find($hotelId);
        $rooms = $_SESSION['rooms'];

        if (!isset($_SESSION["user"])) {
            $this->registry->template->hotel = $hotel;
            $this->registry->template->rooms = $rooms ?? Room::where("id_hotel", $_GET['roomId']);
            $this->registry->template->error = "You have to login before booking a room!";
            $this->registry->template->show("hotel");
        }
        if (!isset($_SESSION["fromDate"]) || !isset($_SESSION["toDate"])) {
            echo "To and from dates have to be in a session";
            exit(1);
        }

        $user = $_SESSION["user"];
        $fromDate = $_SESSION["fromDate"];
        $toDate = $_SESSION["toDate"];
        $booking = new Booking();
        $booking->setId_user($user->getId());
        $booking->setFrom_date($fromDate);
        $booking->setTo_date($toDate);
        $booking->setId_hotel($hotelId);
        $booking->setRoom_id($_GET["roomId"]);
        Booking::save($booking);

        $_SESSION["booked"] = "You have succesfully booked a " . $_GET["roomType"] . " at " . $hotel->getName();
        header('Location: ' . __SITE_URL);
    }
}