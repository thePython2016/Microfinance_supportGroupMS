<?php

/**
 * Load key=value or key:value pairs from the project .env file into the environment.
 */
function finance_load_env(string $envPath): void
{
    if (!is_readable($envPath)) {
        return;
    }

    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        if (!preg_match('/^([^:=]+)[:=](.*)$/', $line, $matches)) {
            continue;
        }

        $key = trim($matches[1]);
        $value = trim($matches[2]);
        if (
            (str_starts_with($value, '"') && str_ends_with($value, '"'))
            || (str_starts_with($value, "'") && str_ends_with($value, "'"))
        ) {
            $value = substr($value, 1, -1);
        }

        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

function finance_env(string $key, ?string $default = null): ?string
{
    $aliases = [
        'DB_HOST' => ['DB_HOST', 'host', 'HOST'],
        'DB_PORT' => ['DB_PORT', 'port', 'PORT'],
        'DB_NAME' => ['DB_NAME', 'database', 'dbname', 'postgres', 'POSTGRES_DB'],
        'DB_USER' => ['DB_USER', 'user', 'username', 'USER'],
        'DB_PASSWORD' => ['DB_PASSWORD', 'password', 'pass', 'PASSWORD'],
        'DB_SSLMODE' => ['DB_SSLMODE', 'sslmode', 'SSLMODE'],
    ];

    $keys = $aliases[$key] ?? [$key];

    foreach ($keys as $name) {
        $value = getenv($name);
        if ($value !== false && $value !== '') {
            return $value;
        }
        if (isset($_ENV[$name]) && $_ENV[$name] !== '') {
            return (string) $_ENV[$name];
        }
    }

    return $default;
}
