<?php
require_once __SITE_PATH . '/app/database/db.class.php';
require_once __SITE_PATH . '/util/propToModel.php';


class HotelService
{
    static function searchHotels($city, $fromDate, $toDate, $price, $rating)
    {
        $db = DB::getConnection();
        try {
//            $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $execArray = array(":city" => $city);
            $sql = "SELECT DISTINCT h1.* FROM projekt_hotels h1";
            if ($fromDate != null && $toDate != null) {
                $sql .= " LEFT OUTER JOIN projekt_rooms r ON h1.id = r.id_hotel ";
            }
            $sql .= " WHERE city = :city";
            if ($price !== null) {
                $sql .= " AND h1.price <= :price";
                $execArray[":price"] = $price;
            }
            if ($rating !== null) {
                $sql .= " AND (h1.rating IS NULL OR h1.rating >= :rating)";
                $execArray[":rating"] = $rating;
            }
            if ($fromDate != null && $toDate != null) {
                $sql .= " AND r.num_of_rooms - (
                            SELECT COUNT(b.id)
                            FROM projekt_bookings b
                            JOIN projekt_hotels h2 ON b.id_hotel = h2.id
                            WHERE h2.id = h1.id
                            AND (h2.rating IS NULL OR h2.rating >= '0')
                            AND (
                                :fromDate BETWEEN b.from_date
                                 AND b.to_date OR :toDate BETWEEN b.from_date
                                 AND b.to_date OR b.from_date BETWEEN :fromDate AND :toDate
                                )
                        ) > 0;";
                $execArray[":fromDate"] = $fromDate;
                $execArray[":toDate"] = $toDate;
            }
            $st = $db->prepare($sql);
            $st->execute($execArray);
            $ret = propToModel($st, "Hotel");
//            echo "<pre>";
//            print_r($st->debugDumpParams());
//            print_r($ret);
//            echo "<pre>";
//            exit();
            return $ret;
        } catch (PDOException $e) {
            exit("PDO error [select projekt_hotels]: " . $e->getMessage());
        }
    }
}

