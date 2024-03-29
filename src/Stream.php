<?php

namespace antibiotics11\Stream;
use JetBrains\PhpStorm\{Immutable, ExpectedValues};
use function is_resource;
use function in_array;
use function strlen;
use function fgets, fread, fwrite, fclose;
use function fseek, ftell, feof;
use function fsync, fflush, fstat;
use function stream_get_meta_data;
use const SEEK_SET, SEEK_CUR, SEEK_END;

class Stream {

  public const string MODE_READ_ONLY   = "r";
  public const string MODE_WRITE_ONLY  = "w";
  public const string MODE_APPEND_ONLY = "a";
  public const string MODE_READ_WRITE  = "r+";
  public const string MODE_WRITE_READ  = "w+";
  public const string MODE_APPEND_READ = "a+";

  public const int SEEK_SET = SEEK_SET;
  public const int SEEK_CUR = SEEK_CUR;
  public const int SEEK_END = SEEK_END;

  #[Immutable] public readonly bool $readable;
  #[Immutable] public readonly bool $writable;
  #[Immutable] public readonly bool $seekable;

  /**
   * @param resource $stream The stream resource.
   * @param string   $mode   The mode in which the stream is opened.
   */
  public function __construct(

    protected $stream,

    #[ExpectedValues([
      self::MODE_READ_ONLY,   self::MODE_READ_WRITE,
      self::MODE_WRITE_ONLY,  self::MODE_WRITE_READ,
      self::MODE_APPEND_ONLY, self::MODE_APPEND_READ
    ])]
    #[Immutable] public readonly string $mode

  ) {
    $this->readable = !in_array($this->mode, [
      self::MODE_WRITE_ONLY,
      self::MODE_APPEND_ONLY
    ]);
    $this->writable = !in_array($this->mode, [
      self::MODE_READ_ONLY
    ]);
    $this->seekable = $this->metadata()["seekable"] ?? false;
  }

  public function __destruct() {
    $this->close();
  }

  /**
   * Read from the stream.
   *
   * @param int|null $length
   * @return string|false
   */
  public function read(?int $length = null): string|false {
    if ($this->readable && is_resource($this->stream)) {
      if ($length === null) {
        return fgets($this->stream);
      }
      return fread($this->stream, $length);
    }
    return false;
  }

  /**
   * Write to the stream.
   *
   * @param string $data
   * @param int|null $length
   * @return int|false
   */
  public function write(string $data, ?int $length = null): int|false {
    if ($this->writable && is_resource($this->stream)) {
      $length ??= strlen($data);
      return fwrite($this->stream, $data, $length);
    }
    return false;
  }

  /**
   * Seek to a specific position in the stream.
   *
   * @param int $offset
   * @param int $whence
   * @return int|false
   */
  public function seek(
    int $offset,
    #[ExpectedValues([ self::SEEK_SET, self::SEEK_CUR, self::SEEK_END ])]
    int $whence = self::SEEK_SET
  ): int|false {
    if ($this->seekable && is_resource($this->stream)) {
      return fseek($this->stream, $offset, $whence);
    }
    return false;
  }

  /**
   * Rewind the stream to the beginning.
   *
   * @return bool
   */
  public function rewind(): bool {
    return $this->seek(0);
  }

  /**
   * Get the current position in the stream.
   *
   * @return int|false
   */
  public function tell(): int|false {
    if (is_resource($this->stream)) {
      return ftell($this->stream);
    }
    return false;
  }

  /**
   * Synchronize the stream.
   *
   * @return bool
   */
  public function sync(): bool {
    if (is_resource($this->stream)) {
      return fsync($this->stream);
    }
    return false;
  }

  /**
   * Flush the stream buffer.
   *
   * @return bool
   */
  public function flush(): bool {
    if (is_resource($this->stream)) {
      return fflush($this->stream);
    }
    return false;
  }

  /**
   * Check if the end of stream has been reached.
   *
   * @return bool
   */
  public function eof(): bool {
    if (is_resource($this->stream)) {
      return feof($this->stream);
    }
    return false;
  }

  /**
   * Get information about the stream.
   *
   * @return array|false
   */
  public function stat(): array|false {
    if (is_resource($this->stream)) {
      return fstat($this->stream);
    }
    return false;
  }

  /**
   * Get metadata about the stream.
   *
   * @return array|false
   */
  public function metadata(): array|false {
    if (is_resource($this->stream)) {
      return stream_get_meta_data($this->stream);
    }
    return false;
  }

  /**
   * Close the stream.
   *
   * @return void
   */
  public function close(): void {
    if (is_resource($this->stream)) {
      fclose($this->stream);
    }
    $this->stream = null;
  }

}