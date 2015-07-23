<?php

namespace valute\parsers;

use valute\interfaces\DataParser;

class XmlDataParser implements DataParser {
  public function parse(array $data) {
    // var_dump($data);
    $xml = new \SimpleXMLElement('<valute></valute>');
    foreach ($data as $key => $day) {
      $record = $xml->addChild('record');
      foreach ($day as $name => $value) {
        $record->addChild($name, $value);
      }
    }
    return $xml->asXML();
  }
  public function getHeader() {
    return 'Content-Type: text/xml';
  }
}