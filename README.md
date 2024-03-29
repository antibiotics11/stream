# stream

Stream classes for my personal projects.

```php
use antibiotics11\Stream\StandardOutputStream as stdout;

stdout::println("Hello, World!");
```

## Classes

- Stream\StandardInputStream
- Stream\StandardOutputStream
- Stream\FileInputStream
- Stream\FileOutputStream
- Stream\BufferedOutputStream

### Exceptions

- Stream\Exception\IOException
- Stream\Exception\FileNotFoundException

## Requirements

- PHP >= 8.3
- <a href="https://github.com/jetbrains/phpstorm-attributes">jetbrains/phpstorm-attributes</a> >= 1.0

## Installation
```shell
composer require antibiotics11/stream:dev-main
```
