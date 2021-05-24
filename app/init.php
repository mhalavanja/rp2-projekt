<?php

// Učitaj definiciju bazne klase za controllere.
require_once __SITE_PATH . '/app/' . 'BaseController.php';

// Učitaj definiciju registry klase.
require_once __SITE_PATH . '/app/' . 'Registry.php';

// Učitaj definiciju routera.
require_once __SITE_PATH . '/app/' . 'Router.php';

// Učitaj definiciju templatea.
require_once __SITE_PATH . '/app/' . 'Template.php';

// Učitaj definiciju spoja na bazu podataka.
require_once __SITE_PATH . '/app/database/' . 'db.class.php';

// Automatsko učitavanja klasa iz modela kad se pozove new.
spl_autoload_register(function ($class_name) {
    // Imena datoteke od klasa će biti napisana malim slovima.
    // Npr. za klasu User će biti spremljeno u User.php
    $filename = $class_name . '.php';
//    echo $filename . "<br>";
    $file = __SITE_PATH . '/model/' . $filename;

    if (file_exists($file) === false)
        return false;

    require_once($file);
    return true;
});
