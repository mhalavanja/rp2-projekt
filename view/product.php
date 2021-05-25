<?php require_once __SITE_PATH . '/view/_header.php';
if(isset($product)) echo "<h3>Product: " . $product->getName() . "</h3>";
if (!isset($reviews) || sizeof($reviews) == 0)
    echo "<p>This product has no reviews.</p>";
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