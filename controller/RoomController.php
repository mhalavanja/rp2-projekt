<?php


class RoomController extends BaseController
{

    function processBookRoom()
    {
//        echo "<pre>";
//        print_r($_SESSION);
//        echo "<pre>";
        if(!isset($_SESSION["user"])){
            $this->registry->template->hotel = $_SESSION['hotel'];
            $this->registry->template->rooms = $_SESSION['rooms'];;
            $this->registry->template->error = "You have to login before booking a room!";
            $this->registry->template->show("hotel");
        }
        if(!isset($_SESSION["fromDate"]) || !isset($_SESSION["toDate"])){
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
        $booking->setId_hotel($toDate);
    }
}