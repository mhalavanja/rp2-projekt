<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';

if (!isset($_SESSION["user"])) return;
else $user = $_SESSION["user"];

if (!isset($_SESSION["hotelInfo"])) return;
else $hotelInfo = $_SESSION["hotelInfo"];

if (!isset($_SESSION["hotelRooms"])) return;
else $hotelRooms = $_SESSION["hotelRooms"];

if (!isset($_SESSION["hotelBookings"])) return;
else $hotelBookings = $_SESSION["hotelBookings"];

echo $hotelInfo[0]->getName();
echo '<br>';
echo $hotelRooms[0]->getId();
echo '<br>';
echo $hotelBookings[0]->getTo_date();
//hotel info

//rooms info

//add pictures

//comments


require_once __SITE_PATH . '/view/_footer.php'; ?>