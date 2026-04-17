<?php

declare(strict_types=1);

class Contact extends Model
{
    protected string $table      = 'contact';
    protected string $primaryKey = 'messageId';

    // All messages for admin inbox, joined with user info
    public function allInbox(): array
    {
        return $this->query(
            'SELECT c.*, u.firstname, u.lastname, u.email AS user_email
             FROM contact c
             LEFT JOIN users u ON u.userId = c.userId
             ORDER BY c.created_at DESC'
        )->fetchAll();
    }

    public function addReply(int $messageId, int $adminUserId, string $reply): void
    {
        $this->ensureRepliesTable();

        $this->query(
            'INSERT INTO contact_replies (messageId, admin_userId, reply, created_at)
             VALUES (:messageId, :admin_userId, :reply, :created_at)',
            [
                'messageId'     => $messageId,
                'admin_userId'  => $adminUserId,
                'reply'         => $reply,
                'created_at'    => date('Y-m-d H:i:s'),
            ]
        );

        $this->query(
            "UPDATE contact SET status = 'replied' WHERE messageId = :id",
            ['id' => $messageId]
        );
    }

    public function repliesByMessageIds(array $messageIds): array
    {
        $this->ensureRepliesTable();

        $messageIds = array_values(array_unique(array_map('intval', $messageIds)));
        if ($messageIds === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($messageIds), '?'));
        $sql = 'SELECT r.messageId,
                       r.replyId,
                       r.reply,
                       r.created_at,
                       u.firstname,
                       u.lastname
                FROM contact_replies r
                LEFT JOIN users u ON u.userId = r.admin_userId
                WHERE r.messageId IN (' . $placeholders . ')
                ORDER BY r.created_at ASC, r.replyId ASC';

        $stmt = $this->db()->prepare($sql);
        foreach ($messageIds as $index => $messageId) {
            $stmt->bindValue($index + 1, $messageId, PDO::PARAM_INT);
        }
        $stmt->execute();

        $grouped = [];
        foreach ($stmt->fetchAll() as $row) {
            $grouped[(int) $row['messageId']][] = $row;
        }

        return $grouped;
    }

    public function inboxForUser(int $userId): array
    {
        return $this->query(
            'SELECT messageId, subject, message, type, status, created_at
             FROM contact
             WHERE userId = :userId
             ORDER BY created_at DESC, messageId DESC',
            ['userId' => $userId]
        )->fetchAll();
    }

    private function ensureRepliesTable(): void
    {
        $this->query(
            'CREATE TABLE IF NOT EXISTS contact_replies (
                replyId INT AUTO_INCREMENT PRIMARY KEY,
                messageId INT NOT NULL,
                admin_userId INT DEFAULT NULL,
                reply TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (messageId) REFERENCES contact(messageId) ON DELETE CASCADE,
                FOREIGN KEY (admin_userId) REFERENCES users(userId) ON DELETE SET NULL
            ) ENGINE=InnoDB'
        );
    }
}
