<?php

namespace App;

class Router
{
    private array $routes = [];

    public function get(string $pattern, callable $handler): void
    {
        $this->routes[$pattern] = $handler;
    }

    public function dispatch(string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $pattern => $handler) {
            if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                array_shift($matches);
                $handler(...$matches);
                return;
            }
        }

        http_response_code(404);
        echo 'Страница не найдена';
    }
}
