<?php

declare(strict_types=1);

namespace Dotenvx;

use RuntimeException;

class Dotenvx
{
    private function __construct(private array $paths, private bool $overwrite)
    {
    }

    public static function createImmutable(string|array $paths = []): self
    {
        return new self((array) $paths, false);
    }

    public static function createMutable(string|array $paths = []): self
    {
        return new self((array) $paths, true);
    }

    /** Load dotenv values into the process environment and PHP superglobals. */
    public function load(
        bool $strict = false,
        array $ignore = [],
        ?string $convention = null,
        ?string $environment = null,
        ?array $keyFiles = null,
        bool $resolveReferences = false
    ): array {
        if (!function_exists('dotenvx_native_load_env')) {
            throw new RuntimeException('Load the phpdotenvx extension to use phpdotenvx.');
        }

        $processEnv = getenv();
        foreach ([$_SERVER, $_ENV] as $variables) {
            foreach ($variables as $name => $value) {
                if (is_string($value)) {
                    $processEnv[$name] = $value;
                }
            }
        }

        $cwd = getcwd();
        if ($cwd === false) {
            throw new RuntimeException('Could not determine the working directory.');
        }
        $options = [
            'sources' => array_values(array_map(
                static fn (string $path): array => ['type' => 'file', 'value' => $path],
                $this->paths
            )),
            'cwd' => $cwd,
            'process_env' => (object) $processEnv,
            'overload' => $this->overwrite,
            'strict' => $strict,
            'ignore' => array_values($ignore),
            'convention' => $convention,
            'environment_name' => $environment,
            'key_files' => $keyFiles === null ? null : array_values($keyFiles),
            'adjacent_keys' => true,
            'resolve_references' => $resolveReferences,
        ];
        $result = json_decode(
            \dotenvx_native_load_env(json_encode($options, JSON_THROW_ON_ERROR)),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        foreach ($result['diagnostics'] as $diagnostic) {
            if ($diagnostic['strict']) {
                throw new RuntimeException($diagnostic['message']);
            }
            file_put_contents('php://stderr', "☠ {$diagnostic['message']}\n");
        }
        foreach ($result['injected'] as $name => $value) {
            if (!putenv("$name=$value")) {
                throw new RuntimeException("Could not set environment variable $name.");
            }
            $_ENV[$name] = $_SERVER[$name] = $value;
        }
        if ($result['inject_summary'] !== null) {
            file_put_contents('php://stderr', $result['inject_summary'] . "\n");
        }
        return $result['injected'];
    }

    public function safeLoad(): array
    {
        return $this->load(ignore: ['MISSING_ENV_FILE']);
    }
}
