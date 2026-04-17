<?php

declare(strict_types=1);

class User extends Model
{
    protected string $table      = 'users';
    protected string $primaryKey = 'userId';

    public function findByEmail(string $email): ?array
    {
        $row = $this->query('SELECT * FROM users WHERE email = :email LIMIT 1', ['email' => $email])->fetch();
        return $row ?: null;
    }

    public function getAll(): array
    {
        return $this->query(
            'SELECT userId, firstname, lastname, role, email, login_attempts, locked_until FROM users ORDER BY userId DESC'
        )->fetchAll();
    }

    public function register(array $data): int
    {
        return $this->create($data);
    }

    public function incrementLoginAttempts(int $userId): void
    {
        $this->query('UPDATE users SET login_attempts = login_attempts + 1 WHERE userId = :id', ['id' => $userId]);
    }

    public function lockAccount(int $userId): void
    {
        $this->query('UPDATE users SET locked_until = DATE_ADD(NOW(), INTERVAL 3 MINUTE) WHERE userId = :id', ['id' => $userId]);
    }

    public function resetLoginState(int $userId): void
    {
        $this->query('UPDATE users SET login_attempts = 0, locked_until = NULL WHERE userId = :id', ['id' => $userId]);
    }

    public function toggleRole(int $userId): void
    {
        $this->query('UPDATE users SET role = IF(role = 1, 0, 1) WHERE userId = :id', ['id' => $userId]);
    }

    public function unlock(int $userId): void
    {
        $this->query('UPDATE users SET login_attempts = 0, locked_until = NULL WHERE userId = :id', ['id' => $userId]);
    }

    public function updateProfile(int $userId, string $firstname, string $lastname, string $email): void
    {
        $this->query(
            'UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE userId = :id',
            [
                'firstname' => $firstname,
                'lastname'  => $lastname,
                'email'     => $email,
                'id'        => $userId,
            ]
        );
    }

    public function updatePassword(int $userId, string $passwordHash): void
    {
        $this->query(
            'UPDATE users SET password = :password WHERE userId = :id',
            ['password' => $passwordHash, 'id' => $userId]
        );
    }

    public function existsByEmailForOtherUser(string $email, int $userId): bool
    {
        $row = $this->query(
            'SELECT userId FROM users WHERE email = :email AND userId <> :id LIMIT 1',
            ['email' => $email, 'id' => $userId]
        )->fetch();
        return (bool) $row;
    }

    public function profileStats(int $userId): array
    {
        return [
            'recipes'   => (int) ($this->query('SELECT COUNT(*) AS n FROM recipes WHERE userId = :id', ['id' => $userId])->fetch()['n'] ?? 0),
            'posts'     => (int) ($this->query('SELECT COUNT(*) AS n FROM cookbook WHERE userId = :id', ['id' => $userId])->fetch()['n'] ?? 0),
            'comments'  => (int) ($this->query('SELECT COUNT(*) AS n FROM comments WHERE userId = :id', ['id' => $userId])->fetch()['n'] ?? 0),
            'downloads' => (int) ($this->query('SELECT COUNT(*) AS n FROM downloads WHERE userId = :id', ['id' => $userId])->fetch()['n'] ?? 0),
        ];
    }

    public function recentUploadedRecipes(int $userId, int $limit = 8): array
    {
        $stmt = $this->db()->prepare(
            'SELECT recipeId, title, cuisine, cookingdifficulty, image, created_at
             FROM recipes
             WHERE userId = :id
             ORDER BY created_at DESC, recipeId DESC
             LIMIT :limit'
        );
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function recentCookbookUploads(int $userId, int $limit = 8): array
    {
        $stmt = $this->db()->prepare(
            'SELECT postId, title, content, image, created_at, totalshare, totalInteraction, totalcomment
             FROM cookbook
             WHERE userId = :id
             ORDER BY created_at DESC, postId DESC
             LIMIT :limit'
        );
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function recentSharedCookbookPosts(int $userId, int $limit = 8): array
    {
        $stmt = $this->db()->prepare(
            "SELECT c.postId,
                    c.title,
                    c.content,
                    c.image,
                    c.created_at,
                    c.totalshare,
                    c.totalInteraction,
                    c.totalcomment,
                    u.firstname,
                    u.lastname,
                    MAX(i.created_at) AS shared_at
             FROM interactions i
             INNER JOIN cookbook c ON c.postId = i.postId
             INNER JOIN users u ON u.userId = c.userId
             WHERE i.userId = :id AND i.type = 'share'
             GROUP BY c.postId, c.title, c.content, c.image, c.created_at, c.totalshare, c.totalInteraction, c.totalcomment, u.firstname, u.lastname
             ORDER BY shared_at DESC, c.postId DESC
             LIMIT :limit"
        );
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
