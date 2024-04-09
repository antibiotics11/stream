<?php

namespace antibiotics11\Stream;
use antibiotics11\Stream\Exception\IOException;
use JetBrains\PhpStorm\Deprecated;
use const STDIN;

#[Deprecated]
final class StandardInputStream extends InputStream {

  public const string STDIN = "php://stdin";

  private static self $stdin;

  /**
   * Reads the next line from the standard input.
   *
   * @return string the next line read from the standard input.
   */
  public static function nextLine(): string {
    $buffer = "";
    try {
      self::$stdin ??= new self();
      self::$stdin->read($buffer);
    } catch (IOException) {}
    return $buffer;
  }

  private function __construct() {
    parent::__construct(new Stream(STDIN, Stream::MODE_READ_ONLY));
  }

  private function __clone(): void {}

}