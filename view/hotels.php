<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';
if(!isset($hotels)) exit(1);
    foreach ($hotels as $hotel) {
        echo '<div class="card mb-3" style="max-width: 540px">
    <div>
        <div >
            <img src="' . __SITE_URL . '/static/images/hotel' . $hotel->getId() . '.jpg" class="img-fluid rounded-start">
        </div>
        <div>
            <div class="card-body">
                <h5 class="card-title">Hotel ' . $hotel->getName() . '</h5>
                <p class="card-text">City: ' . $hotel->getCity() . '</p>
                <p class="card-text">Distance from centre: ' . $hotel->getDistance_from_city_centre() . '</p>
                <p class="card-text">Price: ' . $hotel->getPrice() . '</p>
                <p class="card-text">Rating: ' . $hotel->getRating() . '</p>
                <a href="#" class="btn btn-primary">Book</a>
            </div>
        </div>
    </div>
</div>
';
}
require_once __SITE_PATH . '/view/_footer.php'; ?>
