<?php

use App\Database;

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';
$db = Database::connect($config['db']);

$postsCount = (int) ($argv[1] ?? 40);

$categories = [
    'PHP' => 'Статьи о языке PHP: синтаксис, новые версии, лучшие практики.',
    'MySQL' => 'Всё о базах данных: запросы, индексы, оптимизация.',
    'Frontend' => 'Вёрстка, CSS, JavaScript и всё, что видит пользователь.',
    'DevOps' => 'Docker, деплой, серверы и автоматизация.',
    'Карьера' => 'Советы разработчикам: собеседования, рост, работа в команде.',
];

$types = ['Гайд', 'Разбор', 'Обзор', 'Чек-лист', 'Введение', 'Практика'];
$topics = ['индексы в MySQL', 'Docker для начинающих', 'шаблонизатор Smarty', 'рефакторинг legacy-кода', 'кеширование данных', 'тестирование на PHP', 'безопасность веб-приложений', 'адаптивная вёрстка'];

$sentences = [
    'В этой статье разберём основные моменты на простых примерах.',
    'Многие разработчики сталкиваются с этим в первые месяцы работы.',
    'Сначала посмотрим на теорию, а потом перейдём к практике.',
    'Главное — не усложнять там, где можно обойтись простым решением.',
    'Этот подход хорошо показывает себя на небольших проектах.',
    'В конце приведём несколько советов из реального опыта.',
    'Ошибки здесь обычно связаны с невнимательностью, а не со сложностью.',
    'Попробуйте повторить примеры самостоятельно — так лучше запоминается.',
];

function randomText(array $sentences, int $count): string
{
    $result = [];
    for ($i = 0; $i < $count; $i++) {
        $result[] = $sentences[array_rand($sentences)];
    }

    return implode(' ', $result);
}

$db->exec('SET FOREIGN_KEY_CHECKS = 0');
$db->exec('TRUNCATE post_category');
$db->exec('TRUNCATE posts');
$db->exec('TRUNCATE categories');
$db->exec('SET FOREIGN_KEY_CHECKS = 1');

$db->beginTransaction();

$insertCategory = $db->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
$categoryIds = [];
foreach ($categories as $name => $description) {
    $insertCategory->execute([$name, $description]);
    $categoryIds[] = (int) $db->lastInsertId();
}

$insertPost = $db->prepare(
    'INSERT INTO posts (title, description, content, image, views, published_at) VALUES (?, ?, ?, ?, ?, ?)'
);
$insertLink = $db->prepare('INSERT INTO post_category (post_id, category_id) VALUES (?, ?)');

for ($i = 1; $i <= $postsCount; $i++) {
    $title = $types[array_rand($types)] . ': ' . $topics[array_rand($topics)];

    $paragraphs = [];
    for ($p = 0; $p < random_int(3, 5); $p++) {
        $paragraphs[] = randomText($sentences, random_int(3, 6));
    }

    $insertPost->execute([
        $title,
        randomText($sentences, 2),
        implode("\n\n", $paragraphs),
        "https://picsum.photos/seed/post{$i}/800/400",
        random_int(0, 1000),
        date('Y-m-d H:i:s', time() - random_int(0, 365 * 24 * 3600)),
    ]);
    $postId = (int) $db->lastInsertId();

    foreach ((array) array_rand($categoryIds, random_int(1, 3)) as $key) {
        $insertLink->execute([$postId, $categoryIds[$key]]);
    }
}

$db->commit();

echo 'Создано категорий: ' . count($categoryIds) . ", статей: {$postsCount}\n";
