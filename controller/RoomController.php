<?php

require __SITE_PATH . "/service/RoomService.php";

class RoomController extends BaseController
{
    function save(){
        if( RoomService::getRoomByTypeFromHotel($_POST["type"], $_SESSION["hotelInfo"][0]->getId() ) ){
            $_SESSION["roomErrorMessage"] = "Room type already exist!";           
            header('Location: ' . __SITE_URL .'/hotels/info');
            return;
        }
        RoomService::saveRoom($_SESSION["hotelInfo"][0]->getId() ,$_POST["type"],$_POST["capacity"],$_POST["number_of_rooms"],$_POST["price"]);
        $_SESSION['hotelRooms'] = Room::where("id_hotel", $_SESSION["user"]->getisAdmin());
        $_SESSION["roomSuccessMessage"] = "Room created successfully!";
        header('Location: ' . __SITE_URL .'/hotels/info');
        return;
    }

    function changeInfo(){
        $room = null;
        foreach($_SESSION["hotelRooms"] as $rooms)
            if(isset($_POST[$rooms->getId()])) $room = $rooms;

        if($room->getCapacity() === $_POST["capacity"] && $room->getNum_of_rooms() === $_POST["number_of_rooms"] && $room->getPrice() === $_POST["price"] ){
            $_SESSION["roomInfoMessage"] = "No new information added!";        
            header('Location: ' . __SITE_URL .'/hotels/info');
            return;
        }
        $room->setCapacity($_POST["capacity"]);
        $room->setNum_of_rooms($_POST["number_of_rooms"]);
        $room->setPrice($_POST["price"]);

        RoomService::updateRoom($room);
        $_SESSION["roomSuccessMessage"] = "Room info updated successfully!";        
        header('Location: ' . __SITE_URL .'/hotels/info');
        return;
    }

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

    function deleteBooking()
    {
        $booking = null;
        foreach($_SESSION["hotelBookings"] as $bookings)
            if(isset($_POST[$bookings->getId()])) $booking = $bookings;
        RoomService::deleteReservation($booking);
        $_SESSION["bookingDeleteMessage"] = "Booking deleted successfully!";
        header('Location: ' . __SITE_URL .'/hotels/info');
        return;
    }
}