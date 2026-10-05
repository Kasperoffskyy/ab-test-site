<?php

use App\Controller\CategoryController;
use App\Controller\HomeController;
use App\Controller\PostController;
use App\Database;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Router;
use App\View;

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config.php';
$db = Database::connect($config['db']);

$view = new View(__DIR__ . '/../templates', __DIR__ . '/../var/cache');
$categories = new CategoryRepository($db);
$posts = new PostRepository($db);

$router = new Router();
$router->get('/', [new HomeController($categories, $posts, $view), 'index']);
$router->get('/category/(\d+)', [new CategoryController($categories, $posts, $view), 'show']);
$router->get('/post/(\d+)', [new PostController($categories, $posts, $view), 'show']);

if (!$router->dispatch($_SERVER['REQUEST_URI'])) {
    $view->notFound();
}
