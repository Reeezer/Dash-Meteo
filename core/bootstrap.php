<?php

require_once 'core/Router.php';
require_once 'core/Request.php';
require_once 'core/App.php';
require_once 'helpers/Helper.php';
require_once 'core/Logger.php';
require_once 'core/DatabaseManager.php';

/* session */
session_start();

/* config */
App::load_config('config.php');

/* internal modules */
Logger::setup_log();
DataBaseManager::setup_database();
