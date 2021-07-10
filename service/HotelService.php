<?php
require_once __SITE_PATH . '/app/database/db.class.php';


class HotelService
{
    static function searchHotels($city, $fromDate, $toDate, $price, $rating)
    {
        $db = DB::getConnection();
        try {
            $execArray = array(":city" => $city);
            $sql = "SELECT h.* FROM projekt_hotels h";
//            if ($fromDate != null && $toDate != null) {
//                $sql .= " JOIN projekt_bookings b ON h.id = b.id_hotel";
//            }
            $sql .= " WHERE city = :city";
            if ($price !== null) {
                $sql .= " AND price <= :price";
                $execArray[":price"] = $price;
            }
            if ($rating !== null) {
                $sql .= " AND (h.rating IS NULL OR h.rating >= :rating)";
                $execArray[":rating"] = $rating;
            }
//            if ($fromDate != null && $toDate != null) {
//                $sql .= " AND NOT (:fromDate < b.to_date OR :toDate > b.from_date)";
//                $execArray[":fromDate"] = $fromDate;
//                $execArray[":toDate"] = $toDate;
//            }
            $sql .= " GROUP BY h.id";
            $st = $db->prepare($sql);
            $st->execute($execArray);
            $st->execute();
            $ret = propToModel($st, "Hotel");
//            echo "<pre>";
//            print_r($st->debugDumpParams());
//            echo "<pre>";
            return $ret;
        } catch (PDOException $e) {
            exit("PDO error [select projekt_hotels]: " . $e->getMessage());
        }
    }
}

function propToModel($st, $class)
{
    $arr = [];
    foreach ($st->fetchAll() as $row) {
        $obj = new $class;
        foreach ($class::$columns as $key => $val) {
            $setProperty = "set" . ucfirst($key);
            $obj->$setProperty($row[$key]);
        }
        $arr[] = $obj;
    }
    return $arr;
}