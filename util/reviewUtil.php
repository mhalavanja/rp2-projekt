<?php

function getReviewsForHotel($bookings)
{
    $reviews = [];
    foreach ($bookings as $booking) {
        $review = [];
        $id = $booking->getId_user();
        $reviewer = User::find($id);
        $rating = $booking->getRating();
        $comment = $booking->getComment();

        if ($rating === null && $comment === null) continue;

        $review["username"] = $reviewer->getUsername();
        $review["rating"] = $rating;
        $review["comment"] = $comment;
        $reviews[] = $review;
    }
    return $reviews;
}

function getSaleIdForUserIfTheyCanReview($userId, $bookings)
{
    foreach ($bookings as $booking) {
        $id = $booking->getId_user();
        $rating = $booking->getRating();
        $comment = $booking->getComment();

        if ($id === $userId &&
            $rating === null && $comment === null) {
            return $booking->getId();
        }
    }
    return null;
}