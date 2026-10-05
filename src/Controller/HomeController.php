<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\View;

class HomeController
{
    public function __construct(
        private CategoryRepository $categories,
        private PostRepository $posts,
        private View $view,
    ) {
    }

    public function index(): void
    {
        $categories = $this->categories->getWithPosts();

        foreach ($categories as &$category) {
            $category['posts'] = $this->posts->getByCategory($category['id'], 'date', 3);
        }

        $this->view->render('home.tpl', ['categories' => $categories]);
    }
}
