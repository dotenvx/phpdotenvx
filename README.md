[![dotenvx](https://dotenvx.com/banner.png?v2)](https://dotenvx.com)

*A secure dotenv*–from the creator of [`dotenv`](https://github.com/motdotla/dotenv).

* Encrypt
* Commit
* Ship

[Install](https://dotenvx.com/docs/install) · [Quickstart](https://dotenvx.com/docs/quickstart)

## Quickstart

Install [PIE](https://php.github.io/pie/#installing-pie) first.

```sh
pie install dotenvx/phpdotenvx-ext
composer require dotenvx/phpdotenvx
```

```php
<?php

require __DIR__ . '/vendor/autoload.php';

Dotenvx\Dotenvx::createImmutable(__DIR__)->safeLoad();

echo 'Hello ' . getenv('HELLO') . PHP_EOL;
```
