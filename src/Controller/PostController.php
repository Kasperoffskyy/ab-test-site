<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\View;

class PostController
{
    public function __construct(
        private CategoryRepository $categories,
        private PostRepository $posts,
        private View $view,
    ) {
    }

    public function show(int $id): void
    {
        $this->posts->incrementViews($id);

        $post = $this->posts->find($id);
        if (!$post) {
            $this->view->notFound();
            return;
        }

        $this->view->render('post.tpl', [
            'post' => $post,
            'categories' => $this->categories->getByPost($id),
            'similar' => $this->posts->getSimilar($id),
        ]);
    }
}
