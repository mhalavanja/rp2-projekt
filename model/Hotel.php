<?php


class Hotel extends Model
{
    private $id;
    private $name;
    private $city;
    private $distance_from_city_centre;
    private $price;
    private $rating;
    private $number_of_comments;
    protected static $table = "projekt_hotels";
    protected static $columns = [];

    public function __construct(){}

    public static function staticInit()
    {
        Hotel::setColumns();
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function getDistance_from_city_centre()
    {
        return $this->distance_from_city_centre;
    }

    public function setDistance_from_city_centre($distance_from_city_centre): void
    {
        $this->distance_from_city_centre = $distance_from_city_centre;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating): void
    {
        $this->rating = $rating;
    }

    public static function getColumns(): array
    {
        return self::$columns;
    }
    public function setNumber_of_comments($number): void
    {
        $this->number_of_comments = $number;
    }

    public static function getNumber_of_comments(): array
    {
        return self::$number_of_comments;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}

Hotel::staticInit();