<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';

if (!isset($_SESSION["user"])) return;
else $user = $_SESSION["user"];

if (!isset($_SESSION["hotelInfo"])) return;
else $hotelInfo = $_SESSION["hotelInfo"][0];

if (!isset($_SESSION["hotelRooms"])) return;
else $hotelRooms = $_SESSION["hotelRooms"];

if (!isset($_SESSION["hotelBookings"])) return;
else $hotelBookings = $_SESSION["hotelBookings"];


$imeHotela = "hotel". $hotelInfo->getId() .".jpg"; ?>
<div class="justify-content-center d-flex pb-4">
    <div class="card w-25 p-2" >
            <h2 class="card-header">Hotel <?php echo $hotelInfo->getName() ?> </h2>
            <div class="card-body">
                <h5 class="card-text" >City: <?php echo $hotelInfo->getCity() ?> </h5>
                <h5 class="card-text">Distance from centre: <?php echo $hotelInfo->getDistance_from_city_centre() ?> </h5>
                <h5 class="card-text">Rating: <?php echo $hotelInfo->getRating() ?> </h5>
            </div>
        </div>
        <img src= <?php echo "../static/images/". $imeHotela ?> alt=<?php echo $hotelInfo->getName() ?> class="p-2">
    </div>

<hr style="height:3px">
    <div class="d-flex">
        <h2 class="justify-content-center d-flex w-100"> ROOMS </h2>
        <button class="btn btn-outline-primary me-1" id="newRoombtn">Create</button>
    </div>
<hr>

<?php if (isset($roomSuccess) && isset($roomSuccessMessage) && $roomSuccess) echo '<p class="alert alert-success">' . $roomSuccessMessage . "</p>"; ?>
<?php if (isset($roomInfo) && isset($roomInfoMessage) && $roomInfo) echo '<p class="alert alert-info">' . $roomInfoMessage . "</p>"; ?>

<div class="justify-content-around d-flex pb-4">
    <?php foreach($hotelRooms as $room){ ?>
                <div class="card w-25" >
                    <h2 class="card-header"> <?php echo $room->getRoom_type() ?> </h2>
                    <div class="card-body">
                        <h5 class="card-text" >Capacity: <?php echo $room->getCapacity() ?></h5>
                        <h5 class="card-text">Number of rooms: <?php echo $room->getNum_of_rooms() ?></h5>
                        <h5 class="card-text">Price: <?php echo $room->getPrice() ?></h5>
                    </div>
                    <div class="card_footer justify-content-end d-flex p-1">
                        <button class="btn btn-outline-primary me-1" id="<?php echo "btn".$room->getId() ?>" onclick="<?php echo "openModal(".$room->getId().")" ?>" >Change</button>
                    </div>
                    <div id=<?php echo "room". $room->getId() ?> class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo $room->getRoom_type() ?></h5>
                                    <button type="button" class="btn-close" id="<?php echo "btnclose".$room->getId() ?>" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php echo __SITE_URL . '/room/changeInfo' ?>">
                                        <div class="form-group">
                                            <label for="capacity">Capacity:</label>
                                            <input class="form-control" id="capacity" type="number" name="capacity" min="1" required
                                                value="<?php echo $room->getCapacity() ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="number_of_rooms">Number of rooms:</label>
                                            <input class="form-control" id="number_of_rooms" type="number" name="number_of_rooms" min="1" required
                                                value="<?php echo $room->getNum_of_rooms() ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price:</label>
                                            <input class="form-control" id="price" type="number" name="price" min="0" required
                                                value="<?php echo $room->getPrice() ?>">
                                        </div>
                                        <br>
                                        <div class="float-end">
                                            <input class="btn btn-primary" type="submit" name="<?php echo "". $room->getId() ?>" value="Submit changes" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php } ?>
</div>


<div id="newRoom" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New room</h5>
                <button type="button" class="btn-close" id="closeNewRoom" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($roomError) && isset($roomErrorMessage) && $roomError) {
                    echo '<p class="alert alert-danger">' . $roomErrorMessage . "</p>";
                ?>
                <script>document.getElementById("newRoom").style.display = "block";</script><?php } ?>
                <form method="post" action="<?php echo __SITE_URL . '/room/save' ?>">
                    <div class="form-group">
                        <label for="room_type">Type:</label>
                        <input class="form-control" id="room_type" type="text" name="type" required >
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity:</label>
                        <input class="form-control" id="capacity" type="number" name="capacity" min="1" required >
                    </div>
                    <div class="form-group">
                        <label for="number_of_rooms">Number of rooms:</label>
                        <input class="form-control" id="number_of_rooms" type="number" name="number_of_rooms" min="1" required >
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input class="form-control" id="price" type="number" name="price" min="0" required >
                    </div>
                    <br>
                    <div class="float-end">
                        <input class="btn btn-primary" type="submit" id="saveRoom" value="Add room"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

function openModal(id){
    var modalName = "room"+id;
    var btnName = "btn"+id;
    var btnCloseName = "btnclose"+id;

    var roomModal = document.getElementById(modalName);

    var roomBtn = document.getElementById(btnName);

    var roomBtnClose = document.getElementById(btnCloseName);
    roomModal.style.display = "block";

    if(roomBtnClose !== null){
        roomBtnClose.onclick = function () {
            roomModal.style.display = "none";
        }
    }
}


    var createModal = document.getElementById("newRoom");
    var createBtn = document.getElementById("newRoombtn");
    var createCloseBtn = document.getElementById("closeNewRoom");

    if(createBtn !== null){
        createBtn.onclick = function () {
            createModal.style.display = "block";
        }
    }
    if(createCloseBtn !== null){
        createCloseBtn.onclick = function () {
            createModal.style.display = "none";
            <?php unset($loginError); ?>
        }
    }
    window.onclick = function (event) {
        if (event.target == createModal) {
            createModal.style.display = "none";
            <?php unset($loginError); ?>
        }
    }

</script>


<?php
require_once __SITE_PATH . '/view/_footer.php'; ?>