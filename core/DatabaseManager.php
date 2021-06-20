<?php

class DatabaseManager
{
    public static $dbh;

    public static function setup_database()
    {
        $dbuser    = App::get('config')['database']['username'];
        $dbpw      = App::get('config')['database']['password'];
        $dbname    = App::get('config')['database']['name'];
        $dbcharset = App::get('config')['database']['charset'];
        $dboptions = App::get('config')['database']['options'];

        self::$dbh = new PDO("mysql:host=localhost;dbname=$dbname;charset=$dbcharset", $dbuser, $dbpw, $dboptions);
    }
}
