<?php

declare(strict_types=1);

abstract class Model
{
    protected string $table      = '';
    protected string $primaryKey = 'id';

    protected function db(): PDO
    {
        return Database::getInstance();
    }

    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function find(int $id): ?array
    {
        $row = $this->query(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1",
            ['id' => $id]
        )->fetch();
        return $row ?: null;
    }

    public function findAll(string $orderBy = ''): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy !== '') {
            $sql .= " ORDER BY {$orderBy}";
        }
        return $this->query($sql)->fetchAll();
    }

    public function create(array $data): int
    {
        $columns      = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(static fn($k) => ':' . $k, array_keys($data)));

        $this->query("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})", $data);
        return (int) $this->db()->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $set = implode(', ', array_map(static fn($k) => "{$k} = :{$k}", array_keys($data)));
        $data[$this->primaryKey] = $id;
        $this->query("UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = :{$this->primaryKey}", $data);
    }

    public function delete(int $id): void
    {
        $this->query("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id", ['id' => $id]);
    }

    public function count(): int
    {
        return (int) ($this->query("SELECT COUNT(*) AS n FROM {$this->table}")->fetch()['n'] ?? 0);
    }
}
