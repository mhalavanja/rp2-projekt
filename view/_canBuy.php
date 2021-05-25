<?php if (isset($canBuy) && $canBuy) { ?>
    <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=products/processBuy' ?>">
        <input type="hidden" name="productId" value="<?php if(isset($product)) echo $product->getId(); ?>">
        <button type="submit">Buy!</button>
    </form>
<?php } ?>