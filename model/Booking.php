<?php


class Booking extends Model
{
    private $id;
    private $id_user;
    private $id_hotel;
    private $room_id;
    private $from_date;
    private $to_date;
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

    public function getId_hotel()
    {
        return $this->id_hotel;
    }

    public function setId_hotel($id_hotel): void
    {
        $this->id_hotel = $id_hotel;
    }

    public function getRoom_id()
    {
        return $this->room_id;
    }

    public function setRoom_id($room_id): void
    {
        $this->room_id = $room_id;
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

    public static function getColumns(): array
    {
        return self::$columns;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}

Booking::staticInit();