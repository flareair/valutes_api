<?php

namespace valute\interfaces;

interface DataSource {
  public function getInRange(array $range);
}