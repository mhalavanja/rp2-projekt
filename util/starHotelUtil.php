<?php
function getStarHotels($hotels)
{
    $starHotels = [];
    foreach ($hotels as $hotel) $starHotels[] = getStarHotel($hotel);
    return $starHotels;
}

function getStarHotel($hotel)
{
    $totalRating = 0;
    $numOfRatings = 0;
    $bookings = Booking::where("id_hotel", $hotel->getId());
    foreach ($bookings as $booking){
        $rating = $booking->getRating();
        if ($rating !== null){
            $numOfRatings++;
            $totalRating += $rating;
        }
    }
    $avgRating = $numOfRatings !== 0 ? round(($totalRating / $numOfRatings) * 2) / 2 : 0;
    $starHotel = new StarHotel();
    $starHotel->setHotel($hotel);
    $starHotel->setAvgRating($avgRating);
    return $starHotel;
}