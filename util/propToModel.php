<?php
function propToModel($st, $class)
{
    $arr = [];
    foreach ($st->fetchAll() as $row) {
        $obj = new $class;
        foreach ($class::getColumns() as $key => $val) {
            $setProperty = "set" . ucfirst($key);
            $obj->$setProperty($row[$key]);
        }
        $arr[] = $obj;
    }
    return $arr;
}
