<?php


require_once __DIR__ . '/db.class.php';

create_table_users();
create_table_products();
create_table_sales();

exit( 0 );

// --------------------------
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

    if( has_table( 'dz2_users' ) )
        exit( 'Tablica dz2_users vec postoji. Obrisite ju pa probajte ponovno.' );

    try
    {
        $st = $db->prepare(
            'CREATE TABLE IF NOT EXISTS dz2_users (' .
            'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'username varchar(50) NOT NULL,' .
            'password_hash varchar(255) NOT NULL,'.
            'email varchar(50) NOT NULL,' .
            'registration_sequence varchar(20) NOT NULL,' .
            'has_registered int)'
        );

        $st->execute();
    }
    catch( PDOException $e ) { exit( "PDO error [create dz2_users]: " . $e->getMessage() ); }

    echo "Napravio tablicu dz2_users.<br />";
}


function create_table_products()
{
    $db = DB::getConnection();

    if( has_table( 'dz2_products' ) )
        exit( 'Tablica dz2_products vec postoji. Obrisite ju pa probajte ponovno.' );

    try
    {
        $st = $db->prepare(
            'CREATE TABLE IF NOT EXISTS dz2_products (' .
            'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'id_user int NOT NULL,' .
            'name varchar(100) NOT NULL,' .
            'description varchar(1000) NOT NULL,' .
            'price decimal(15,2) NOT NULL)'
        );

        $st->execute();
    }
    catch( PDOException $e ) { exit( "PDO error [create dz2_products]: " . $e->getMessage() ); }

    echo "Napravio tablicu dz2_products.<br />";
}


function create_table_sales()
{
    $db = DB::getConnection();

    if( has_table( 'dz2_sales' ) )
        exit( 'Tablica dz2_sales vec postoji. Obrisite ju pa probajte ponovno.' );

    try
    {
        $st = $db->prepare(
            'CREATE TABLE IF NOT EXISTS dz2_sales (' .
            'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
            'id_product INT NOT NULL,' .
            'id_user INT NOT NULL,' .
            'rating INT,' .
            'comment varchar(1000))'
        );

        $st->execute();
    }
    catch( PDOException $e ) { exit( "PDO error [create dz2_sales]: " . $e->getMessage() ); }

    echo "Napravio tablicu dz2_sales.<br />";
}