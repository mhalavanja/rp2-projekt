<?php


class Room extends Model
{
    private $id;
    private $id_hotel;
    private $num_of_rooms;
    private $capacity;
    private $room_type;
    private $price;
    protected static $table = "projekt_rooms";
    protected static $columns = [];

    public function __construct(){}

    public static function staticInit()
    {
        Room::setColumns();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId_hotel()
    {
        return $this->id_hotel;
    }

    public function setId_hotel($id_hotel): void
    {
        $this->id_hotel = $id_hotel;
    }

    public function getNum_of_rooms()
    {
        return $this->num_of_rooms;
    }

    public function setNum_of_rooms($num_of_rooms): void
    {
        $this->num_of_rooms = $num_of_rooms;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getRoom_type()
    {
        return $this->room_type;
    }

    public function setRoom_type($room_type): void
    {
        $this->room_type = $room_type;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public static function getColumns(): array
    {
        return self::$columns;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}

Room::staticInit();