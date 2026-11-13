# phpdotenvx

Load plaintext and encrypted dotenv files in PHP using the same Rust loader as
the Dotenvx CLI, Ruby gem, and Python package. Local private keys can come from
the environment or `.env.keys`. For stored keys, the loader can delegate lookup
to a compatible `dotenvx` CLI on PATH.

## Install

1. [Install PIE](https://php.github.io/pie/#installing-pie), the PHP extension installer.
2. Install and enable the `dotenvx_php` native extension. The PIE package is
   pending publication. If you already have the extension, enable it in `php.ini`.
3. Add the PHP package to your project:

   ```sh
   composer require dotenvx/phpdotenvx
   ```

## Usage

Use the Composer autoloader:

```php
require 'vendor/autoload.php';

$dotenvx = Dotenvx\Dotenvx::createImmutable(__DIR__);
$dotenvx->safeLoad();

echo getenv('HELLO');
```

`createImmutable()` preserves existing variables. Use `createMutable()` to
overwrite them. Both factories accept file or directory paths and default to
the current working directory. `load(strict: true)` raises on loading errors.
`safeLoad()` suppresses missing-file diagnostics. Set `DOTENV_QUIET=true` to
suppress the injection summary.
