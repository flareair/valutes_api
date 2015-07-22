<?php
// use valute\ValuteDynamic;
// use valute\CBDataSource;
// use valute\PassThruDataParser;
use valute\Api;

ini_set('display_errors',1);
error_reporting(E_ALL);

$loader = require __DIR__ . '/vendor/autoload.php';

$api = new Api();

$api->route($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_GET);
