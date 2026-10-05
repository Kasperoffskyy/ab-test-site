<?php

namespace App;

class Router
{
    private array $routes = [];

    public function get(string $pattern, callable $handler): void
    {
        $this->routes[$pattern] = $handler;
    }

    // Возвращает false, если подходящий маршрут не найден
    public function dispatch(string $uri): bool
    {
        $path = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $pattern => $handler) {
            if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                array_shift($matches);
                $handler(...$matches);
                return true;
            }
        }

        return false;
    }
}
