<?php

namespace valute\parsers;

use valute\interfaces\DataParser;

class HtmlDataParser implements DataParser {
  public function parse(array $data) {
    $html = '';
    foreach ($data as $key => $record) {
      $day = '';
      $day .= "<ul>";
      $day .= "<li>Date: ${record['date']}</li>";
      $day .= "<li>Nominal: ${record['nominal']}</li>";
      $day .= "<li>Value: ${record['value']}</li>";
      $day .= "</ul>";
      $html .= $day;
      unset($day);
    }
    return $html;
  }
  public function getHeader() {
    return 'Content-Type: text/html';
  }
}