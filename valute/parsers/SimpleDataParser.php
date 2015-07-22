<?php

namespace valute\parsers;

use valute\interfaces\DataParser;

class SimpleDataParser implements DataParser {
  public function parse(array $data) {
    return $data;
  }
  public function getHeader() {
    return null;
  }
}