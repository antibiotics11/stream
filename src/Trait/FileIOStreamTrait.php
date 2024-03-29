<?php

namespace antibiotics11\Stream;

trait FileIOStreamTrait {

  /**
   * @var resource|null
   */
  private $fileDescriptor = null;

  /**
   * Returns the file descriptor associated with this stream.
   *
   * @return resource
   */
  public final function getFD() {
    return $this->fileDescriptor;
  }

}