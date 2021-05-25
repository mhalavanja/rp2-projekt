<?php require_once __SITE_PATH . '/view/_header.php'; ?>

    <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=search/processSearch' ?>">
        <div>
            <label for="search">Search product: </label>
            <input type="text" id="search" name="search">
        </div>
        <button type="submit">Search!</button>
    </form>

<?php if (isset($products)) { ?>
    <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=search/searchDetails' ?>">

    <table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th></th>
    </tr>
    <?php
    foreach ($products as $product) {
        echo '<tr>' .
            '<td>' . $product->getName() . '</td>' .
            '<td>' . $product->getDescription() . '</td>' .
            '<td>' . $product->getPrice() . '</td>' .
            '<td><button type="submit" name="product_id" value="product_' . $product->getId() . '">Details</button></td>' .
            '</tr>';
    }
}
?>
    </table>
    </form>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>