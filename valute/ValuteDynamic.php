<?php

namespace valute;

class ValuteDynamic {
  private $valuteCode;
  private $savedRanges = ['today', 'week', 'month', '3 months', 'halfyear', 'year'];
  private $datePattern = '/^\d{2}\/\d{2}\/\d{4}$/';
  private $dataSource;
  private $parser;

  public function __construct() {
  }

  public function getCourse($dateRange) {

    if (!isset($dateRange) || empty($dateRange)) {
      return false;
    }

    if (is_string($dateRange) && in_array($dateRange, $this->savedRanges)) {
      $newRange = $this->presavedToRange($dateRange);
      $result = $this->dataSource->getInRange($newRange);
      return $this->parser->parse($result);
    }
    elseif (is_array($dateRange) && count($dateRange) === 2 && $this->checkDateRange($dateRange)) {

      $result = $this->dataSource->getInRange($dateRange);
      return $this->parser->parse($result);
    }
    else {
      return false;
    }
  }

  private function checkDateRange(array $dateRange) {
    foreach ($dateRange as $date) {
      if (!preg_match($this->datePattern, $date)) {
        return false;
      }
    }
    return true;
  }

  public function presavedToRange($name) {
    $format = 'd/m/Y';
    $today = new \DateTime();
    $todayString = $today->format($format);
    // var_dump($todayString);
    $range = Array();
    switch ($name) {
      case 'today':
        $range = [$todayString, $todayString];
        break;
      case 'week':
        $range = [$today->modify('-1 week')->format($format), $todayString];
        break;
      case 'month':
        $range = [$today->modify('-1 month')->format($format), $todayString];
        break;
      case '3 months':
        $range = [$today->modify('-3 month')->format($format), $todayString];
        break;
      case 'halfyear':
        $range = [$today->modify('-6 month')->format($format), $todayString];
        break;
      default:
        $range = [$todayString, $todayString];
        break;
    }
    return $range;
  }

  public function setOutput(\valute\interfaces\DataParser $dataParser) {
    $this->parser = $dataParser;
  }

  public function setSource(\valute\interfaces\DataSource $dataSource) {
    $this->dataSource = $dataSource;
  }
}