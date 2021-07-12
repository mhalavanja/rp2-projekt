<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';
if (isset($error)) {
    echo '<div class="alert alert-danger" role="alert">
            ' . $error . '
          </div>';
}
echo '
<div>
        <div >
            <img src="' . __SITE_URL . '/static/images/hotel' . $hotel->getId() . '.jpg" class="">
        </div>
        <div>
                <h5 class="">Hotel ' . $hotel->getName() . '</h5>
                <p class="">City: ' . $hotel->getCity() . '</p>
                <p class="">Distance from centre: ' . $hotel->getDistance_from_city_centre() . '</p>
                <p class="">Price: ' . $hotel->getPrice() . '</p>
                <p class="">Rating: ' . $hotel->getRating() . '</p>
        </div>
    </div>';

foreach ($rooms as $room) {
    echo '<div class=" card mb-3" style="max-width: 540px">
    <div>
        <div >
            <img src="'.$room->getImage() . '" class="img-fluid rounded-start" alt="Slika">
        </div>
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
</div>
';
}
?>



<?php
require_once __SITE_PATH . '/view/_footer.php'; ?>
