<?php

class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $basePath = '')
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // remove prefixo BASE_PATH se houver
        if ($basePath && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        if (isset($this->routes[$method][$uri])) {
            return call_user_func($this->routes[$method][$uri]);
        }

        http_response_code(404);
        echo "<h1>404 - Página não encontrada</h1>";
        exit;
    }
}
