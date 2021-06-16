<?php


class StarHotel
{
    private $hotel;
    private $avgRating;

    public function __construct(){}

    public function getHotel()
    {
        return $this->hotel;
    }

    public function setHotel($hotel)
    {
        $this->hotel = $hotel;
    }

    public function getAvgRating()
    {
        return $this->avgRating;
    }

    public function setAvgRating($avgRating)
    {
        $this->avgRating = $avgRating;
    }
}