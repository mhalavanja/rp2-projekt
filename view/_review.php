<?php if (isset($canReview) && $canReview) { ?>
    <h3>You still haven't rated this hotel!</h3>
    <form method="post" action="<?php echo __SITE_URL . '/hotels/processReview' ?>">
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
        <input type="hidden" name="hotel_id" value="<?php if(isset($hotel)) echo $hotel->getId(); ?>">
        <input type="hidden" name="bookingId" value="<?php if(isset($bookingId)) echo $bookingId; ?>">
        <br>
        <button type="submit">Submit!</button>
    </form>
<?php } ?>