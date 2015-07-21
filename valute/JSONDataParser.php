<?php

namespace valute;

use valute\interfaces\DataParser;

class JSONDataParser implements DataParser {
  public function parse(array $data) {
    return json_encode($data);
  }
}