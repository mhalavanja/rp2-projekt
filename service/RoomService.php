<?php

require_once __SITE_PATH . '/app/database/db.class.php';

class RoomService
{
    static function getRoomByTypeFromHotel($type, $hotelId)
    {
        $db = DB::getConnection();
        try{
            $sql = "SELECT * FROM projekt_rooms";
            $sql .= " WHERE room_type = :type AND id_hotel = :hotelId;";
            $st = $db->prepare($sql);
            $st->execute(array("type" => $type, "hotelId" => $hotelId ));
            $st->execute();
            $result = $st->fetchAll();
            if (empty($result)) return 0;
            return 1;
        } catch (PDOException $e) {
            exit("PDO error [SELECT projekt_rooms]: " . $e->getMessage());
        }
    }

    static function saveRoom($hotelId, $type, $capacity, $number_of_rooms, $price)
    {
        $db = DB::getConnection();
        try{
            $st = $db->prepare('INSERT INTO projekt_rooms(id_hotel, num_of_rooms, capacity, room_type, price) VALUES (:id_hotel, :num_of_rooms, :capacity, :room_type, :price)');
            $st->execute(array('id_hotel' => $hotelId, 'num_of_rooms' => $number_of_rooms, 'capacity' => $capacity, 'room_type' => $type, 'price' =>$price));
        } catch (PDOException $e) {
            exit("PDO error [INSERT projekt_rooms]: " . $e->getMessage());
        }
    } 

    static function updateRoom($room)
    {
        $db = DB::getConnection();
        try{
            $sql = "UPDATE projekt_rooms";
            $sql .= " SET ";
            $sql .= " capacity = :capacity, ";
            $sql .= " num_of_rooms = :num_of_rooms, ";
            $sql .= " price = :price ";
            $sql .= " WHERE id = :id;";
            $st = $db->prepare($sql);
            $st->execute(array('capacity' => $room->getCapacity(),'num_of_rooms' => $room->getNum_of_rooms(),'price' => $room->getPrice(),'id' =>$room->getId() ));
            $st->execute();
        } catch (PDOException $e) {
            exit("PDO error [UPDATE projekt_rooms]: " . $e->getMessage());
        }
    }
}
