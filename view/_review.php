<?php if (isset($canReview) && $canReview) { ?>
    <h3>You still haven't rated this product!</h3>
    <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=products/processReview' ?>">
        <div>
            <label for="rating">Select your rating:</label>
            <select id="rating" name="rating">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <br>
        <div>
            <input type="text" id="comment" name="comment" placeholder="Enter your comment here">
        </div>
        <input type="hidden" name="product_id" value="<?php if(isset($product)) echo $product->getId(); ?>">
        <input type="hidden" name="saleId" value="<?php if(isset($saleId)) echo $saleId; ?>">
        <br>
        <button type="submit">Submit!</button>
    </form>
<?php } ?>