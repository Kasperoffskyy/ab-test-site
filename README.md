# Блог на чистом PHP

Простой блог с категориями и статьями: PHP 8.2, MySQL 8, Smarty 5, без фреймворков.

## Запуск

```bash
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php seed.php
```

Сайт: http://localhost:8080

Таблицы создаются автоматически при первом запуске MySQL из `database/schema.sql`.

## Стили

Свои стили лежат в `assets/scss/` и собираются в `public/css/main.css`. Контейнер `assets` пересобирает их автоматически при изменении. Разовая сборка:

```bash
docker compose run --rm assets npm run build
```

## Доступ к БД

`localhost:3307`, база `blog`, пользователь `blog`, пароль `secret`.
