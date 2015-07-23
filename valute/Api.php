<?php

namespace valute;

use valute\ValuteDynamic;

class Api {
  private $valute;
  private $method;
  private $uri;
  private $get;

  public function __construct() {
    $this->valute = new ValuteDynamic();
  }

  public function route($method, $uri, array $get) {
    list($method, $uri, $get) = $this->sanitizeInput($method, $uri, $get);

    $parsedUri = $this->parseUri($uri);
    if ($method !== 'GET' || count($parsedUri) !== 2) {
      $this->send404();
    }

    $this->setDataParser($parsedUri[2]);
    if (!isset($get['valute']) || empty($get['valute'])) {
      $this->send404();
    }
    $this->setDataSource($parsedUri[1], $get['valute']);

    $result = $this->valute->getCourse($this->makeRange($get));

    if (!$result) {
      $this->send404();
    }

    $header = $this->valute->parser->getHeader();
    if ($header) {
      header($header);
    }
    echo $result;
  }

  private function sanitizeInput($method, $uri, array $get) {
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $uri = filter_var($uri, FILTER_SANITIZE_URL);
    $get = filter_var_array($get, FILTER_SANITIZE_STRING);
    return [$method, $uri, $get];
  }

  private function parseUri($uri) {
    $parsed = explode('/', strtok($uri, '?'));
    return array_filter($parsed);
  }

  private function setDataParser($parserName) {
    $className = 'valute\\parsers\\' . ucfirst($parserName) . 'DataParser';
    if (class_exists($className)) {
      $this->valute->setOutput(new $className());
    }
    else {
      $this->send404();
    }
  }

  private function setDataSource($sourceName, $valuteName) {
    $className = 'valute\\sources\\' . ucfirst($sourceName) . 'DataSource';
    if (class_exists($className)) {
      $this->valute->setSource(new $className($valuteName));
    }
    else {
      $this->send404();
    }
  }

  private function makeRange(array $get) {
    if (!isset($get['date1']) || empty($get['date1'])) {
      $this->send404();
    }
    if (isset($get['date2']) && !empty($get['date2'])) {
      return [$get['date1'], $get['date2']];
    }
    return $get['date1'];
  }

  private function send404() {
    header("HTTP/1.0 404 Not Found");
    die('false');
  }
}