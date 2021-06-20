<?php

class Model
{
    static protected $CLASS_NAME;
    
    protected static function fetch($dbh, $query_str, $search_args)
    {
        $query_statement = $dbh->prepare($query_str);
        $query_statement->execute($search_args);
        $query_statement->setFetchMode(PDO::FETCH_CLASS, static::$CLASS_NAME);

        return $query_statement->fetch();
    }

    protected static function fetchAll($dbh, $query_str, $search_args)
    {
        $query_statement = $dbh->prepare($query_str);
        $query_statement->execute($search_args);
        $query_statement->setFetchMode(PDO::FETCH_CLASS, static::$CLASS_NAME);

        return $query_statement->fetchAll();
    }

}