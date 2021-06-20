<?php

require_once "app/models/Model.php";

class Locality extends Model
{
    static protected $CLASS_NAME = "Locality";

    private $user_id = -1;
    private $lat = 0.0;
    private $lon = 0.0;
    private $name = "Null Island";
    private $country = "Null";

    public function set($user_id, $lat, $lon, $name, $country)
    {
        $this->user_id = $user_id;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->name = $name;
        $this->country = $country;
    }

    public function getLon()
    {
        return $this->lon;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public static function fetchLocalities($dbh, $user_id)
	{
		return static::fetchAll($dbh, "SELECT * FROM localities WHERE user_id=:user_id", array(':user_id' => $user_id));
	}

    public static function fetchLocality($dbh, $user_id, $name)
    {
        return static::fetch($dbh, "SELECT * FROM localities WHERE user_id=:user_id AND name=:name", array(
            ':user_id' => $user_id,
            ':name' => $name
        ));
    }

    public static function deleteLocality($dbh, $user_id, $name)
    {
        $query_statement = $dbh->prepare("DELETE FROM localities WHERE user_id=:user_id AND name=:name");
        $query_statement->execute(array(
            ':user_id' => $user_id,
            ':name' => $name
        ));

        return $query_statement->errorInfo();
    }

    public function save($dbh)
    {
        $query = $dbh->prepare("INSERT INTO localities (user_id, lat, lon, name, country) VALUES (:user_id, :lat, :lon, :name, :country)");
       
        $query->execute(array(
            ':user_id' => $this->user_id,
            ':lat' => $this->lat,
            ':lon' => $this->lon,
            ':name' => $this->name,
            ':country' => $this->country
        ));

        return $query->errorInfo();
    }
}