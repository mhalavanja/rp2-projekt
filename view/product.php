<?php require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/util/drawStarsUtil.php';

if(isset($starHotel)){
    $hotel = $starHotel->getHotel();
    if ($hotel) echo "<h3>Hotel: " . $hotel->getName() . "</h3>";
    echo getStars($starHotel->getAvgRating(), false);
}
if (isset($numOfSoldHotels)) echo "<p>This hotel has been sold " . $numOfSoldHotels . " times.";
if (!isset($reviews) || sizeof($reviews) === 0) echo "<p>This hotel has no reviews.</p>";
else { ?>
    <table>
    <tr>
        <th>User</th>
        <th>Rating</th>
        <th>Comment</th>
    </tr>
    <?php
    foreach ($reviews as $review) {
        echo '<tr>' .
            '<td>' . $review["username"] . '</td>' .
            '<td>' . $review["rating"] . '</td>' .
            '<td>' . $review["comment"] . '</td>' .
            '</tr>';
    }
}
?>
    </table>
    <br>

<?php require_once __SITE_PATH . '/view/_review.php'; ?>
<?php require_once __SITE_PATH . '/view/_canBuy.php'; ?>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>