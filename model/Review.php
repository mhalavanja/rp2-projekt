<?php


class Review extends Model
{
    private $id;
    private $id_user;
    private $id_hotel;
    private $rating;
    private $comment;
    protected static $table = "projekt_reviews";
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

    public static function getColumns(): array
    {
        return self::$columns;
    }
}

Booking::staticInit();