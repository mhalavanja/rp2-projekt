<?php
require_once '../app/database/db.class.php';
require_once '../util/propToModel.php';

class CityService
{
    static function getAllCities()
    {
        $db = DB::getConnection();
        try {
            $st = $db->prepare("SELECT DISTINCT city FROM projekt_hotels;");
            $st->execute(array());
            $ret = [];
            foreach ($st->fetchAll() as $row){
                $ret[] = $row["city"];
            }
            return($ret);
        } catch (PDOException $e) {
            exit("PDO error [SELECT DISTINCT city FROM projekt_hotels]: " . $e->getMessage());
        }
    }
}