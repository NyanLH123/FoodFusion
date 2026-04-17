<?php

declare(strict_types=1);

class Comment extends Model
{
    protected string $table      = 'comments';
    protected string $primaryKey = 'commentId';

    public function byPost(int $postId): array
    {
        return $this->query(
            'SELECT c.commentId, c.message, c.created_at, u.firstname, u.lastname
             FROM comments c
             INNER JOIN users u ON u.userId = c.userId
             WHERE c.postId = :postId
             ORDER BY c.commentId DESC',
            ['postId' => $postId]
        )->fetchAll();
    }
}
