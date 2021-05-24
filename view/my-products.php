<?php require_once __SITE_PATH . '/view/_header.php';
if (!isset($products) || sizeof($products) == 0) echo "<h2>You are not selling any product.</h2>";
else { ?>
    <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=products/product' ?>">
    <table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th></th>
    </tr>
    <?php foreach ($products as $product) {
        echo '<tr>' .
            '<td>' . $product->getName() . '</td>' .
            '<td>' . $product->getDescription() . '</td>' .
            '<td>' . $product->getPrice() . '</td>' .
            '<td><button type="submit" name="product_id" value="product_' . $product->getId() . '">Details</button></td>' .
            '</tr>';
    }
    echo '</table>' . '</form>';
}
require_once __SITE_PATH . '/view/_footer.php'; ?>
