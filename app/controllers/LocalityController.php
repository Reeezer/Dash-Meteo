<?php

require_once "core/DatabaseManager.php";
require_once "app/models/Locality.php";

class LocalityController
{
    
    // since the locality name is used to redirect the user to the meteo display page, we consider that if the locality name
    // and user_id match in the localities database, then the locality has been favourited by the user.
    static function checkFavouriteByName($user_id, $locality_name)
    {
        $localities = Locality::fetchLocality(DatabaseManager::$dbh, $user_id, $locality_name);
    
        // $localities is false when there are no results, else we get a Locality object, this way !! returns a boolean no matter the value, objects are truthy in php
        return !!$localities;
    }
}