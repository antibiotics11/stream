# stream

IO Stream classes mimicking java.io

```php
use antibiotics11\Stream\FileOutputStream;

$helloWorldFile = new FileOutputStream(name: "hello_world.txt", append: true);
for ($i = 0; $i < 10; $i++) {
    $helloWorldFile->write(bytes: "Hello, World!\r\n");
}
$helloWorldFile->flush();
$helloWorldFile->close();
```

## Classes

- Stream\InputStream
- Stream\OutputStream
- Stream\FileInputStream
- Stream\FileOutputStream
- Stream\BufferedOutputStream
- ~~Stream\StandardInputStream~~ [Deprecated]
- ~~Stream\StandardOutputStream~~ [Deprecated]

### Exceptions

- Stream\Exception\IOException
- Stream\Exception\FileNotFoundException

## Notice

- <b>This project is experimental and does not guarantee the same functionality as java.io.</b>
- <b>It mimics method overloading using optional arguments, but some features may be unstable.</b>

## Requirements

- PHP >= 8.3
- <a href="https://github.com/jetbrains/phpstorm-attributes">jetbrains/phpstorm-attributes</a> >= 1.0

## Installation
```shell
composer require antibiotics11/stream:dev-main
```
