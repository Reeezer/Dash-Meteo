<?php

class Router
{
  protected $routes = [];

  public function define($routes)
  {
    $this->routes = $routes;
  }

  public function direct($uri)
  {
    $uri = parse_url($uri)["path"];

    // chapitre 5 question 10
    //echo "avant: " . $uri . "<br>";

    // remove installation prefix
    if (isset(App::get('config')['install_prefix'])) {
      if (strncmp($uri, App::get('config')['install_prefix'], strlen(App::get('config')['install_prefix'])) == 0) {
        if (!($uri = substr($uri, strlen(App::get('config')['install_prefix']) + 1)))
          $uri = "";
      }
    }

    // chapitre 5 question 10
    //echo "après: " . $uri;

    if (array_key_exists($uri, $this->routes))
      return $this->callAction(...explode('@', $this->routes[$uri]));
    throw new Exception("Not routes defined for this URI.", 1);
  }

  // call a specific action (method) of a controller
  // if not action is specified, the action index() is called by default
  protected function callAction($controller, $action = 'index')
  {
    require_once("app/controllers/" . $controller . ".php");
    $control = new $controller;

    if (!method_exists($control, $action))
      throw new Exception("$controller does not respond to the action $action.");
    return $control->$action();
  }

  public static function load($file)
  {
    $router = new static;
    require 'app/' . $file;
    return $router;
  }
}
