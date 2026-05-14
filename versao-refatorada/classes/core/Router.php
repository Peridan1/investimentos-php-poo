<?php
class Router
{
    private array $routes = [];

    public function get(string $path, callable|string|array $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable|string|array $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function match(array $methods, string $path, callable|string|array $handler)
    {
        foreach ($methods as $method) {
            $this->routes[$method][$path] = $handler;
        }
    }

    public function dispatch(string $basePath = '')
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($basePath && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        $routesForMethod = $this->routes[$method] ?? [];

        foreach ($routesForMethod as $route => $handler) {
            // Converte parâmetros como {ativo} em expressões regulares (?P<ativo>[a-zA-Z0-9_-]+)
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                // Filtra as chaves de string para extrair apenas os parâmetros nomeados
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Usamos array_values para converter os parâmetros em argumentos posicionais
                $args = array_values($params);

                // Executa se for string (Controller@metodo)
                if (is_string($handler) && strpos($handler, '@') !== false) {
                    list($controllerName, $action) = explode('@', $handler);
                    $controller = new $controllerName();
                    return call_user_func_array([$controller, $action], $args);
                }
                
                // Executa se for array [Controller::class, 'metodo']
                if (is_array($handler) && is_string($handler[0])) {
                    $controller = new $handler[0]();
                    return call_user_func_array([$controller, $handler[1]], $args);
                }

                // Executa se for uma closure / função anônima
                if (is_callable($handler)) {
                    return call_user_func_array($handler, $args);
                }
            }
        }

        http_response_code(404);
        echo "<h1>404 - Página não encontrada</h1>";
        exit;
    }
}