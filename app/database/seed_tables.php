<?php
require_once __DIR__ . '/db.class.php';

seed_table_users();
seed_table_hotels();
seed_table_rooms();
seed_table_bookings();

exit(0);

function seed_table_users()
{
    $db = DB::getConnection();
    try {
        $st = $db->prepare('INSERT INTO projekt_users(username, name, lastname, isAdmin, password_hash, email, registration_sequence, has_registered) VALUES (:username, :name, :lastname, :isAdmin, :password, \'a@b.com\', \'abc\', \'1\')');

        $st->execute(array('username' => 'mirko','name' => 'Mirko','lastname' => 'Mirković', 'isAdmin' => '1', 'password' => password_hash('mirkovasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'slavko','name' => 'Slavko','lastname' => 'Slaviček', 'isAdmin' => '4', 'password' => password_hash('slavkovasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'ana','name' => 'Ana','lastname' => 'Perić', 'isAdmin' => null, 'password' => password_hash('aninasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'maja','name' => 'Maja','lastname' => 'Marić', 'isAdmin' => null, 'password' => password_hash('majinasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'pero','name' => 'Pero','lastname' => 'Perić', 'isAdmin' => null, 'password' => password_hash('perinasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'toni','name' => 'Antonio','lastname' => 'Banderas', 'isAdmin' => '3', 'password' => password_hash('tonijevasifra', PASSWORD_DEFAULT)));
        $st->execute(array('username' => 'vinko','name' => 'Vinko','lastname' => 'De Loris', 'isAdmin' => '2', 'password' => password_hash('vinkovasifra', PASSWORD_DEFAULT)));
    } catch (PDOException $e) {
        exit("PDO error [insert projekt_users]: " . $e->getMessage());
    }

    echo "Ubacio u tablicu projekt_users.<br />";
}

function seed_table_hotels()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare("INSERT INTO projekt_hotels(name, city, distance_from_city_centre, price, rating) VALUES (:name, :city, :distance_from_city_centre, :price, :rating)");

        $st->execute(array('name' => 'Snowy Hill', "city" => "Berlin", "distance_from_city_centre" => 1, "price" => 666, "rating" => 0.00));
        $st->execute(array('name' => 'Primal Maple Resort ', "city" => "Berlin", "distance_from_city_centre" => 2, "price" => 111, "rating" => 0.00));
        $st->execute(array('name' => 'Western Arc Hotel', "city" => "Berlin", "distance_from_city_centre" => 3, "price" => 222, "rating" => 0.00));
        $st->execute(array('name' => 'Elite Courtyard Hotel ', "city" => "Berlin", "distance_from_city_centre" => 4, "price" => 333, "rating" => 0.00));
        $st->execute(array('name' => 'Historic Rainbow Motel', "city" => "Berlin", "distance_from_city_centre" => 5, "price" => 444, "rating" => 0.00));
        $st->execute(array('name' => 'Quiet Vista Hotel ', "city" => "Berlin", "distance_from_city_centre" => 1.5, "price" => 555, "rating" => 0.00));
        $st->execute(array('name' => 'Imperial Motel', "city" => "Berlin", "distance_from_city_centre" => 1.55, "price" => 777, "rating" => 0.00));
        $st->execute(array('name' => 'Oceanview Hotel ', "city" => "Amsterdam", "distance_from_city_centre" => 4.4, "price" => 888, "rating" => 0.00));
        $st->execute(array('name' => 'Breakwater Hotel ', "city" => "Amsterdam", "distance_from_city_centre" => 4.2, "price" => 999, "rating" => 0.00));
        $st->execute(array('name' => 'Oceanside Resort ', "city" => "Amsterdam", "distance_from_city_centre" => 2.4, "price" => 1111, "rating" => 0.00));
    } catch (PDOException $e) {
        exit("PDO error [projekt_hotels]: " . $e->getMessage());
    }

    echo "Ubacio u tablicu projekt_hotels.<br />";
}

function seed_table_rooms()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO projekt_rooms(id_hotel, num_of_rooms, capacity, room_type, price) VALUES (:id_hotel, :num_of_rooms, :capacity, :room_type, :price)');

        $st->execute(array('id_hotel' => 1, 'num_of_rooms' => 1, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 1999));
        $st->execute(array('id_hotel' => 2, 'num_of_rooms' => 5, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 2999));
        $st->execute(array('id_hotel' => 3, 'num_of_rooms' => 2, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 3999));
        $st->execute(array('id_hotel' => 4, 'num_of_rooms' => 3, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 4999));
        $st->execute(array('id_hotel' => 5, 'num_of_rooms' => 6, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 5999));
        $st->execute(array('id_hotel' => 6, 'num_of_rooms' => 1, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 6999));
        $st->execute(array('id_hotel' => 7, 'num_of_rooms' => 4, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 7999));
        $st->execute(array('id_hotel' => 8, 'num_of_rooms' => 4, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 8999));
        $st->execute(array('id_hotel' => 9, 'num_of_rooms' => 2, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 9999));
        $st->execute(array('id_hotel' => 10,'num_of_rooms' => 1, 'capacity' => 6, 'room_type' => 'presidential suite', 'price' => 10999));
//        $st->execute(array('id_hotel' => 1,'num_of_rooms' => 50, 'capacity' => 1, 'room_type' => 'single', 'price' => 19));
        $st->execute(array('id_hotel' => 2,'num_of_rooms' => 50, 'capacity' => 1, 'room_type' => 'single', 'price' => 29));
        $st->execute(array('id_hotel' => 3,'num_of_rooms' => 20, 'capacity' => 1, 'room_type' => 'single', 'price' => 39));
        $st->execute(array('id_hotel' => 4,'num_of_rooms' => 30, 'capacity' => 1, 'room_type' => 'single', 'price' => 49));
        $st->execute(array('id_hotel' => 5,'num_of_rooms' => 60, 'capacity' => 1, 'room_type' => 'single', 'price' => 59));
        $st->execute(array('id_hotel' => 6,'num_of_rooms' => 10, 'capacity' => 1, 'room_type' => 'single', 'price' => 69));
        $st->execute(array('id_hotel' => 7,'num_of_rooms' => 40, 'capacity' => 1, 'room_type' => 'single', 'price' => 79));
        $st->execute(array('id_hotel' => 8,'num_of_rooms' => 40, 'capacity' => 1, 'room_type' => 'single', 'price' => 89));
        $st->execute(array('id_hotel' => 9,'num_of_rooms' => 20, 'capacity' => 1, 'room_type' => 'single', 'price' => 99));
        $st->execute(array('id_hotel'=> 10,'num_of_rooms' => 10, 'capacity' => 1, 'room_type' => 'single', 'price' => 109));

    } catch (PDOException $e) {
        exit("PDO error [projekt_rooms]: " . $e->getMessage());
    }

    echo "Ubacio u tablicu projekt_rooms.<br />";
}

function seed_table_bookings()
{
    $db = DB::getConnection();

    try {
        $st = $db->prepare('INSERT INTO projekt_bookings(id_user, id_hotel, room_id, from_date, to_date) VALUES (:id_user, :id_hotel, :room_id, :from_date, :to_date)');
        $st->execute(array('id_user' => 1, 'id_hotel' => 1, 'room_id' => 11, 'from_date' => "2000-01-01", 'to_date' => "2000-01-07" ));
        $st->execute(array('id_user' => 2, 'id_hotel' => 1, 'room_id' => 11, 'from_date' => "2000-01-01", 'to_date' => "2000-06-07" ));
        $st->execute(array('id_user' => 3, 'id_hotel' => 1, 'room_id' => 11, 'from_date' => "2000-11-21", 'to_date' => "2000-12-01" ));
        $st->execute(array('id_user' => 4, 'id_hotel' => 1, 'room_id' => 11, 'from_date' => "2000-01-31", 'to_date' => "2000-02-15" ));
        $st->execute(array('id_user' => 5, 'id_hotel' => 1, 'room_id' => 11, 'from_date' => "2001-01-01", 'to_date' => "2001-12-31" ));
        $st->execute(array('id_user' => 6, 'id_hotel' => 1, 'room_id' => 1, 'from_date' => "2002-01-04", 'to_date' => "2002-01-07" ));
        $st->execute(array('id_user' => 7, 'id_hotel' => 1, 'room_id' => 11, 'from_date' => "2020-01-01", 'to_date' => "2020-01-02" ));
        $st->execute(array('id_user' => 4, 'id_hotel' => 1, 'room_id' => 1, 'from_date' => "2020-12-25", 'to_date' => "2021-01-02" ));
        $st->execute(array('id_user' => 3, 'id_hotel' => 1, 'room_id' => 11, 'from_date' => "2030-01-01", 'to_date' => "2030-03-03" ));
        $st->execute(array('id_user' => 1, 'id_hotel' => 2, 'room_id' => 12, 'from_date' => "2000-01-01", 'to_date' => "2000-11-17" ));
        $st->execute(array('id_user' => 5, 'id_hotel' => 2, 'room_id' => 12, 'from_date' => "2000-01-01", 'to_date' => "2001-01-07" ));
        $st->execute(array('id_user' => 2, 'id_hotel' => 2, 'room_id' => 2, 'from_date' => "2005-07-10", 'to_date' => "2006-01-01" ));
        $st->execute(array('id_user' => 1, 'id_hotel' => 3, 'room_id' => 13, 'from_date' => "2030-01-01", 'to_date' => "2030-01-17" ));
        $st->execute(array('id_user' => 4, 'id_hotel' => 3, 'room_id' => 3, 'from_date' => "2030-02-01", 'to_date' => "2030-02-20" ));
        $st->execute(array('id_user' => 2, 'id_hotel' => 3, 'room_id' => 3, 'from_date' => "2030-01-11", 'to_date' => "2030-11-01" ));
        $st->execute(array('id_user' => 5, 'id_hotel' => 3, 'room_id' => 3, 'from_date' => "2030-01-13", 'to_date' => "2030-02-14" ));
    } catch (PDOException $e) {
        exit("PDO error [projekt_bookings]: " . $e->getMessage());
    }

    echo "Ubacio u tablicu projekt_bookings.<br />";
}


