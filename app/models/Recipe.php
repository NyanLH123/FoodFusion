<?php

declare(strict_types=1);

class Recipe extends Model
{
    protected string $table      = 'recipes';
    protected string $primaryKey = 'recipeId';

    // Paginated recipes with optional filters, joined with author name
    public function getPaginated(array $filters, int $limit, int $offset): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = 'SELECT r.*, u.firstname, u.lastname
                FROM recipes r
                INNER JOIN users u ON u.userId = r.userId'
             . ($where ? ' WHERE ' . $where : '')
             . ' ORDER BY r.recipeId DESC LIMIT :limit OFFSET :offset';

        $stmt = $this->db()->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countFiltered(array $filters): int
    {
        [$where, $params] = $this->buildWhere($filters);
        $sql = 'SELECT COUNT(*) AS total FROM recipes r' . ($where ? ' WHERE ' . $where : '');
        $row = $this->query($sql, $params)->fetch();
        return (int) ($row['total'] ?? 0);
    }

    public function latestWithAuthors(int $limit = 6): array
    {
        $stmt = $this->db()->prepare(
            'SELECT r.recipeId, r.title, r.description, r.cuisine, r.cookingdifficulty, r.image, r.created_at, u.firstname, u.lastname
             FROM recipes r
             INNER JOIN users u ON u.userId = r.userId
             ORDER BY r.created_at DESC, r.recipeId DESC
             LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Distinct filter values for dropdowns
    public function getFilters(): array
    {
        return [
            'cuisines'     => $this->query("SELECT DISTINCT cuisine FROM recipes WHERE cuisine IS NOT NULL AND cuisine <> '' ORDER BY cuisine")->fetchAll(),
            'dietary'      => $this->query("SELECT DISTINCT dietary FROM recipes WHERE dietary IS NOT NULL AND dietary <> '' ORDER BY dietary")->fetchAll(),
            'difficulties' => $this->query("SELECT DISTINCT cookingdifficulty FROM recipes WHERE cookingdifficulty IS NOT NULL ORDER BY cookingdifficulty")->fetchAll(),
        ];
    }

    public function findWithAuthor(int $id): ?array
    {
        $row = $this->query(
            'SELECT r.*, u.firstname, u.lastname FROM recipes r INNER JOIN users u ON u.userId = r.userId WHERE r.recipeId = :id LIMIT 1',
            ['id' => $id]
        )->fetch();
        return $row ?: null;
    }

    // Ingredients list for a recipe via junction table
    public function getIngredients(int $recipeId): array
    {
        return $this->query(
            'SELECT i.name, i.unit, ri.amount
             FROM recipe_ingredients ri
             INNER JOIN ingredients i ON i.ingredientId = ri.ingredientId
             WHERE ri.recipeId = :id ORDER BY i.name',
            ['id' => $recipeId]
        )->fetchAll();
    }

    public function getAllWithAuthors(): array
    {
        return $this->query(
            'SELECT r.recipeId, r.title, r.cuisine, r.cookingdifficulty, u.firstname, u.lastname
             FROM recipes r INNER JOIN users u ON u.userId = r.userId ORDER BY r.recipeId DESC'
        )->fetchAll();
    }

    // Build WHERE clause from filter array — avoids direct interpolation
    private function buildWhere(array $filters): array
    {
        $parts  = [];
        $params = [];
        if (!empty($filters['cuisine'])) {
            $parts[]            = 'r.cuisine = :cuisine';
            $params['cuisine']  = $filters['cuisine'];
        }
        if (!empty($filters['dietary'])) {
            $parts[]            = 'r.dietary = :dietary';
            $params['dietary']  = $filters['dietary'];
        }
        if (!empty($filters['cookingdifficulty'])) {
            $parts[]               = 'r.cookingdifficulty = :difficulty';
            $params['difficulty']  = $filters['cookingdifficulty'];
        }
        return [implode(' AND ', $parts), $params];
    }
}
