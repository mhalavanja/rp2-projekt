<?php
require_once "../service/CityService.php";

function sendJSONandExit($message)
{
    header('Content-type:application/json;charset=utf-8');
    echo json_encode($message);
    flush();
    exit(0);
}

sendJSONandExit(CityService::getAllCities());

