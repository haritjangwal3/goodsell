<?php 
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'helpers.php');

function currentLocation(){
    $location = [];
    $user_ip = getenv('REMOTE_ADDR');
    $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
    $location['country'] = $geo["geoplugin_countryName"];
    $location['city'] = $geo["geoplugin_city"];

    return $location;
}

