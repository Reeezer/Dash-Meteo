<?php

require 'core/bootstrap.php';

$uri = Request::uri();
$router = Router::load('routes.php');

try
{
    $router->direct($uri);
}
catch (exception $e)
{
    header("HTTP/1.0 404 Not Found");
    echo "ERROR 404: " . $e->getMessage();
}
