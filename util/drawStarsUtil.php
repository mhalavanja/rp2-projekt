<?php
function getStars($avgRating, $small)
{
    if ($avgRating !== null) {
        $prefix = "";
        if ($small) $prefix = "small-";
        $starSrc = __SITE_URL . "/static/" . $prefix . "star.png";
        $halfStarSrc = __SITE_URL . "/static/" . $prefix . "half-star.png";
        $stars = "";
        while ($avgRating > 0.5) {
            $stars .= "<img src='$starSrc'>";
            $avgRating--;
        }
        if ($avgRating === 0.5) $stars .= "<img src='$halfStarSrc'>";
        return $stars;
    }
}