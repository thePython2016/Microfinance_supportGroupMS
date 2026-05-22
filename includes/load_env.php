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

    foreach($lines ?: [] as $line) {
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

/**
 * @return array{host:string,port:string,dbname:string,user:string,password:string,sslmode:string}|null
 */
function finance_database_url_config(): ?array
{
    $url = finance_env('DATABASE_URL');
    if ($url === null || $url === '') {
        return null;
    }

    $parts = parse_url($url);
    if ($parts === false || empty($parts['host'])) {
        return null;
    }

    $query = [];
    if (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
    }

    return [
        'host' => $parts['host'],
        'port' => isset($parts['port']) ? (string) $parts['port'] : '5432',
        'dbname' => ltrim($parts['path'] ?? '/postgres', '/') ?: 'postgres',
        'user' => $parts['user'] ?? '',
        'password' => $parts['pass'] ?? '',
        'sslmode' => $query['sslmode'] ?? 'require',
    ];
}

function finance_env(string $key, ?string $default = null): ?string
{
    $aliases = [
        'DATABASE_URL' => ['DATABASE_URL', 'SUPABASE_DB_URL', 'POSTGRES_URL'],
        'DB_HOST' => ['DB_HOST', 'host', 'HOST'],
        'DB_PORT' => ['DB_PORT', 'port', 'PORT'],
        'DB_NAME' => ['DB_NAME', 'database', 'dbname', 'postgres', 'POSTGRES_DB'],
        'DB_USER' => ['DB_USER', 'user', 'username', 'USER'],
        'DB_PASSWORD' => ['DB_PASSWORD', 'password', 'pass', 'PASSWORD'],
        'DB_SSLMODE' => ['DB_SSLMODE', 'sslmode', 'SSLMODE'],
    ];

    $keys = $aliases[$key] ?? [$key];

    foreach($keys ?: [] as $name) {
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
