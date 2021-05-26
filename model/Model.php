<?php
require_once __SITE_PATH . '/app/database/db.class.php';

spl_autoload_register(function ($class_name) {
    $fileName = __DIR__ . '/' . $class_name . '.php';
    if (file_exists($fileName) === false)
        return false;
    require_once $fileName;
    return true;
});

abstract class Model
{
    // Zadatak (srednje-dosta težak.)
// Ovo je samo kostur apstraktne klase Model.
// Trebate sami napisati implementaciju svih funkcija tako da rade kao što je opisano.
// Uputa: trebat ćete koristiti funkcije poput get_called_class(), kao i stvari poput $obj = new $className();
//
// Pogledajte i moguće dodatne funkcije i relacije ovdje:
// https://laravel.com/docs/master/eloquent
// https://laravel.com/docs/master/eloquent-relationships

    // Tablica u bazi podataka pridružena modelu. Svaka izvedena klase će definirati svoju.
    protected static $table = null;

    // Asocijativno polje $columns:
    // - ključevi = imena stupaca u bazi podataka u tablici $table;
    // - svakom ključu je pridružena vrijednost koja u bazi piše za objekt $this (onaj čiji je id jedak $this->id).
    protected static $columns = [];

    public function __get($col)
    {
        // Omogućava da umjesto $this->columns['name'] pišemo $this->name.
        // (uoči: $this->columns može ostati protected!)
        if (isset($this->columns[$col]))
            return $this->columns[$col];

        return null;
    }

    public function __set($col, $value)
    {
        // Omogućava da umjesto $this->columns['name']='Mirko' pišemo $this->name='Mirko'.
        // (uoči: $this->columns može ostati protected!)
        $this->columns[$col] = $value;

        return $this;
    }

    public static function setColumns()
    {
        $db = DB::getConnection();
        try {
            $st = $db->prepare("DESCRIBE " . static::$table . ";");
            $st->execute();
        } catch (PDOException $e) {
            exit("PDO error [describe " . static::$table . "]: " . $e->getMessage());
        }
        foreach ($st->fetchAll() as $row) {
            static::$columns[$row["Field"]] = $row["Type"];
        }
    }

    public static function all()
    {
        $db = DB::getConnection();
        try {
            $st = $db->prepare("SELECT * FROM " . static::$table . ";");
            $st->execute();
        } catch (PDOException $e) {
            exit("PDO error [select " . static::$table . "]: " . $e->getMessage());
        }
        $arr = [];
        foreach ($st->fetchAll() as $row) {
            $obj = new get_called_class();
            foreach (static::$columns as $key => $val) {
                $setProperty = "set" . ucfirst($key);
                $obj->$setProperty($row);
            }
            $arr[] = $obj;
        }
        return $arr;
    }

    public static function where($col, $val)
    {
        $db = DB::getConnection();
        try {
            $sql = "SELECT * FROM " . static::$table . " WHERE " . $col . " = :val;";
            $st = $db->prepare($sql);
            $st->execute(array(":val" => $val));
        } catch (PDOException $e) {
            exit("PDO error [select " . static::$table . "]: " . $e->getMessage());
        }
//        echo "<pre>";
//        $st->debugDumpParams();
//        echo "<pre>";
        $arr = [];
        foreach ($st->fetchAll() as $row) {
            $class = get_called_class();
            $obj = new $class;
            foreach (static::$columns as $key => $val) {
                $setProperty = "set" . ucfirst($key);
                $obj->$setProperty($row[$key]);
            }
            $arr[] = $obj;
        }
        return $arr;
    }

    public static function like($col, $val)
    {
        $db = DB::getConnection();
        try {
            $sql = "SELECT * FROM " . static::$table . " WHERE " . $col . " LIKE :val;";
            $st = $db->prepare($sql);
            $st->execute(array(":val" => $val));
        } catch (PDOException $e) {
            exit("PDO error [select " . static::$table . "]: " . $e->getMessage());
        }
//        echo "<pre>";
//        $st->debugDumpParams();
//        echo "<pre>";
        $arr = [];
        foreach ($st->fetchAll() as $row) {
            $class = get_called_class();
            $obj = new $class;
            foreach (static::$columns as $key => $val) {
                $setProperty = "set" . ucfirst($key);
                $obj->$setProperty($row[$key]);
            }
            $arr[] = $obj;
        }
        return $arr;
    }

    public static function find($idVal)
    {
        $db = DB::getConnection();
        try {
            $st = $db->prepare("SELECT * FROM " . static::$table . "  WHERE id = :idVal;");
            $st->execute(array("idVal" => $idVal));
        } catch (PDOException $e) {
            exit("PDO error [select " . static::$table . "]: " . $e->getMessage());
        }

        $row = $st->fetch();
        $class = get_called_class();
        $obj = new $class;
        foreach (static::$columns as $key => $val) {
            $setProperty = "set" . ucfirst($key);
            $obj->$setProperty($row[$key]);
        }
//        echo "<pre>";
//        var_dump(static::$columns);
//        echo "<pre>";
        return $obj;
    }

    public function save($obj)
    {
        // TODO
        // Funkcija sprema novi ili ažurira postojeći redak u tablici $table koji pripada objektu $this.
        // ($this->id je ključ u tablici $table).
        $sql = "REPLACE INTO " . static::$table . "(";
        $values = "VALUES(";
        foreach (static::$columns as $key => $val) {
            $getProperty = "get" . ucfirst($key);
            $property = $obj->$getProperty();
            if ($property === null) continue;
            $sql .= ($key . ",");
            $values .= ("'" . $property . "',");
        }
        $sql = rtrim($sql, ',') . ")";
        $values = rtrim($values, ',') . ")";
        $sql .= $values;
        echo $sql;
        $db = DB::getConnection();
        try {
            $st = $db->prepare($sql);
            $st->execute();
        } catch (PDOException $e) {
            exit("PDO error [REPLACE " . static::$table . "]: " . $e->getMessage());
        }
        return true;
    }
}