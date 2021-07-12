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

    public static function all(): array
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
            $class = get_called_class();
            $obj = new $class;
            foreach (static::$columns as $key => $val) {
                $setProperty = "set" . ucfirst($key);
                $obj->$setProperty($row);
            }
            $arr[] = $obj;
        }
        return $arr;
    }

    public static function where($col, $val): array
    {
        $db = DB::getConnection();
        try {
            if(!is_array($col) and !is_array($val)){
                $sql = "SELECT * FROM " . static::$table . " WHERE " . $col . " = :val;";
                $st = $db->prepare($sql);
                $st->execute(array(":val" => $val));
            }
            else if(is_array($col) and is_array($val) and sizeof($col) === sizeof($val)){
                $len = sizeof($col);
                if ($len === 1){
                    $col = $col[0];
                    $val = $val[0];
                    $sql = "SELECT * FROM " . static::$table . " WHERE " . $col . " = :val;";
                    $st = $db->prepare($sql);
                    $st->execute(array(":val" => $val));
                }
                else{
                    $sql = "SELECT * FROM " . static::$table . " WHERE ";
                    $values = [];
                    for ($i = 0; $i < $len; $i++){
                        $curVal = ":val" . $i;
                        $sql .= ($col[$i] . " = " . $curVal );
                        $values[$curVal] = $val[$i];
                        if($i < $len-1) $sql.= " ADD ";
                    }
                    $st = $db->prepare($sql);
                    $st->execute($values);
                }
            }
        } catch (PDOException $e) {
            exit("PDO error [select " . static::$table . "]: " . $e->getMessage());
        }

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

    public static function like($col, $val): array
    {
        $db = DB::getConnection();
        try {
            $sql = "SELECT * FROM " . static::$table . " WHERE " . $col . " LIKE :val;";
            $st = $db->prepare($sql);
            $st->execute(array(":val" => $val));
        } catch (PDOException $e) {
            exit("PDO error [select " . static::$table . "]: " . $e->getMessage());
        }

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
//        print_r($st);
        foreach (static::$columns as $key => $val) {
            $setProperty = "set" . ucfirst($key);
//            echo "<pre>";
//            print_r($obj);
//            echo "<br>";
//            $st->debugDumpParams();
//            echo "<br>";
//            print_r($row);
//            echo "<br>";
//            print_r($setProperty);
//            echo "<br>";
//            print_r($key);
//            echo "<br>";
//            echo "<pre>";
//            exit();
            $obj->$setProperty($row[$key]);
        }

        return $obj;
    }

    public static function save($obj): bool
    {
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
        $db = DB::getConnection();
        try {
            $st = $db->prepare($sql);
            $st->execute();
        } catch (PDOException $e) {
            echo "<pre>";
            $st->debugDumpParams();
            echo "<pre>";
            exit("PDO error [REPLACE " . static::$table . "]: " . $e->getMessage());
        }
        return true;
    }

    public static function delete($col, $val): bool
    {
        $db = DB::getConnection();
        try {
            $sql = "DELETE FROM " . static::$table . " WHERE " . $col . " = :val;";
            echo "<script>console.log(' " . $sql . "' );</script>";
            $st = $db->prepare($sql);
            $st->execute(array(":val" => $val));
        } catch (PDOException $e) {
            exit("PDO error [DELETE " . static::$table . "]: " . $e->getMessage());
        }
        return 1;
    }
}