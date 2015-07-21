<?php

use valute\ValuteDynamic;
use valute\CBDataSource;
use valute\PassThruDataParser;

// include('../valute/CBDataSource.php');
// include('../valute/JSONDataParser.php');
// include('../valute/ValuteDynamic.php');
ini_set('display_errors',1);
error_reporting(E_ALL);

// spl_autoload_register('autoloader');
// require __DIR__ . '/../valute/ValuteDynamic.php';
// require __DIR__ . '/../valute/CBDataSource.php';
// require __DIR__ . '/../valute/JSONDataParser.php';

class ValuteDynamicTest extends PHPUnit_Framework_TestCase{

  protected $valute;

  protected function setUp() {
    $this->valute = new ValuteDynamic();
    $this->valute->setSource(new CBDataSource('R01235'));
    $this->valute->setOutput(new PassThruDataParser());
  }

  public function testInit() {
    $this->assertInstanceOf('valute\ValuteDynamic', $this->valute);
  }
  /** @test */
  public function it_should_work_with_today() {
    $resultArray = $this->valute->getCourse('today');
    $dateToday = new \DateTime();
    $todayString = $dateToday->format('d/m/Y');

    $this->assertCount(1, $resultArray, 'Can be only one result obj in array');

    // $this->assertInstanceOf('stdClass', $resultArray[0]);

    $this->assertSame($todayString, $resultArray[0]['date'], 'Dates should be equal!');

    $this->assertNotNull($todayString, $resultArray[0]['value'], 'Valute value cant be NULL');
  }
  /** @test */
  public function it_should_work_with_random_range() {
    $range = ['10/07/2015', '20/07/2015'];
    $resultArray = $this->valute->getCourse($range);

    $this->assertCount(11, $resultArray, 'Should be 11 result objects in array');
    // $this->assertInstanceOf('stdClass', $resultArray[0]);
    $this->assertSame($range[0], $resultArray[0]['date'], 'First dates should be equal!');
    $this->assertSame($range[1], $resultArray[10]['date'], 'Last dates should be equal!');
    foreach ($resultArray as $key => $value) {
       $this->assertNotNull($value['value']);
    }
  }
}