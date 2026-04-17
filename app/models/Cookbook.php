<?php

declare(strict_types=1);

class Cookbook extends Model
{
    protected string $table      = 'cookbook';
    protected string $primaryKey = 'postId';

    // Approved posts with author names for public display
    public function allWithAuthors(): array
    {
        return $this->query(
            'SELECT c.*, u.firstname, u.lastname
             FROM cookbook c
             INNER JOIN users u ON u.userId = c.userId
             ORDER BY c.created_at DESC'
        )->fetchAll();
    }

    // Latest N posts for homepage news feed
    public function latest(int $limit = 3): array
    {
        $stmt = $this->db()->prepare(
            'SELECT c.postId, c.title, c.content, c.created_at, u.firstname, u.lastname
             FROM cookbook c
             INNER JOIN users u ON u.userId = c.userId
             ORDER BY c.created_at DESC LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Increment a counter column safely (whitelist validated)
    public function increment(string $column, int $postId): void
    {
        $allowed = ['totalshare', 'totalInteraction', 'totalcomment'];
        if (!in_array($column, $allowed, true)) {
            return;
        }
        $this->query(
            'UPDATE cookbook SET ' . $column . ' = ' . $column . ' + 1 WHERE postId = :id',
            ['id' => $postId]
        );
    }

    public function decrement(string $column, int $postId): void
    {
        $allowed = ['totalshare', 'totalInteraction', 'totalcomment'];
        if (!in_array($column, $allowed, true)) {
            return;
        }

        $this->query(
            'UPDATE cookbook SET ' . $column . ' = GREATEST(' . $column . ' - 1, 0) WHERE postId = :id',
            ['id' => $postId]
        );
    }
}
