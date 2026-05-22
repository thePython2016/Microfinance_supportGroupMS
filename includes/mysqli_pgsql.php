<?php

/**
 * Minimal mysqli-style API backed by PDO PostgreSQL.
 */

class FinanceDbConnection
{
    public PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}

class FinanceDbResult implements Iterator, Countable
{
    /** @var array<int, array<string, mixed>> */
    private array $rows;
    public int $num_rows;
    private int $position = 0;

    /** @param array<int, array<string, mixed>> $rows */
    public function __construct(array $rows)
    {
        $this->rows = $rows;
        $this->num_rows = count($rows);
    }

    public function current(): mixed
    {
        return $this->rows[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->rows[$this->position]);
    }

    public function count(): int
    {
        return $this->num_rows;
    }
}

/** @var string|null */
$finance_db_last_error = null;

function finance_db_connect(): FinanceDbConnection
{
    global $finance_db_last_error;

    $root = dirname(__DIR__);
    require_once $root . '/includes/load_env.php';
    finance_load_env($root . '/.env');

    $host = finance_env('DB_HOST', 'localhost');
    $port = finance_env('DB_PORT', '5432');
    $dbname = finance_env('DB_NAME', 'postgres');
    $user = finance_env('DB_USER', 'postgres');
    $password = finance_env('DB_PASSWORD', '');
    $sslmode = finance_env('DB_SSLMODE');

    if ($sslmode === null || $sslmode === '') {
        $sslmode = ($host !== 'localhost' && $host !== '127.0.0.1') ? 'require' : 'prefer';
    }

    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s;sslmode=%s',
        $host,
        $port,
        $dbname,
        $sslmode
    );

    try {
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $finance_db_last_error = null;

        return new FinanceDbConnection($pdo);
    } catch (PDOException $e) {
        $finance_db_last_error = $e->getMessage();
        die('Failed to connect to PostgreSQL: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
    }
}

/** @param FinanceDbConnection|mixed $connection */
function finance_db_query($connection, string $query): FinanceDbResult|bool
{
    global $finance_db_last_error;

    if (!$connection instanceof FinanceDbConnection) {
        $finance_db_last_error = 'Invalid database connection.';
        return false;
    }

    try {
        require_once __DIR__ . '/sql_compat.php';
        $query = finance_compat_sql($query);

        $statement = $connection->pdo->query($query);
        if ($statement === false) {
            return true;
        }

        $rows = array_map(
            'finance_normalize_row',
            $statement->fetchAll()
        );
        return new FinanceDbResult($rows);
    } catch (PDOException $e) {
        $finance_db_last_error = $e->getMessage();
        return false;
    }
}

/** @param FinanceDbConnection|mixed $connection */
function finance_db_escape($connection, string $string): string
{
    if (!$connection instanceof FinanceDbConnection) {
        return addslashes($string);
    }

    $quoted = $connection->pdo->quote($string);

    return substr($quoted, 1, -1);
}

/** @param FinanceDbResult|mixed $result */
function finance_db_fetch_assoc($result): ?array
{
    if (!$result instanceof FinanceDbResult || $result->num_rows === 0) {
        return null;
    }

    $row = $result->current();
    $result->next();

    return is_array($row) ? $row : null;
}

/** @param FinanceDbResult|mixed $result */
function finance_db_fetch_array($result, int $mode = 3): ?array
{
    $row = finance_db_fetch_assoc($result);
    if ($row === null) {
        return null;
    }

    if ($mode === 1) {
        return $row;
    }

    return array_merge(array_values($row), $row);
}

/** @param FinanceDbResult|mixed $result */
function finance_db_num_rows($result): int
{
    return $result instanceof FinanceDbResult ? $result->num_rows : 0;
}

function finance_db_connect_error(): string
{
    global $finance_db_last_error;

    return $finance_db_last_error ?? '';
}
