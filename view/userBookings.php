<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';

$bookings= $_SESSION['bookings'];
?>
<div class="justify-content-around d-flex pb-4 flex-wrap">
    <?php foreach($bookings as $booking){
        $review =Review::getByBookingId($booking->getId());
        if (empty($review)){
            $review = null;
        }else {
            $review=$review[0];
        }
            if(date('Y-m-d') >= $booking->getFrom_date()){ 
        ?>
                <div class="card w-25 m-2" >
                    <h2 class="card-header"> <?php echo Hotel::find($booking->getId_hotel()) ->getName() ?> </h2>
                    <div class="card-body">
                        <h5 class="card-text" >Room: <?php echo Room::find($booking->getRoom_id()) ->getRoom_type() ?></h5>
                        <h5 class="card-text">From: <?php echo $booking->getFrom_date() ?></h5>
                        <h5 class="card-text">Until: <?php echo $booking->getTo_date() ?></h5>
                    </div>
                    <div class="card_footer justify-content-end d-flex p-1">
                        <button class="btn btn-outline-primary me-1" id="<?php echo "btn".$booking->getId() ?>" onclick="<?php echo "openModal(".$booking->getId().")" ?>"   >Leave comment</button>
                    </div>
                    <div id=<?php echo "review". $booking->getId() ?> class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo Hotel::find($booking->getId_hotel()) ->getName() ." : ".Room::find($booking->getRoom_id()) ->getRoom_type() ?></h5>
                                    <button type="button" class="btn-close" id="<?php echo "btnclose".$booking->getId() ?>" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="" >From: <?php echo $booking->getFrom_date() ?> </div>
                                    <div class="" >Until: <?php echo $booking->getTo_date() ?> </div>
                                    <form method="post" action="<?php echo __SITE_URL . '/Hotels/addReview' ?>">
                                        <div class="form-group">
                                            <label for="rating">Rating:</label>
                                            <input class="form-control" id="rating" type="number" name="rating" min="1" max="5" required
                                                value=<?php if($review) echo $review->getRating() ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="comment">Comment:</label>
                                            <input class="form-control" id="comment" type="text" name="comment"
                                                value="<?php if(isset($review)) echo $review->getComment() ?>" >
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" id="hotelId" name="hotelId" value="<?php echo $booking->getId_hotel() ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" id="bookingId" name="bookingId" value="<?php echo $booking->getId() ?>">
                                        </div>
                                        <br>
                                        <?php if($review == null){ ?>
                                        <div class="float-end">
                                            <input class="btn btn-primary" type="submit" name="<?php echo "". $booking->getId() ?>" value="Add comment" />
                                        </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php }
} ?>
</div>
<hr style="height:3px">
    <div class="d-flex">
        <h2 class="justify-content-center d-flex w-100"> Future reservations </h2>
    </div>
<hr>
<?php if (isset($_SESSION['bookingUserDeleteMessage'])){ 
    echo '<p class="alert alert-success">' . $_SESSION['bookingUserDeleteMessage'] . "</p>"; 
    $_SESSION['bookingUserDeleteMessage']=null;
    }?>
<form method="post" action="<?php echo __SITE_URL . '/room/userDeleteBookings' ?>">
    <div class="justify-content-around pb-4 d-flex flex-wrap">
        <?php foreach($bookings as $booking){
                    if(date('Y-m-d') < $booking->getFrom_date()){ 
                ?>
                        <div class="card w-25 m-2" >
                            <h2 class="card-header"> <?php echo Hotel::find($booking->getId_hotel()) ->getName() ?> </h2>
                            <div class="card-body">
                                <h5 class="card-text" >Room: <?php echo Room::find($booking->getRoom_id()) ->getRoom_type() ?></h5>
                                <h5 class="card-text">From: <?php echo $booking->getFrom_date() ?></h5>
                                <h5 class="card-text">Until: <?php echo $booking->getTo_date() ?></h5>
                            </div>
                            <div class="card_footer justify-content-end d-flex p-1">
                                <input class="btn btn-danger" type="submit" name="<?php echo "".$booking->getId() ?>" value="Cancel" />                  
                            </div>
                        </div>
            <?php }
        } ?>
    </div>
</form>

<script>
function openModal(id){
        var modalName = "review"+id;
        var btnName = "btn"+id;
        var btnCloseName = "btnclose"+id;

        var bookingModal = document.getElementById(modalName);

        var bookingBtn = document.getElementById(btnName);

        var bookingBtnClose = document.getElementById(btnCloseName);
        bookingModal.style.display = "block";

        if(bookingBtnClose !== null){
            bookingBtnClose.onclick = function () {
                bookingModal.style.display = "none";
            }
        }
    }
</script>
<?php
require_once __SITE_PATH . '/view/_footer.php'; ?>

