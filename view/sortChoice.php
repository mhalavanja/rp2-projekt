<!-- Prikaz select izbornika za sortiranje popisa hotela po jednom od četiri kriterija: -->
<!-- imenu grada (to je ujedno i defaultni), udaljenosti od centra grada, -->
<!-- cijeni (cijena hotela odgovara minimumu cijena svih soba u tom hotelu) i prosječnoj ocjeni. -->
<div class="sort-choice" style="background-color: #2596be;" >
    <select class="btn btn-light" name="sort_name" id="sort" onchange="getComboA(this)">
        <option value="city" selected="selected" hidden>Sort by</option>
        <option value="distance">Distance from centre</option>
        <option value="price">Price</option>
        <option value="rating">Rating</option>
    </select>
</div>