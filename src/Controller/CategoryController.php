<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\View;

class CategoryController
{
    private const PER_PAGE = 6;

    public function __construct(
        private CategoryRepository $categories,
        private PostRepository $posts,
        private View $view,
    ) {
    }

    public function show(int $id): void
    {
        $category = $this->categories->find($id);
        if (!$category) {
            $this->view->notFound();
            return;
        }

        $sort = ($_GET['sort'] ?? '') === 'views' ? 'views' : 'date';
        $totalPages = max(1, (int) ceil($this->posts->countByCategory($id) / self::PER_PAGE));
        $page = min(max(1, (int) ($_GET['page'] ?? 1)), $totalPages);

        $posts = $this->posts->getByCategory($id, $sort, self::PER_PAGE, ($page - 1) * self::PER_PAGE);

        $this->view->render('category.tpl', [
            'category' => $category,
            'posts' => $posts,
            'sort' => $sort,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
