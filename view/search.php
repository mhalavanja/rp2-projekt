<?php require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/util/drawStarsUtil.php'; ?>
    <form method="post" action="<?php echo __SITE_URL . '/search/processSearch' ?>">
        <div>
            <label for="search">Search hotels: </label>
            <input type="text" id="search" name="search">
        </div>
        <button type="submit">Search!</button>
    </form>

<?php if (isset($starHotels)) { ?>
    <br>
    <form method="post" action="<?php echo __SITE_URL . '/search/searchDetails' ?>">

    <table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Stars</th>
        <th></th>
    </tr>
    <?php
    foreach ($starHotels as $starHotel) {
        $avgRating = $starHotel->getAvgRating();
        echo '<tr>' .
            '<td>' . $starHotel->getHotel()->getName() . '</td>' .
//            '<td>' . $starHotel->getHotel()->getDescription() . '</td>' .
//            '<td>' . $starHotel->getHotel()->getPrice() . '</td>' .
            '<td>' . getStars($avgRating, true) . '</td>' .
            '<td><button type="submit" name="hotel_id" value="hotel_' .
            $starHotel->getHotel()->getId() . '">Details</button></td>' .
            '</tr>';
    }
}
?>
    </table>
    </form>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>