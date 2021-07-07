<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<form method="post" action="<?php echo __SITE_URL . '/search/processSearch' ?>"> 
    <div>
        <label for="city">City:</label>
        <input name="city" id="city" type="text"/>
    </div>
    <div>
        <label for="fromDate">From:</label>
        <input name="fromDate" id="fromDate" type="date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" oninput="toDate.min = this.value"/>
    </div>
    <div>
        <label for="toDate">Until:</label>
        <input name="toDate" id="toDate" type="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>"/>
    </div>
    <div>
        <label for="price">Price:</label>
        <input name="price" id="price" type="number" min = "0" value = "0"/>
    </div>
    <div>
        <label for="rating">Rating:</label>
        <input name="rating" id="rating" type="range" min ="0" max ="5"  value ="0" step = "1" oninput="this.nextElementSibling.value = this.value"/>
        <output name="starRating" for="rating">0</output>
    </div>
    <br>
    <button type="submit">Search</button>
</form>
<br>
<div id="carouselExampleIndicators" class="carousel slide w-50 " data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>

    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo __SITE_URL ?>/static/images/hotel1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="<?php echo __SITE_URL ?>/static/images/hotel2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="<?php echo __SITE_URL ?>/static/images/hotel3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
<script>
    $('.carousel').carousel({
        interval: 200
    })
</script>