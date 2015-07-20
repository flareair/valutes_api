<?php

namespace valute;

require 'interfaces/DataSource.php';

use interfaces\DataSource;

class CBDataSource implements DataSource {
  private $apiURI = 'http://www.cbr.ru/scripts/XML_dynamic.asp';
  private $valuteCode;

  public function __construct($valuteCode) {
    $this->valuteCode = $valuteCode;
  }

  public function getInRange(array $range) {
    $fixedRange = $this->fixDateRange($range);
    $formedURL = sprintf('%s?date_req1=%s&date_req2=%s&VAL_NM_RQ=%s', $this->apiURI, $fixedRange[0], $fixedRange[1], $this->valuteCode);
    $xml = new \SimpleXMLElement($formedURL, null, true);
    if ($xml === false) {
      return false;
    }
    // var_dump($xml);
    return $this->serializeXML($xml);
  }

  private function serializeXML(\SimpleXMLElement $xml) {
    foreach ($xml->children() as $child) {
      $result[] = array(
        'date' => $child['Date']->__toString(),
        'nominal' => $child->Nominal->__toString(),
        'value' => $child->Value->__toString()
      );
    }
    return $result;
  }
  private function fixDateRange(array $range) {
    $format = 'd/m/Y';
    foreach ($range as $key => &$date) {
      $dateObj = \DateTime::createFromFormat("d/m/Y", $date);
      if ($dateObj->format('D') === 'Sun') {
        $dateObj->modify('-1 day');
      }
      if ($dateObj->format('D') === 'Mon') {
        $dateObj->modify('-2 day');
      }
      // var_dump($dateObj->format('D'));
      $date = $dateObj->format($format);
    }
    return $range;
  }
}