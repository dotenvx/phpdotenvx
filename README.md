> [!IMPORTANT]
>
> Warning: work in progress. until complete, please use [github.com/dotenvx/dotenvx](https://github.com/dotenvx/dotenvx) directly.
>
> see [php examples](https://dotenvx.com/docs/languages/php)
>

---

[![dotenvx](https://dotenvx.com/better-banner.png)](https://dotenvx.com)

*a better dotenv*–from the creator of [`dotenv`](https://github.com/motdotla/dotenv).

* run anywhere (cross-platform)
* multi-environment
* encrypted envs

&nbsp;


### Quickstart [![PHP version](https://badge.fury.io/ph/dotenvx%2Fphpdotenvx.svg)](https://badge.fury.io/ph/dotenvx%2Fphpdotenvx)

Install and use it in code just like `phpdotenv`.

```sh
composer require dotenvx/phpdotenvx
```
```php
require 'vendor/autoload.php';

$dotenvx = Dotenvx\Dotenvx::createImmutable([__DIR__]);
$dotenvx->safeLoad();
```

&nbsp;

