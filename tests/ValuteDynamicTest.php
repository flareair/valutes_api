<?php

use valute\ValuteDynamic;
use valute\CBDataSource;
use valute\JSONDataParser;

// include('../valute/CBDataSource.php');
// include('../valute/JSONDataParser.php');
// include('../valute/ValuteDynamic.php');
ini_set('display_errors',1);
error_reporting(E_ALL);

require __DIR__ . '/../valute/ValuteDynamic.php';
require __DIR__ . '/../valute/CBDataSource.php';
require __DIR__ . '/../valute/JSONDataParser.php';

class ValuteDynamicTest extends PHPUnit_Framework_TestCase{

  protected $valute;

  protected function setUp() {
    $this->valute = new ValuteDynamic();
    $this->valute->setSource(new CBDataSource('R01235'));
    $this->valute->setOutput(new JSONDataParser());
  }

  public function testInit() {
    $this->assertInstanceOf('valute\ValuteDynamic', $this->valute);
  }
}