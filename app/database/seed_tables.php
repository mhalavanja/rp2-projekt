<?php
require_once __DIR__ . '/db.class.php';

//TODO: Ovo nije napravljeno, podatke mozemo seedat nakon sto smo sigurni oko modela
//seed_table_users();
seed_table_hotels();
seed_table_rooms();
seed_table_bookings();

exit(0);

function seed_table_users()
{
    $db = DB::getConnection();
    try {
        $st = $db->prepare('INSERT INTO projekt_users(username, is_admin, password_hash, email, registration_sequence, has_registered) VALUES (:username, :is_admin, :password, \'a@b.com\', \'abc\', \'1\')');

        $st->execute(array('username' => 'mirko', 'is_admin' => '1', 'password' => password_hash('mirkovasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'slavko', 'is_admin' => '1', 'password' => password_hash('slavkovasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'ana', 'is_admin' => '1', 'password' => password_hash('aninasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'maja', 'is_admin' => '1', 'password' => password_hash('majinasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'pero', 'is_admin' => '1', 'password' => password_hash('perinasifra', PASSWORD_DEFAULT)));
    } catch (PDOException $e) {
        exit("PDO error [insert projekt_users]: " . $e->getMessage());
    }

    echo "Ubacio u tablicu projekt_users.<br />";
}

function seed_table_hotels()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare( 'INSERT INTO projekt_hotels(name, city, distance_from_city_centre) VALUES (:name, :city, :distance_from_city_centre)' );

        $st->execute( array( 'name' => 'Hilbert', "city" => "Berlin", "distance_from_city_centre" => 1) );
        $st->execute( array( 'name' => 'Dijkstra', "city" => "Amsterdam", "distance_from_city_centre" => 1.2) );
        $st->execute( array( 'name' => 'Lamport', "city" => "New York", "distance_from_city_centre" => 1.35) );
        $st->execute( array( 'name' => 'Torvalds', "city" => "Helsinki", "distance_from_city_centre" => 0.2) );
    } catch (PDOException $e) {
        exit("PDO error [projekt_hotels]: " . $e->getMessage());
    }

    echo "Ubacio u tablicu projekt_hotels.<br />";
}

function seed_table_rooms()
{
    $db = DB::getConnection();

    try {
//        $st = $db->prepare( 'INSERT INTO projekt_rooms(id_user, name, description, price) VALUES (:id_user, :name, :description, :price)' );
//
//        $st->execute( array( 'id_user' => 1, 'name' => 'Cell Phone Carbon Fiber Soft Cover Case', 'description' => 'Your device will be attractive and usable while protected from scratches in this Stylish New case. Protect your phone from scratches, dust or damages. It moulds perfectly to your phone\'s shape while providing easy access to vital functions.', 'price' => 0.99 ) ); // mirko
//        $st->execute( array( 'id_user' => 2, 'name' => '50mm Foam Pads Headphone Cover Cap', 'description' => 'Durable and soft The ear foam will enhance the bass performance of your headphones More confortable for your ears.', 'price' => 2.04) ); // slavko
//        $st->execute( array( 'id_user' => 1, 'name' => 'Phosphor Bronze extra Light Acoustic Guitar Strings', 'description' => 'Lightest gauge of acoustic strings, ideal for beginners or any player that prefers a softer tone and easy bending. Phosphor Bronze was introduced to string making in 1974 and has become synonymous with warm, bright, and well balanced acoustic tone. Phosphor Bronze strings are precision wound with corrosion resistant phosphor bronze onto a carefully drawn, hexagonally shaped, high carbon steel core. The result is long lasting, bright sounding tone with excellent intonation.', 'price' => 7.89 ) ); // mirko
//        $st->execute( array( 'id_user' => 3, 'name' => '30 Used Tennis Balls - Branded. Very Clean.', 'description' => 'Good condition. All are clean. Branded balls. We have sold over 400,000 balls over a 10 year period so you can be sure of getting a great service and hotel.', 'price' => 16.89 ) ); // ana
    } catch (PDOException $e) {
        exit("PDO error [projekt_rooms]: " . $e->getMessage());
    }

    echo "Ubacio u tablicu projekt_rooms.<br />";
}

function seed_table_bookings()
{
    $db = DB::getConnection();

    try {
//        $st = $db->prepare( 'INSERT INTO projekt_bookings(id_hotel, id_user, rating, comment) VALUES (:id_hotel, :id_user, :rating, :comment)' );
//
//        $st->execute( array( 'id_hotel' => 1, 'id_user' => 4, 'rating' => 5, 'comment' => 'Excellent. Very happy.' ) );
//        $st->execute( array( 'id_hotel' => 1, 'id_user' => 5, 'rating' => 3, 'comment' => 'Could be better...' ) );
//        $st->execute( array( 'id_hotel' => 1, 'id_user' => 3, 'rating' => NULL, 'comment' => NULL ) );
//
//        $st->execute( array( 'id_hotel' => 2, 'id_user' => 4, 'rating' => 1, 'comment' => 'Don\'t buy. This is a scam.' ) );
//        $st->execute( array( 'id_hotel' => 2, 'id_user' => 1, 'rating' => NULL, 'comment' => NULL ) );
//
//        $st->execute( array( 'id_hotel' => 3, 'id_user' => 5, 'rating' => 5, 'comment' => 'Great guitar strings. Would buy again.' ) );
//        $st->execute( array( 'id_hotel' => 3, 'id_user' => 3, 'rating' => 4, 'comment' => 'Pretty good strings.' ) );
//
//        $st->execute( array( 'id_hotel' => 4, 'id_user' => 1, 'rating' => 5, 'comment' => 'Great tennis balls, I can now play for the whole year!' ) );
    } catch (PDOException $e) {
        exit("PDO error [projekt_bookings]: " . $e->getMessage());
    }

    echo "Ubacio u tablicu projekt_bookings.<br />";
}


