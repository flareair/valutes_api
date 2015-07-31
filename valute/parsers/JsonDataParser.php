<?php

namespace valute\parsers;

use valute\interfaces\DataParser;

class JsonDataParser implements DataParser {
  public function parse(array $data) {
    return json_encode($data, JSON_UNESCAPED_SLASHES);
  }
  public function getHeader() {
    return 'Content-Type: application/json';
  }
}