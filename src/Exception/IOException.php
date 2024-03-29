<?php

namespace antibiotics11\Stream\Exception;
use Exception, Throwable;

class IOException extends Exception {
  public function __construct(string $message = "", ?Throwable $cause = null) {
    parent::__construct($message, 0, $cause);
  }
}