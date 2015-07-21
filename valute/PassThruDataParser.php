<?php

namespace valute;

use valute\interfaces\DataParser;

class PassThruDataParser implements DataParser {
  public function parse(array $data) {
    return $data;
  }
}