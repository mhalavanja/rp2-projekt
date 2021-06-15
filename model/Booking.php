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
    protected static $columns = [];

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

    public function getIdHotel()
    {
        return $this->id_hotel;
    }

    public function setIdHotel($id_hotel): void
    {
        $this->id_hotel = $id_hotel;
    }

    public function getRoomNumber()
    {
        return $this->room_number;
    }

    public function setRoomNumber($room_number): void
    {
        $this->room_number = $room_number;
    }

    public function getFromDate()
    {
        return $this->from_date;
    }

    public function setFromDate($from_date): void
    {
        $this->from_date = $from_date;
    }

    public function getToDate()
    {
        return $this->to_date;
    }

    public function setToDate($to_date): void
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