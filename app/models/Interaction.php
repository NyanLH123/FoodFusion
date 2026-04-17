<?php

declare(strict_types=1);

class Interaction extends Model
{
    protected string $table      = 'interactions';
    protected string $primaryKey = 'interactionId';

    // Check if a user has already recorded a specific interaction on a post
    public function exists(int $postId, int $userId, string $type): bool
    {
        $row = $this->query(
            'SELECT interactionId FROM interactions WHERE postId = :postId AND userId = :userId AND type = :type LIMIT 1',
            ['postId' => $postId, 'userId' => $userId, 'type' => $type]
        )->fetch();
        return (bool) $row;
    }

    public function remove(int $postId, int $userId, string $type): void
    {
        $this->query(
            'DELETE FROM interactions WHERE postId = :postId AND userId = :userId AND type = :type',
            ['postId' => $postId, 'userId' => $userId, 'type' => $type]
        );
    }

    public function statesForPosts(int $userId, array $postIds): array
    {
        $postIds = array_values(array_unique(array_map('intval', $postIds)));
        if ($postIds === []) {
            return [];
        }

        $states = [];
        foreach ($postIds as $postId) {
            $states[$postId] = ['liked' => false, 'shared' => false];
        }

        $placeholders = implode(',', array_fill(0, count($postIds), '?'));
        $sql = 'SELECT postId, type
                FROM interactions
                WHERE userId = ? AND postId IN (' . $placeholders . ")
                  AND type IN ('like', 'share')";
        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        foreach ($postIds as $index => $postId) {
            $stmt->bindValue($index + 2, $postId, PDO::PARAM_INT);
        }
        $stmt->execute();

        foreach ($stmt->fetchAll() as $row) {
            $postId = (int) ($row['postId'] ?? 0);
            $type = (string) ($row['type'] ?? '');
            if (!isset($states[$postId])) {
                continue;
            }

            if ($type === 'like') {
                $states[$postId]['liked'] = true;
            } elseif ($type === 'share') {
                $states[$postId]['shared'] = true;
            }
        }

        return $states;
    }
}
