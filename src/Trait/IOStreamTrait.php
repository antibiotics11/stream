<?php

namespace antibiotics11\Stream\Trait;
use antibiotics11\Stream\Stream;

trait IOStreamTrait {

  public function __construct(protected ?Stream $stream = null) {}

  /**
   * Closes this stream and releases any system resources associated with this stream.
   *
   * @return void
   */
  public function close(): void {
    $this->stream !== null and $this->stream->close();
    $this->stream = null;
  }

  /**
   * Attaches a new stream.
   *
   * @param Stream $stream
   * @return void
   */
  public function attach(Stream $stream): void {
    $this->close();
    $this->stream = $stream;
  }

  /**
   * Detaches the current stream.
   *
   * @return Stream|null
   */
  public function detach(): ?Stream {
    $stream = $this->stream;
    $this->stream = null;
    return $stream;
  }

  protected const string EXCEPTION_STREAM_NOT_INITIALIZED = "Stream is not initialized.";
  protected const string EXCEPTION_STREAM_NOT_WRITABLE    = "Stream is not writable.";
  protected const string EXCEPTION_STREAM_NOT_READABLE    = "Stream is not readable.";
  protected const string EXCEPTION_STREAM_NOT_SEEKABLE    = "Stream is not seekable.";
  protected const string EXCEPTION_STREAM_WRITE_FAILED    = "Failed to write to stream.";
  protected const string EXCEPTION_STREAM_READ_FAILED     = "Failed to read from stream.";
  protected const string EXCEPTION_STREAM_SEEK_FAILED     = "Failed to seek to offset.";
  protected const string EXCEPTION_STREAM_FLUSH_FAILED    = "Failed to flush stream.";

}