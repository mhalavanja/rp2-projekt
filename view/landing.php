<?php
// Uključujemo header i navigacijsku traku.
require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/_navBar.php';
// Provjeravamo jesu li podaci koji trebaju biti postavljeni postavljeni, a isto tako je li neka skripta javila error.
if (isset($error)) {
    echo '<div class="alert alert-danger" role="alert">
            ' . $error . '
          </div>';
}
if (isset($_SESSION["booked"])) {
    echo '<div class="alert alert-success" role="alert">
            ' . $_SESSION["booked"] . '
          </div>';
    $_SESSION["booked"] = null;
}
?>
<br>
<!-- Funkcionalnost za pretragu hotela prema gradu, cijeni i ratingu i to zadani vremenski raspon. -->
<!-- Unos grada po kojem pretražujemo je nužan, po uzoru na npr. https://www.hilton.com/. -->
<form class="d-flex justify-content-center" method="post" action="<?php echo __SITE_URL . '/search/processSearch' ?>">
    <div class="col-auto me-1">
        <label class="form-label" for="city">City:</label>
        <input class="form-control" name="city" id="city" type="text"/>
    </div>
    <div class="col-auto me-1">
        <label class="form-label" for="fromDate">From:</label>
        <input class="form-control" name="fromDate" id="fromDate" type="date" value="<?php echo date('Y-m-d'); ?>"
               min="<?php echo date('Y-m-d'); ?>" oninput="toDate.min = this.value"/>
    </div>
    <div class="col-auto me-1">
        <label class="form-label" for="toDate">Until:</label>
        <input class="form-control" name="toDate" id="toDate" type="date" min="<?php echo date('Y-m-d'); ?>"
               value="<?php echo date('Y-m-d'); ?>"/>
    </div>
    <div class="col-auto me-1">
        <label class="form-label" for="price">Price:</label>
        <input class="form-control" name="price" id="price" type="number" min="0"/>
    </div>
    <div class="col-auto me-1">
        <label class="form-label" for="rating">Rating:</label>
        <output name="starRating" for="rating">0</output>
        <input class="form-control p-2" name="rating" id="rating" type="range" min="0" max="5" value="0" step="1"
               oninput="this.previousElementSibling.value = this.value"/>
    </div>
    <div>
        <br>
        <button class="my-2 btn btn-outline-success" type="submit">Search</button>
    </div>
</form>
<br>
<!-- Rotirajući niz slika koji prolazi po trenutno dostupnim hotelima, korisnik ih također može pregledavati u oba smjera. -->
<div class="d-flex justify-content-center">
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <!-- Indikatori. -->
        <ol class="carousel-indicators"></ol>
        <!-- Wrapper za sliedove. -->
        <div class="carousel-inner">
            <!-- Kontrole za lijevo i desno. -->
            <a id="prev" class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a id="next" class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        // Predstojeći dio JS koda brine se za funkcionalnosti carousela, konkretno za
        // njegovo dohvaćanje slika, njihov prikaz uz automatsko gibanje kroz niz, ali i
        // mogućnost korisnika da pomoću dvije kontrole ide lijevo i desno po tom nizu.
        let number = 10;
        let activeLi = 0;
        for (let j = 0; j < number; j++) {
            $('<div class="carousel-item">' +
                '<img class="" src="<?php echo __SITE_URL ?>/static/images/hotel' + (j + 1) + '.jpg"></div>')
                .appendTo('.carousel-inner');
            $('<li data-target="#carousel" data-slide-to="' + j + '"></li>').appendTo('.carousel-indicators')

        }
        $('.carousel-item').first().addClass('active');
        $('.carousel-indicators > li').eq(activeLi).addClass('active');
        activeLi = (activeLi + 1) % number;
        $('#carousel').carousel({
            interval: 2000
        });

        $('#carousel').on('slide.bs.carousel', function () {
            activeLi = (activeLi + 1) % number;
            $('.carousel-indicators > li').eq(activeLi).addClass('active');
        });

        $("#prev").on("click", function (){
            console.log(activeLi);
            $('.carousel-indicators > li').eq(activeLi).removeClass('active');
            $('.carousel-item').eq(activeLi).removeClass('active');
            activeLi = (activeLi - 1) % number;
            $('.carousel-indicators > li').eq(activeLi).addClass('active');
            $('.carousel-item').eq(activeLi).addClass('active');
        });

        $("#next").on("click", function (){
            $('.carousel-indicators > li').eq(activeLi).removeClass('active');
            $('.carousel-item').eq(activeLi).removeClass('active');
            activeLi = (activeLi + 1) % number;
            $('.carousel-indicators > li').eq(activeLi).addClass('active');
            $('.carousel-item').eq(activeLi).addClass('active');

        });
    });
</script>

<!-- Uključujemo footer. -->.
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>