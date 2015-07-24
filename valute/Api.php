<?php

namespace valute;

use valute\ValuteDynamic;
use valute\exceptions\ValuteException;

class Api {
  private $valute;
  private $method;
  private $uri;
  private $get;

  public function __construct() {
    $this->valute = new ValuteDynamic();
  }

  public function route($method, $uri, array $get) {
    try {
      list($method, $uri, $get) = $this->sanitizeInput($method, $uri, $get);

      $parsedUri = $this->parseUri($uri);
      if ($method !== 'GET' || count($parsedUri) !== 2) {
        throw new ValuteException("Wrong uri or request method", 2);
      }

      $this->setDataParser($parsedUri[2]);
      if (!isset($get['valute']) || empty($get['valute'])) {
        throw new ValuteException("You should define valute name", 2);
      }
      $this->setDataSource($parsedUri[1], $get['valute']);

      $result = $this->valute->getCourse($this->makeRange($get));

      if (!$result) {
        throw new ValuteException("Something went wrong, empty results", 2);
      }

      $header = $this->valute->parser->getHeader();
      if ($header) {
        header($header);
      }
      echo $result;
    } catch(ValuteException $e) {
      $this->sendError($e->getMessage());
    } catch(\Exception $e) {
      $this->sendError('Internal server error. Contact administrator.', 'HTTP/1.1 500 Internal Server Error');
    }
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
      throw new ValuteException("Undefined data parser", 3);
    }
  }

  private function setDataSource($sourceName, $valuteName) {
    $className = 'valute\\sources\\' . ucfirst($sourceName) . 'DataSource';
    if (class_exists($className)) {
      $this->valute->setSource(new $className($valuteName));
    }
    else {
      throw new ValuteException("Undefined data source", 3);
    }
  }

  private function makeRange(array $get) {
    if (!isset($get['date1']) || empty($get['date1'])) {
      throw new ValuteException("Wrong date range", 1);
    }
    if (isset($get['date2']) && !empty($get['date2'])) {
      return [$get['date1'], $get['date2']];
    }
    return $get['date1'];
  }

  private function sendError($message = null, $header = null) {
    if ($header) {
      header($header);
    }
    die($message);
  }
}