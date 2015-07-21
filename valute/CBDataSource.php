<?php

namespace valute;

use valute\interfaces\DataSource;

class CBDataSource implements DataSource {
  private $apiURI = 'http://www.cbr.ru/scripts/XML_dynamic.asp';
  private $valuteCode;

  public function __construct($valuteCode) {
    $this->valuteCode = $valuteCode;
  }

  public function getInRange(array $range) {

    $fixedRange = $this->fixDateRange($range);
    // var_dump($fixedRange);
    $formedURL = sprintf('%s?date_req1=%s&date_req2=%s&VAL_NM_RQ=%s', $this->apiURI, $fixedRange[0], $fixedRange[1], $this->valuteCode);
    $xml = new \SimpleXMLElement($formedURL, null, true);
    if ($xml === false) {
      return false;
    }
    $rawResults = $this->serializeXML($xml);
    return $this->normalizeResults($rawResults, $range);
  }

  private function normalizeResults(array $results, array $initialRange) {
    $dateFirst = \DateTime::createFromFormat('d/m/Y', $initialRange[0]);
    $dateLast = \DateTime::createFromFormat('d/m/Y', $initialRange[1]);
    $diff = $dateLast->diff($dateFirst);

    $diff = $diff->d;

    if ($diff === 0) {
      $results[0]['date'] = $initialRange[0];
      return $results;
    }
    // if ($diff === count($results)) {
    //   return $results;
    // }

    $i = 0;
    $fixedResults = array();

    while ($i <= $diff) {
      $fixedResults[$i]['date'] = $dateFirst->format('d/m/Y');
      foreach ($results as $key => $chunk) {
        // var_dump($chunk);
        if ($fixedResults[$i]['date'] === $chunk['date']) {
          $fixedResults[$i] = $chunk;
        }
      }
      $dateFirst->modify('+1 day');
      $i++;
    };

    unset($chunk);

    foreach ($fixedResults as $key => &$chunk) {
      if (!isset($chunk['value'])) {
        if (isset($fixedResults[$key - 1]['value'])) {
          $chunk['nominal'] = $fixedResults[$key - 1]['nominal'];
          $chunk['value'] = $fixedResults[$key - 1]['value'];
        }
        else if (isset($results[$key]['value'])) {
          $chunk['nominal'] = $results[$key]['nominal'];
          $chunk['value'] = $results[$key]['value'];
        }
      }
    }
    // var_dump($fixedResults);
    return $fixedResults;
  }

  private function serializeXML(\SimpleXMLElement $xml) {
    foreach ($xml->children() as $child) {
      $result[] = array(
        'date' => str_replace('.', '/', $child['Date']->__toString()),
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
      $date = $dateObj->format($format);
    }
    return $range;
  }
}