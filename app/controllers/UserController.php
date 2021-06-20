<?php

require_once "core/DatabaseManager.php";

require_once "app/controllers/Controller.php";
require_once "app/models/User.php";
require_once "app/models/Locality.php";

class UserController extends Controller
{
    
    public function addFavourite()
    {
        $user_id = urldecode($_GET['user_id'] ?? -1);
        $lat = urldecode($_GET['lat'] ?? 0.0);
        $lon = urldecode($_GET['lon'] ?? 0.0);
        $name = urldecode($_GET['name'] ?? "Null Island");
        $country = urldecode($_GET['country'] ?? "Null");


        $locality = new Locality();
        $locality->set($user_id, $lat, $lon, $name, $country);
        $locality->save(DatabaseManager::$dbh);
    }

    static function removeLocalityFromFavourite()
    {
        $user_id = urldecode($_GET['user_id'] ?? -1);
        $name = urldecode($_GET['name'] ?? "Null Island");

        Locality::deleteLocality(DatabaseManager::$dbh, $user_id, $name);
    }
}