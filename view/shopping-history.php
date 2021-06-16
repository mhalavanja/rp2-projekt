<?php require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/util/drawStarsUtil.php';
if (!isset($starHotels) || sizeof($starHotels) == 0) echo "<h2>You have not yes bought any hotel. Let's change that :)</h2>";
else { ?>
<h2>Hotels you have bought already:</h2>
<form method="post" action="<?php echo __SITE_URL . '/hotels/hotel' ?>">
    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stars</th>
            <th></th>
        </tr>
        <?php foreach ($starHotels as $starHotel) {
            $hotel = $starHotel->getHotel();
            echo '<tr>' .
                '<td>' . $hotel->getName() . '</td>' .
                '<td>' . $hotel->getDescription() . '</td>' .
                '<td>' . $hotel->getPrice() . '</td>' .
                '<td>' . getStars($starHotel->getAvgRating(), true) . '</td>' .
                '<td><button type="submit" name="hotel_id" value="hotel_' . $hotel->getId() . '">Review</button></td>' .
                '</tr>';
        }
        echo '</table>' . '</form>';
        }
        require_once __SITE_PATH . '/view/_footer.php'; ?>
