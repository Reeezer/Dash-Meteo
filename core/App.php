<?php

require_once "core/App.php";

class App
{
    public static function get($key)
    {
        return self::$app[$key];
    }

    public static function set($key, $value)
    {
        self::$app[$key] = $value;
    }

    public static function load_config($name)
    {
        self::$app['config'] = require($name);
    }

    private static $app = [];
}
