<?php

namespace antibiotics11\Stream;
use antibiotics11\Stream\Exception\IOException;
use function substr;

abstract class OutputStream { use IOStreamTrait;

  /**
   * Writes length bytes from the specified string starting at offset to this output stream.
   *
   * @param string $bytes the data.
   * @param int|null $offset the start offset in the data.
   * @param int|null $length the number of bytes to write.
   * @return void
   * @throws IOException if an I/O error occurs.
   */
  public function write(string $bytes, ?int $offset = null, ?int $length = null): void {

    $this->stream === null and throw new IOException(self::EXCEPTION_STREAM_NOT_INITIALIZED);
    $this->stream->writable or throw new IOException(self::EXCEPTION_STREAM_NOT_WRITABLE);

    ($offset === null && $length !== null) and $offset = 0;
    $offset !== null and $bytes = substr($bytes, $offset, $length);
    $this->stream->write($bytes) === false and throw new IOException(self::EXCEPTION_STREAM_WRITE_FAILED);

  }

  /**
   * Flushes this output stream and forces any buffered output bytes to be written out.
   *
   * @return void
   * @throws IOException if an I/O error occurs.
   */
  public function flush(): void {

    $this->stream === null and throw new IOException(self::EXCEPTION_STREAM_NOT_INITIALIZED);
    $this->stream->writable or throw new IOException(self::EXCEPTION_STREAM_NOT_WRITABLE);

    $this->stream->flush() or throw new IOException(self::EXCEPTION_STREAM_FLUSH_FAILED);

  }

}