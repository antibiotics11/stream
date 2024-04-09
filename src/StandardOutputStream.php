<?php

namespace antibiotics11\Stream;
use antibiotics11\Stream\Exception\IOException;
use JetBrains\PhpStorm\Deprecated;
use function sprintf;
use const STDOUT;
use const PHP_EOL;

#[Deprecated]
final class StandardOutputStream extends OutputStream {

  private static self $stdout;

  /**
   * Prints a formatted string to standard output.
   *
   * @param string $format the format string.
   * @param bool|int|float|string ...$values the values to be formatted.
   * @return void
   */
  public static function printf(string $format, bool|int|float|string ... $values): void {
    try {
      self::$stdout ??= new self();
      self::$stdout->write(sprintf($format, ... $values));
    } catch (IOException) {}
  }

  /**
   * Prints a string to standard output.
   *
   * @param string $expression the string to be printed.
   * @return void
   */
  public static function print(string $expression): void {
    self::printf($expression);
  }

  /**
   * Prints a string followed by a new line to standard output.
   *
   * @param string $expression the string to be printed.
   * @return void
   */
  public static function println(string $expression): void {
    self::printf("%s%s", $expression, PHP_EOL);
  }

  private function __construct() {
    parent::__construct(new Stream(STDOUT, Stream::MODE_WRITE_ONLY));
  }

  private function __clone(): void {}


}