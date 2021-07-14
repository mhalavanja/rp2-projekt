<!--View za prikaz pojedinog hotela na koji se dođe nakon što se sa početne stranice pretraže hoteli i odabere se neki-->
<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';
if (isset($error)) {
    echo '<div class="alert alert-danger" role="alert">
            ' . $error . '
          </div>';
}

//prikazemo  informacije o hotelu
if (!isset($hotel)) exit(1);
echo '
<div class="container">
  <div class="row">
    <div class="col">
        <div>
            <img src="' . __SITE_URL . '/static/images/hotel' . $hotel->getId() . '.jpg" class="">
        </div>
        <div>
                <h5 class="">Hotel ' . $hotel->getName() . '</h5>
                <p class="">City: ' . $hotel->getCity() . '</p>
                <p class="">Distance from centre: ' . $hotel->getDistance_from_city_centre() . '</p>
                <p class="">Price: ' . $hotel->getPrice() . '</p>
                <p class="">Rating: ' . $hotel->getRating() . '</p>
        </div>
        </div>
        </div>
    </div>';

//prikazemo  informacije o svim sobama u tom hotelu te se one mogu bookirati ako su dostupne
if (!isset($rooms)) exit(1);
if (!isset($reviews)) exit(1);

echo '<div class="container">';
for ($i = 0; $i < max(sizeof($rooms), sizeof($reviews)); ++$i) {
    $room = $i < sizeof($rooms) ? $rooms[$i] : null;
    $review = $i < sizeof($reviews)? $reviews[$i] : null;
    if ($room || $review) echo '<div class="row">';
    if ($review && !$room) echo '<div class="col"></div>';
    if($room) echo '
    <div class="col">
        <div class=" card mb-3" style="max-width: 540px">
            <div>
                <div class="card-body">
                    <p class="card-text">Room type: ' . $room->getRoom_type() . '</p>
                    <p class="card-title">Capacity: ' . $room->getCapacity() . '</p>
                    <p class="card-text">Price: ' . $room->getPrice() . '</p>
                    <form method="get" action="' . __SITE_URL . '/room/processBookRoom">
                        <input name="roomId" type="hidden" value="' . $room->getId() . '">
                        <input name="roomType" type="hidden" value="' . $room->getRoom_type() . '">
                        <input name="hotelId" type="hidden" value="' . $hotel->getId() . '">
                        <button type="submit" class="btn btn-primary">Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>';
    if($review) echo '
    <div class=" card mb-3" style="max-width: 540px">
        <div>
            <div>
                <div class="card-body">
                    <p class="card-text">Username: ' . $review->getName_user() . '</p>
                    <p class="card-title">Rating: ' . $review->getRating() . '</p>
                    <p class="card-text">Comment: ' . $review->getComment() . '</p>
                </div>
            </div>
        </div>
    </div>
    </div>
';
}
?>


<?php
require_once __SITE_PATH . '/view/_footer.php'; ?>
