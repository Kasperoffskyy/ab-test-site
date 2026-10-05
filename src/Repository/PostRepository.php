<?php

namespace App\Repository;

use PDO;

class PostRepository
{
    private const SORTS = [
        'date' => 'p.published_at DESC',
        'views' => 'p.views DESC',
    ];

    public function __construct(private PDO $db)
    {
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM posts WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function getByCategory(int $categoryId, string $sort = 'date', int $limit = 10, int $offset = 0): array
    {
        $orderBy = self::SORTS[$sort] ?? self::SORTS['date'];

        $stmt = $this->db->prepare(
            "SELECT p.*
             FROM posts p
             JOIN post_category pc ON pc.post_id = p.id
             WHERE pc.category_id = :category_id
             ORDER BY {$orderBy}, p.id DESC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM post_category WHERE category_id = ?');
        $stmt->execute([$categoryId]);

        return (int) $stmt->fetchColumn();
    }

    // Похожие — статьи с общими категориями, чем больше общих, тем выше
    public function getSimilar(int $postId, int $limit = 3): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, COUNT(*) AS common
             FROM posts p
             JOIN post_category pc ON pc.post_id = p.id
             WHERE pc.category_id IN (SELECT category_id FROM post_category WHERE post_id = :post_id)
               AND p.id != :exclude_id
             GROUP BY p.id
             ORDER BY common DESC, p.published_at DESC
             LIMIT :limit'
        );
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmt->bindValue(':exclude_id', $postId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE posts SET views = views + 1 WHERE id = ?');
        $stmt->execute([$id]);
    }
}
