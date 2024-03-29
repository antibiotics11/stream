<?php

namespace antibiotics11\Stream;
use antibiotics11\Stream\Exception\IOException;
use function strlen;

abstract class InputStream { use IOStreamTrait;

  /**
   * Returns an estimate of the number of bytes that can be read from this input stream.
   *
   * @return int an estimate of the number of bytes that can be read.
   * @throws IOException if an I/O error occurs.
   */
  public function available(): int {

    $this->stream === null and throw new IOException(self::EXCEPTION_STREAM_NOT_INITIALIZED);
    $this->stream->readable or throw new IOException(self::EXCEPTION_STREAM_NOT_READABLE);

    $unreadBytes = 0;
    $metadata = $this->stream->metadata();
    $metadata !== false and $unreadBytes = ($metadata["unread_bytes"] ?? 0);
    return $unreadBytes;
  }

  /**
   * Reads up to length bytes of data from the input stream into an .
   *
   * @param string $bytes the buffer into which the data is read.
   * @param int|null $offset the start offset in string bytes at which the data is written.
   * @param int|null $length the maximum number of bytes to read.
   * @return int the total number of bytes read into the buffer,
   *              or -1 if there is no more data because the end of the stream has been reached.
   * @throws IOException if an I/O error occurs.
   */
  public function read(string &$bytes, ?int $offset = null, ?int $length = null): int {

    $this->stream === null and throw new IOException(self::EXCEPTION_STREAM_NOT_INITIALIZED);
    $this->stream->readable or throw new IOException(self::EXCEPTION_STREAM_NOT_READABLE);

    $offset ??= 0;
    $readByte = 0;
    while (true) {

      $buffer = $this->stream->read(1);
      $buffer === false and throw new IOException(self::EXCEPTION_STREAM_READ_FAILED);
      if ($this->stream->eof() || strlen($buffer) === 0) {
        return -1;
      }
      $bytes[$offset++] = $buffer;
      $readByte++;

      if (($length === null && $buffer === "\n") || ($length !== null && $readByte >= $length)) {
        break;
      }

    }

    return $readByte;

  }

  /**
   * Skips over and discards n bytes of data from this input stream.
   *
   * @param int $n the number of bytes to be skipped.
   * @return int the actual number of bytes skipped.
   * @throws IOException if the stream does not support seek, or if some other I/O error occurs.
   */
  public function skip(int $n): int {

    $this->stream === null and throw new IOException(self::EXCEPTION_STREAM_NOT_INITIALIZED);
    $this->stream->readable or throw new IOException(self::EXCEPTION_STREAM_NOT_READABLE);

    $this->stream->seekable or throw new IOException(self::EXCEPTION_STREAM_NOT_SEEKABLE);
    if (false !== $skippedBytes = $this->stream->seek($n, Stream::SEEK_CUR)) {
      return $skippedBytes;
    }
    throw new IOException(self::EXCEPTION_STREAM_SEEK_FAILED);
  }

}