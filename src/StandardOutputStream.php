<?php

namespace antibiotics11\Stream;
use antibiotics11\Stream\Exception\IOException;
use function sprintf;
use const PHP_EOL;

final class StandardOutputStream extends FileOutputStream {

  public const string STDOUT = "php://stdout";

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
    parent::__construct(self::STDOUT, true);
  }

  private function __clone() {}


}