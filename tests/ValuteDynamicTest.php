<?php

use valute\ValuteDynamic;
use valute\sources\CbDataSource;
use valute\parsers\SimpleDataParser;


ini_set('display_errors',1);
error_reporting(E_ALL);


class ValuteDynamicTest extends PHPUnit_Framework_TestCase{

  protected $valute;

  protected function setUp() {
    $this->valute = new ValuteDynamic();
    $this->valute->setSource(new CBDataSource('usd'));
    $this->valute->setOutput(new SimpleDataParser());
  }

  public function it_should_create_valuete_class() {
    $this->assertInstanceOf('valute\ValuteDynamic', $this->valute);
  }
  /** @test */
  public function it_should_work_with_today_date() {
    $resultArray = $this->valute->getCourse('today');
    $dateToday = new \DateTime();
    $todayString = $dateToday->format('d/m/Y');

    $this->assertCount(1, $resultArray, 'Can be only one result obj in array');

    $this->assertSame($todayString, $resultArray[0]['date'], 'Dates should be equal!');

    $this->assertNotNull($todayString, $resultArray[0]['value'], 'Valute value cant be NULL');
  }

  /** @test */
  public function it_should_work_with_3_months_range() {
    $resultArray = $this->valute->getCourse('3 months');
    $dateToday = new \DateTime();
    $date3months = new \DateTime('-3 month');
    // $range = 
  }

  /** @test */
  public function it_should_work_with_random_range() {
    $range = ['10/07/2015', '20/07/2015'];
    $resultArray = $this->valute->getCourse($range);

    $this->assertCount(11, $resultArray, 'Should be 11 result objects in array');
    $this->assertSame($range[0], $resultArray[0]['date'], 'First dates should be equal!');
    $this->assertSame($range[1], $resultArray[10]['date'], 'Last dates should be equal!');
    foreach ($resultArray as $key => $value) {
       $this->assertNotNull($value['value']);
    }
  }
}