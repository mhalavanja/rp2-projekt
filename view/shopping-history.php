<?php require_once __SITE_PATH . '/view/_header.php';
if (!isset($products) || sizeof($products) == 0) echo "<h2>You have not yes bought any product. Let's change that :)</h2>";
else { ?>
<h2>Products you have bought already:</h2>
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
                '<td><button type="submit" name="product_id" value="product_' . $product->getId() . '">Review</button></td>' .
                '</tr>';
        }
        echo '</table>' . '</form>';
        }
        require_once __SITE_PATH . '/view/_footer.php'; ?>
