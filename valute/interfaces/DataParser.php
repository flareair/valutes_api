<?php

namespace valute\interfaces;

interface DataParser {
  public function parse(array $data);
  public function getHeader();
}