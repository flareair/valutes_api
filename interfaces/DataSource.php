<?php

namespace interfaces;

interface DataSource {
  public function getInRange(array $range);
}