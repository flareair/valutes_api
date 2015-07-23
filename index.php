<?php

use valute\Api;

define('DEBUG', true);
error_reporting(E_ALL | E_STRICT );

if (DEBUG) {
  ini_set('display_errors',1);
  ini_set("log_errors", 0);
} else {
  ini_set('display_errors',0);
  ini_set("log_errors", 1);
  ini_set("error_log", "./log/php_error.log");
}


$loader = require __DIR__ . '/vendor/autoload.php';

$api = new Api();

$api->route($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_GET);
