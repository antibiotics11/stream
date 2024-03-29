<?php

namespace antibiotics11\Stream;
use antibiotics11\Stream\Trait\FileIOStreamTrait;
use antibiotics11\Stream\Exception\FileNotFoundException;
use Throwable;
use function is_file, is_readable;
use function fopen;

class FileInputStream extends InputStream { use FileIOStreamTrait;

  /**
   * Creates a FileInputStream by opening a connection to an actual file, the file named by the path name in the file system.
   *
   * @param string $name the system-dependent file name.
   * @throws FileNotFoundException
   */
  public function __construct(string $name) {

    is_file($name) or throw new FileNotFoundException($name . " is not a file.");
    is_readable($name) or throw new FileNotFoundException($name . " is not readable.");

    try {
      $fileMode = Stream::MODE_READ_ONLY;
      $this->fileDescriptor = fopen($name, $fileMode);
      parent::__construct(new Stream($this->fileDescriptor, $fileMode));
    } catch (Throwable $e) {
      throw new FileNotFoundException("Failed to open file: " . $e->getMessage());
    }

  }

}