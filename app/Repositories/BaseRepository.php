<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use PDOStatement;
use Pecee\SimpleRouter\Exceptions\HttpException;

class BaseRepository
{
    private PDO $db;

    public function __construct()
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;port=%s;charset=utf8',
            config('database.host'),
            config('database.name'),
            config('port')
        );
        $pdo = new PDO($dsn, config('database.username'), config('database.password'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db = $pdo;
    }

    protected function getDb(): PDO
    {
        return $this->db;
    }

    protected function runQuery(string $query, array $params = []): bool|PDOStatement
    {
        $stmt = $this->getDb()->prepare($query);
        if (!$stmt->execute($params)) {
            throw new HttpException('Server error', 500);
        }

        return $stmt;
    }
}