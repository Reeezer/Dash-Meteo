<?php

$router->define([
  // '' => 'controllers/index.php',  // by conventions all controllers are in 'controllers' folder
  '' => 'IndexController',
  'home' => 'IndexController',
  'test_notification' => 'IndexController@testNotification',
  
  'search' => 'SearchController@showResults',

  'add_favourite' => 'UserController@addFavourite',
  'remove_favourite' => "UserController@removeLocalityFromFavourite",

  'login' => 'LoginController@showLogin',
  'do_login' => 'LoginController@doLogin',
  'do_logout' => 'LoginController@doLogout',
  'signup' => 'LoginController@showSignup',
  'do_signup' => 'LoginController@doSignup'
]);
