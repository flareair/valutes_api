<?php
use valute\ValuteDynamic;
use valute\CBDataSource;
use valute\JSONDataParser;

ini_set('display_errors',1);
error_reporting(E_ALL);

require '__autoload.php';

$usdDynamic = new ValuteDynamic();
$usdSource = new CBDataSource('R01235');

$usdDynamic->setSource($usdSource);
$usdDynamic->setOutput(new JSONDataParser());

$dataRange = ['10/07/2015','20/07/2015'];
// echo $usdDynamic->checkDateRange($dataRange);

// header('Content-type: application/json');
echo $usdDynamic->getCourse($dataRange);
// echo $usdDynamic->getCourse('today');