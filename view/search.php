<?php require_once __SITE_PATH . '/view/_header.php';
    require_once __SITE_PATH . '/util/stars.php';?>
    <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=search/processSearch' ?>">
        <div>
            <label for="search">Search product: </label>
            <input type="text" id="search" name="search">
        </div>
        <button type="submit">Search!</button>
    </form>

<?php if (isset($starProducts)) { ?>
    <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=search/searchDetails' ?>">

    <table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Stars</th>
        <th></th>
    </tr>
    <?php
    foreach ($starProducts as $starProduct) {
        $avgRating = $starProduct->getAvgRating();
        echo '<tr>' .
            '<td>' . $starProduct->getProduct()->getName() . '</td>' .
            '<td>' . $starProduct->getProduct()->getDescription() . '</td>' .
            '<td>' . $starProduct->getProduct()->getPrice() . '</td>' .
            '<td>' . getStars($avgRating, true) . '</td>' .
            '<td><button type="submit" name="product_id" value="product_' .
                $starProduct->getProduct()->getId() . '">Details</button></td>' .
            '</tr>';
    }
}
?>
    </table>
    </form>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>