<?php

namespace antibiotics11\Stream;
use antibiotics11\Stream\Exception\IOException;
use Override;
use InvalidArgumentException;
use function substr;

class BufferedOutputStream extends OutputStream {

  /**
   * @var string The internal buffer where data is stored.
   */
  protected string $buffer;

  public function __construct(protected OutputStream $output, protected int $size = 512) {
    $this->size <= 0 and throw new InvalidArgumentException("Size must be greater than 0.");
    $this->buffer = "";
    parent::__construct(null);
  }

  /**
   * Writes length bytes from the specified string starting at offset to this buffered output stream.
   *
   * @param string $bytes the data.
   * @param int|null $offset the start offset in the data.
   * @param int|null $length the number of bytes to write.
   * @return void
   * @throws IOException if an I/O error occurs.
   */
  #[Override]
  public function write(string $bytes, ?int $offset = null, ?int $length = null): void {

    ($offset === null && $length !== null) and $offset = 0;
    $offset !== null and $bytes = substr($bytes, $offset, $length);

    if (strlen($bytes) >= $this->size) {
      $this->flush();
      $this->output->write($bytes);
      $this->output->flush();
    } else {
      $this->buffer .= $bytes;
      (strlen($this->buffer) >= $this->size) and $this->flush();
    }

  }

  /**
   * Flushes this buffered output stream.
   *
   * @return void
   * @throws IOException if an I/O error occurs.
   */
  #[Override]
  public function flush(): void {
    $this->output->write($this->buffer);
    $this->output->flush();
    $this->buffer = "";
  }

  /**
   * @return void
   * @throws IOException
   */
  #[Override]
  public function close(): void {
    $this->flush();
  }

}