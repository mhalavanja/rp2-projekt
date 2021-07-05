<?php
require_once __SITE_PATH . '/app/database/db.class.php';


class HotelService
{
    static function searchHotels($city, $fromDate, $toDate, $price, $rating)
    {
        $db = DB::getConnection();
        try {
            $sql = "SELECT h.* FROM projekt_hotels h";
            if ($fromDate !== null || $toDate !== null) {
                $sql .= " JOIN projekt_bookings b ON h.id = b.id_hotel";
            }
            $sql .= " WHERE city = :city";
            if ($price !== null) {
                $sql .= " AND price <= :price";
            }
            if ($rating !== null) {
                $sql .= " AND (h.rating IS NULL OR h.rating >= :rating)";
            }
            $st = $db->prepare($sql);
            $st->execute(array(":city" => $city, ":price" => $price, ":rating" => $rating));
        } catch (PDOException $e) {
            exit("PDO error [select projekt_hotels]: " . $e->getMessage());
        }
    }
}