<?php

function getReviewsForProduct($sales)
{
    $reviews = [];
    foreach ($sales as $sale) {
        $review = [];
        $id = $sale->getId_user();
        $reviewer = User::find($id);
        $rating = $sale->getRating();
        $comment = $sale->getComment();

        if ($rating === null && $comment === null) continue;

        $review["username"] = $reviewer->getUsername();
        $review["rating"] = $rating;
        $review["comment"] = $comment;
        $reviews[] = $review;
    }
    return $reviews;
}

function getSaleIdForUserIfTheyCanReview($userId, $sales)
{
    foreach ($sales as $sale) {
        $id = $sale->getId_user();
        $rating = $sale->getRating();
        $comment = $sale->getComment();

        if ($id === $userId &&
            $rating === null && $comment === null) {
            return $sale->getId();
        }
    }
    return null;
}

function alreadyBought($userId, $sales)
{
    foreach ($sales as $sale) if ($sale->getId_user() === $userId) return true;
    return false;
}