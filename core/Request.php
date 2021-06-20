<?php

/**
 *
 */
class Request
{
  //Renvoie la destination du fichier
  public static function uri()
  {
    return trim($_SERVER['REQUEST_URI'], '/');
  }

  public static function redirect_notify($location, $type, $message)
  {
      $encoded_args = http_build_query(
          Array(
              "notification_status" => $type,
              "notification" => $message
          )
      );
      header("Location: $location?$encoded_args");
      exit(0);
  }

  public static function redirect($location)
  {
      header("Location: $location");
      exit(0);
  }
}
