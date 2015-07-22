<?php
use valute\ValuteDynamic;
use valute\CBDataSource;
use valute\PassThruDataParser;

ini_set('display_errors',1);
error_reporting(E_ALL);

$loader = require __DIR__ . '/vendor/autoload.php';

$dollarCode = 'R01235';
$euroCode = 'R01239';

$usdDynamic = new ValuteDynamic();
$usdSource = new CBDataSource('R01235');

$usdDynamic->setSource($usdSource);
$usdDynamic->setOutput(new PassThruDataParser());

$dataRange = ['28/06/2015','09/07/2015'];

echo "<pre>";

$result = $usdDynamic->getCourse('3months');
var_dump($result);
echo "</pre>";
