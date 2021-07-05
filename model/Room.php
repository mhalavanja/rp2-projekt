<?php


class Room extends Model
{
    private $id;
    private $id_hotel;
    private $capacity;
    private $room_type;
    private $price;
    private $image;
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

    public function getIdHotel()
    {
        return $this->id_hotel;
    }

    public function setIdHotel($id_hotel): void
    {
        $this->id_hotel = $id_hotel;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getRoomType()
    {
        return $this->room_type;
    }

    public function setRoomType($room_type): void
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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }
}

Room::staticInit();