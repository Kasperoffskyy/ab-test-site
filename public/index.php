<?php

use App\Database;
use App\Router;

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config.php';
$db = Database::connect($config['db']);

$router = new Router();

$router->get('/', function () use ($db) {
    $count = $db->query('SELECT COUNT(*) FROM categories')->fetchColumn();
    echo "Главная. Категорий в базе: {$count}";
});

$router->get('/category/(\d+)', function ($id) {
    echo "Категория #{$id}";
});

$router->get('/post/(\d+)', function ($id) {
    echo "Статья #{$id}";
});

$router->dispatch($_SERVER['REQUEST_URI']);
