<?php

namespace App\Repository;

use PDO;

class CategoryRepository
{
    public function __construct(private PDO $db)
    {
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    // Только категории, в которых есть хотя бы одна статья
    public function getWithPosts(): array
    {
        return $this->db->query(
            'SELECT DISTINCT c.*
             FROM categories c
             JOIN post_category pc ON pc.category_id = c.id
             ORDER BY c.name'
        )->fetchAll();
    }

    public function getByPost(int $postId): array
    {
        $stmt = $this->db->prepare(
            'SELECT c.*
             FROM categories c
             JOIN post_category pc ON pc.category_id = c.id
             WHERE pc.post_id = ?
             ORDER BY c.name'
        );
        $stmt->execute([$postId]);

        return $stmt->fetchAll();
    }
}
