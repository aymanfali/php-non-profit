<?php

namespace App\Core;

class DotEnv
{
    private string $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function load(): void
    {
        if (!file_exists($this->path)) {
            return;
        }
        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }
            if (!str_contains($line, '=')) {
                continue;
            }
            list($name, $value) = array_map('trim', explode('=', $line, 2));
            if (!array_key_exists($name, $_ENV)) {
                $_ENV[$name] = $value;
                putenv("{$name}={$value}");
            }
        }
    }

    public static function env($key, $default = null)
    {
        return $_ENV[$key] ?? getenv($key) ?? $default;
    }
}
