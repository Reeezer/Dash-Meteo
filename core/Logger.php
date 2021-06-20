<?php

require_once "core/App.php";

class Logger
{
    static private $logfilepath;

    public static function setup_log()
    {
        Logger::$logfilepath = App::get('config')['log_path'];
    }

    private static function log($type, $message)
    {
        $fp = fopen(Logger::$logfilepath, 'a');
        fwrite($fp, "[$type] " . date('Y-m-d H:i:s') . " $message\n");
    }

    public static function info($message)
    {
        Logger::log("info", $message);
    }

    public static function warning($message)
    {
        Logger::log("warning", $message);
    }

    public static function error($message)
    {
        Logger::log("error", $message);
    }
}
