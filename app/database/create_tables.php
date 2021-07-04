<?php


require_once __DIR__ . '/db.class.php';

create_table_users();
create_table_hotels();
create_table_rooms();
create_table_bookings();

exit( 0 );

function has_table( $tblname )
{
    $db = DB::getConnection();

    try
    {
        $st = $db->query( 'SELECT DATABASE()' );
        $dbname = $st->fetch()[0];

        $st = $db->prepare(
            'SELECT * FROM information_schema.tables WHERE table_schema = :dbname AND table_name = :tblname LIMIT 1' );
        $st->execute( ['dbname' => $dbname, 'tblname' => $tblname] );
        if( $st->rowCount() > 0 )
            return true;
    }
    catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }

    return false;
}


function create_table_users()
{
    $db = DB::getConnection();

    if( has_table( 'projekt_users' ) )
        exit( 'Tablica projekt_users vec postoji. Obrisite ju pa probajte ponovno.' );

    try
    {
        $st = $db->prepare(
            'CREATE TABLE IF NOT EXISTS projekt_users (' .
            'id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'username VARCHAR(50) NOT NULL,' .
            'is_admin int NOT NULL,' .
            'password_hash VARCHAR(255) NOT NULL,'.
            'email VARCHAR(50) NOT NULL,' .
            'registration_sequence VARCHAR(20) NOT NULL,' .
            'has_registered INT)'
        );

        $st->execute();
    }
    catch( PDOException $e ) { exit( "PDO error [create projekt_users]: " . $e->getMessage() ); }

    echo "Napravio tablicu projekt_users.<br />";
}


function create_table_hotels()
{
    $db = DB::getConnection();

    if( has_table( 'projekt_hotels' ) )
        exit( 'Tablica projekt_hotels vec postoji. Obrisite ju pa probajte ponovno.' );

    try
    {
        $st = $db->prepare(
            'CREATE TABLE IF NOT EXISTS projekt_hotels (' .
            'id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'name VARCHAR(100) NOT NULL,' .
            'city VARCHAR(100) NOT NULL,' .
            'distance_from_city_centre DECIMAL(15,2) NOT NULL)'
        );

        $st->execute();
    }
    catch( PDOException $e ) { exit( "PDO error [create projekt_hotels]: " . $e->getMessage() ); }

    echo "Napravio tablicu projekt_hotels.<br />";
}

function create_table_rooms()
{
    $db = DB::getConnection();

    if( has_table( 'projekt_rooms' ) )
        exit( 'Tablica projekt_rooms vec postoji. Obrisite ju pa probajte ponovno.' );

    try
    {
        $st = $db->prepare(
            'CREATE TABLE IF NOT EXISTS projekt_rooms (' .
            'id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'id_hotel INT NOT NULL,' .
            'capacity INT NOT NULL,' .
            'view INT NOT NULL,' .
            'price DECIMAL(15,2) NOT NULL,' .
            'image LONGBLOB)'
        );

        $st->execute();
    }
    catch( PDOException $e ) { exit( "PDO error [create projekt_rooms]: " . $e->getMessage() ); }

    echo "Napravio tablicu projekt_rooms.<br />";
}

function create_table_bookings()
{
    $db = DB::getConnection();

    if( has_table( 'projekt_bookings' ) )
        exit( 'Tablica projekt_bookings vec postoji. Obrisite ju pa probajte ponovno.' );

    try
    {
        $st = $db->prepare(
            'CREATE TABLE IF NOT EXISTS projekt_bookings (' .
            'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'id_user INT NOT NULL,' .
            'id_hotel INT NOT NULL,' .
            'room_number INT NOT NULL,' .
            'from_date DATE NOT NULL,' .
            'to_date DATE NOT NULL,' .
            'rating INT,' .
            'comment VARCHAR(1000))'
        );

        $st->execute();
    }
    catch( PDOException $e ) { exit( "PDO error [create projekt_bookings]: " . $e->getMessage() ); }

    echo "Napravio tablicu projekt_bookings.<br />";
}