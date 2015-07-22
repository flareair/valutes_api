<?php

namespace valute\parsers;

use valute\interfaces\DataParser;

class JsonDataParser implements DataParser {
  public function parse(array $data) {
    return json_encode($data);
  }
  public function getHeader() {
    return 'Content-Type: application/json';
  }
}