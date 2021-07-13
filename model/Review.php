<?php


class Review extends Model
{
    private $id;
    private $id_booking;
    private $id_user;
    private $name_user;
    private $id_hotel;
    private $name_hotel;
    private $rating;
    private $comment;
    protected static $table = "projekt_reviews";
    protected static $columns = [];

    public function getByBookingId($bookingId){
        $db = DB::getConnection();
        try{
            $sql = "SELECT * FROM projekt_reviews WHERE id_booking = :val;";
                $st = $db->prepare($sql);
                $st->execute(array(":val" => $bookingId));
            } catch (PDOException $e) {
                exit("PDO error [select " . static::$table . "]: " . $e->getMessage());
            }
        $arr = [];
        foreach ($st->fetchAll() as $row) {
            $obj = new Review;
            $obj->setId($row['id']);
            $obj->setId_booking($row['id_booking']);
            $obj->setId_user($row['id_user']); 
            $obj->setName_user($row['name_user']);
            $obj->setId_hotel($row['id_hotel']); 
            $obj->setName_hotel($row['name_hotel']); 
            $obj->setRating($row['rating']);
            $obj->setComment($row['comment']);
            $arr[] = $obj;
        }
        return $arr;
    }

    public function __construct()
    {
    }

    public static function staticInit()
    {
        Review::setColumns();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId_booking()
    {
        return $this->id_booking;
    }

    public function setId_booking($id_booking)
    {
        $this->id_booking = $id_booking;
    }

    public function getId_user()
    {
        return $this->id_user;
    }

    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getName_user()
    {
        return $this->name_user;
    }

    public function setName_user($name_user): void
    {
        $this->name_user = $name_user;
    }

    public function getId_hotel()
    {
        return $this->id_hotel;
    }

    public function setId_hotel($id_hotel): void
    {
        $this->id_hotel = $id_hotel;
    }

    public function getName_hotel()
    {
        return $this->name_hotel;
    }

    public function setName_hotel($name_hotel): void
    {
        $this->name_hotel = $name_hotel;
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

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}

Booking::staticInit();