<?php

require_once "app/models/Model.php";

class User extends Model
{
	static protected $CLASS_NAME = "User";

	private $id = -1;
	private $lang = "EN";
	private $units = "C";
	private $email = "default@default.com";
	private $password = "";

	public function set($lang, $units, $email, $password)
	{
		$this->lang = $lang;
		$this->units = $units;
		$this->email = $email;
		$this->password = $password;
	}

	public function passhash()
	{
		return $this->password;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getID()
	{
		return $this->id;
	}

	public static function fetchUser($dbh, $email)
	{
		return static::fetch($dbh, "SELECT * FROM users WHERE email = :email", array('email' => $email));
	}

	// ne supporte pas l'édition, ça insère un nouvel utilisateur à chaque fois
	public function save($dbh)
    {
        $query = $dbh->prepare("INSERT INTO users (lang, units, email, password) VALUES (:lang,:units,:email,:password)");
		$query->execute(array(
			':lang' => $this->lang,
			':units' => $this->units,
			':email' => $this->email,
			':password' => $this->password
		));

		// get the id of the user we just inserted so that we can directly use the User object as a session token
		$this->id = $dbh->lastInsertId();
	}
}