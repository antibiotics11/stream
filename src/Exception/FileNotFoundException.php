<?php

namespace antibiotics11\Stream\Exception;

class FileNotFoundException extends IOException {
  public function __construct(string $message) {
    parent::__construct($message, null);
  }
}