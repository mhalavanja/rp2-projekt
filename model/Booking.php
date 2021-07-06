<?php


class Booking extends Model
{
    private $id;
    private $id_user;
    private $id_hotel;
    private $room_number;
    private $from_date;
    private $to_date;
    private $rating;
    private $comment;
    protected static $table = "projekt_bookings";
    public static $columns = [];

    public function __construct(){}

    public static function staticInit()
    {
        Booking::setColumns();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId_user()
    {
        return $this->id_user;
    }

    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getId_hotel()
    {
        return $this->id_hotel;
    }

    public function setId_hotel($id_hotel): void
    {
        $this->id_hotel = $id_hotel;
    }

    public function getRoom_number()
    {
        return $this->room_number;
    }

    public function setRoom_number($room_number): void
    {
        $this->room_number = $room_number;
    }

    public function getFrom_date()
    {
        return $this->from_date;
    }

    public function setFrom_date($from_date): void
    {
        $this->from_date = $from_date;
    }

    public function getTo_date()
    {
        return $this->to_date;
    }

    public function setTo_date($to_date): void
    {
        $this->to_date = $to_date;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}

Booking::staticInit();