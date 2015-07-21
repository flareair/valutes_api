<?php
use valute\ValuteDynamic;
use valute\CBDataSource;
use valute\PassThruDataParser;

ini_set('display_errors',1);
error_reporting(E_ALL);

$loader = require __DIR__ . '/vendor/autoload.php';

$usdDynamic = new ValuteDynamic();
$usdSource = new CBDataSource('R01235');

$usdDynamic->setSource($usdSource);
$usdDynamic->setOutput(new PassThruDataParser());

$dataRange = ['10/07/2015','20/07/2015'];

echo "<pre>";
$result = $usdDynamic->getCourse('today');
var_dump($result);
$result = $usdDynamic->getCourse($dataRange);
var_dump($result);
echo "</pre>";
