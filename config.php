<?php

return [
    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'name' => getenv('DB_NAME') ?: 'blog',
        'user' => getenv('DB_USER') ?: 'blog',
        'password' => getenv('DB_PASSWORD') ?: 'secret',
    ],
];
