<?php

namespace antibiotics11\Stream;
use antibiotics11\Stream\Trait\FileIOStreamTrait;
use antibiotics11\Stream\Exception\FileNotFoundException;
use Throwable;
use function file_exists, is_file, is_writable;
use function fopen;

class FileOutputStream extends OutputStream { use FileIOStreamTrait;

  /**
   * Creates a file output stream to write to the file with the specified name.
   *
   * @param string $name the system-dependent file name
   * @param bool $append if true, then bytes will be written to the end of the file rather than the beginning
   * @throws FileNotFoundException
   */
  public function __construct(string $name, bool $append = true) {

    if (file_exists($name)) {
      is_file($name) or throw new FileNotFoundException($name . " is not a file.");
      is_writable($name) or throw new FileNotFoundException($name . " is not writable.");
    }

    try {
      $fileMode = $append ? Stream::MODE_APPEND_ONLY : Stream::MODE_WRITE_ONLY;
      $this->fileDescriptor = fopen($name, $fileMode);
      parent::__construct(new Stream($this->fileDescriptor, $fileMode));
    } catch (Throwable $e) {
      throw new FileNotFoundException("Failed to open file: " . $e->getMessage());
    }

  }

}