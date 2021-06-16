<?php if (isset($canBuy) && $canBuy) { ?>
    <form method="post" action="<?php echo __SITE_URL . '/hotels/processBuy' ?>">
        <input type="hidden" name="hotelId" value="<?php if(isset($hotel)) echo $hotel->getId(); ?>">
        <button type="submit">Buy!</button>
    </form>
<?php } ?>