<?php
require_once __SITE_PATH . '/app/database/db.class.php';


class ReviewService
{
    static function addReview($bookingId, $hotelId, $rating, $comment)
    {
        $db = DB::getConnection();
        try {
            $st = $db->prepare('INSERT INTO projekt_reviews(id_booking, id_user, name_user, id_hotel, name_hotel, rating, comment) VALUES (:id_booking, :id_user, :name_user, :id_hotel, :name_hotel, :rating, :comment)');
            $st->execute(array('id_booking' => $bookingId, 'id_user' => $_SESSION['user']->getId(), 'name_user' => $_SESSION['user']->getName(), 'id_hotel' => $hotelId, 'name_hotel' => Hotel::find($hotelId)->getName(), 'rating' => $rating, 'comment' => $comment));
        } catch (PDOException $e) {
            exit("PDO error [insert projekt_users]: " . $e->getMessage());
        }
        try {
            echo $rating;
            $st = $db->prepare('UPDATE projekt_hotels SET rating = (rating * number_of_comments + :rating)/(number_of_comments + 1), number_of_comments = number_of_comments + 1 WHERE id = :id_hotel');
            $st->execute(array('id_hotel' => $hotelId, 'rating' => $rating));
        } catch (PDOException $e) {
            exit("PDO error [UPDATE projekt_hotels]: " . $e->getMessage());
        }
    }

    static function getReviewForHotelId($hotelId): array
    {
        $db = DB::getConnection();
        try {
            $st = $db->prepare('SELECT * FROM projekt_reviews WHERE id_hotel = :hotelId');
            $st->execute(array('hotelId' => $hotelId));
            $ret = [];
            foreach ($st->fetchAll() as $row) {
                $review = new Review();
                $review->setId($row["id"]);
                $review->setId_booking($row["id_booking"]);
                $review->setId_user($row["id_user"]);
                $review->setName_user($row["name_user"]);
                $review->setId_hotel($row["id_hotel"]);
                $review->setName_hotel($row["name_hotel"]);
                $review->setRating($row["rating"]);
                $review->setComment($row["comment"]);
                $ret[] = $review;
            }
            return $ret;
        } catch (PDOException $e) {
            exit("PDO error [SELECT projekt_reviews]: " . $e->getMessage());
        }
    }
}