<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';

if (!isset($_SESSION["user"])) return;
else $user = $_SESSION["user"];

if (!isset($_SESSION["hotelInfo"])) return;
else $hotelInfo = $_SESSION["hotelInfo"][0];

if (!isset($_SESSION["hotelRooms"])) return;
else $hotelRooms = $_SESSION["hotelRooms"];

if (!isset($_SESSION["hotelBookings"])) return;
else $hotelBookings = $_SESSION["hotelBookings"];

echo $hotelInfo->getName();
echo '<br>';
echo $hotelRooms[0]->getId();
echo '<br>';
if(isset($hotelBookings[0]))
echo $hotelBookings[0]->getTo_date();
//hotel info

//rooms info

//add pictures

//comments

$imeHotela = "hotel". $hotelInfo->getId() .".jpg";
echo '<div class="justify-content-center d-flex">';
echo    '<div class="card w-25 p-2" >
            <h2 class="card-header">Hotel '. $hotelInfo->getName() . '</h2>
            <div class="card-body">
                <h5 class="card-text" >City: ' . $hotelInfo->getCity() . '</h5>
                <h5 class="card-text">Distance from centre: ' . $hotelInfo->getDistance_from_city_centre() . '</h5>
                <h5 class="card-text">Rating: ' . $hotelInfo->getRating() . '</h5>
            </div>
        </div>
        <img src='. '../static/images/'. $imeHotela .' alt='. $hotelInfo->getName() .' class="p-2">
    </div>';
?>

<?php
require_once __SITE_PATH . '/view/_footer.php'; ?>