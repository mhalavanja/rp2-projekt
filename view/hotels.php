<?php
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';
require_once __SITE_PATH . '/view/sortChoice.php';
if (!isset($hotels)) exit(1);

function cmp($hotel1, $hotel2)
{
    return strcmp($hotel1->getCity(), $hotel2->getCity());
}

//print_r( $hotels[0]->getPrice ());
usort($hotels, "cmp");

for ($i = 0; $i < sizeof($hotels); ++$i) {
    $hotel = $hotels[$i];
    echo '<div class=" card mb-3" style="max-width: 540px">
    <div>
        <div >
            <img id="src-' . $i . '" src="' . __SITE_URL . '/static/images/hotel' . $hotel->getId() . '.jpg" class="img-fluid rounded-start">
        </div>
        <div>
            <div class="card-body">
                <h5 id="name-' . $i . '" class="card-title">' . $hotel->getName() . '</h5>
                <p id="city-' . $i . '" class="card-text">City: ' . $hotel->getCity() . '</p>
                <p id="distance-' . $i . '" class="card-text">Distance from centre: ' . $hotel->getDistance_from_city_centre() . '</p>
                <p id="price-' . $i . '" class="card-text">Price: ' . $hotel->getPrice() . '</p>
                <p id="rating-' . $i . '" class="card-text">Rating: ' . $hotel->getRating() . '</p>
                <form method="get" action="' . __SITE_URL . '/hotels/hotel">
                <input id="hotelId-' . $i . '" name="hotelId" type="hidden" value="' . $hotel->getId() . '">
                <button type="submit" class="btn btn-primary">Book</button>
                </form>
            </div>
        </div>
    </div>
</div>
';
}
?>
<script>
    let src = "<?php echo __SITE_URL . '/static/images/hotel'; ?>"
    function getComboA(selectObject) {
        $.ajax({
            url: "sort",
            type: "GET",
            data: {sortBy: selectObject.value},
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                for (let i = 0; i < data.length; ++i) {
                    let hotel = data[i];
                    $("#name-" + i).html(hotel.name);
                    $("#city-" + i).html("City: " + hotel.city);
                    $("#distance-" + i).html("Distance from centre: " + hotel.distance_from_city_centre);
                    $("#price-" + i).html("Price: " + hotel.price);
                    $("#rating-" + i).html("Rating: " + hotel.rating);
                    $("#hotelId-" + i).val(hotel.id);
                    $("#src-" + i).attr("src", src + hotel.id + ".jpg");
                }
            }
        });
    }
</script>
<?php
require_once __SITE_PATH . '/view/_footer.php'; ?>
