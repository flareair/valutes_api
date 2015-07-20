<?php

namespace valute;

require 'interfaces/DataParser.php';

use interfaces\DataParser;

class JSONDataParser implements DataParser {
  public function parse(array $data) {
    return json_encode($data);
  }
}