<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';


//$_SESSION['bookings']
//$_SESSION['hotels'] 
$hotels = $_SESSION['hotels'];
$bookings = $_SESSION['bookings']; 
echo '<br><br>';
foreach($_SESSION['bookings'] as $booking){
    echo $booking->getId_hotel();
    echo Hotel::find($booking->getId_hotel()) ->getName();
    echo '<br>';
}
?>
<div class="justify-content-around d-flex pb-4 flex-wrap">
    <?php foreach($_SESSION['bookings'] as $booking){ 
        ?>
                <div class="card w-25 m-2" >
                    <h2 class="card-header"> <?php echo Hotel::find($booking->getId_hotel()) ->getName() ?> </h2>
                    <div class="card-body">
                        <h5 class="card-text" >Room: <?php echo Room::find($booking->getRoom_id()) ->getRoom_type() ?></h5>
                        <h5 class="card-text">From: <?php echo $booking->getFrom_date() ?></h5>
                        <h5 class="card-text">Until: <?php echo $booking->getTo_date() ?></h5>
                    </div>
                    <div class="card_footer justify-content-end d-flex p-1">
                        <button class="btn btn-outline-info me-1" id="<?php echo "btn".$booking->getId() ?>" onclick="<?php echo "leaveComment(".$booking->getId().")" ?>" >Leave comment</button>
                    </div>
                    <div id=<?php echo "reviw". $booking->getId() ?> class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo Hotel::find($booking->getId_hotel()) ->getName() ?></h5>
                                    <button type="button" class="btn-close" id="<?php echo "btnclose".$booking->getId() ?>" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php echo __SITE_URL . '/' ?>">
                                        <div class="form-group">
                                            <label for="rating">Rating:</label>
                                            <input class="form-control" id="rating" type="number" name="rating" min="1" max="5" required
                                                value="<?php echo $room->getCapacity() ?>">
                                        </div>
                                        
                                        <br>
                                        <div class="float-end">
                                            <input class="btn btn-primary" type="submit" name="<?php echo "". $booking->getId() ?>" value="Add comment" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php } ?>
</div>

?>


