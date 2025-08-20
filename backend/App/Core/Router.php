<?php

namespace App\Core;


final class Router
{
    private static array $routes = [];

    public static function add(string $method, string $path, $handler, array $middleware = []): void
    {
        self::$routes[] = compact('method', 'path', 'handler', 'middleware');
    }
    public static function get(string $path, $handler, $middleware = []): void
    {
        self::add('GET', $path, $handler, $middleware);
    }
    public static function post(string $path, $handler, $middleware = []): void
    {
        self::add('POST', $path, $handler, $middleware);
    }

    public static function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        foreach (self::$routes as $route) {
            if ($route['method'] !== $method) continue;
            $params = self::match($route['path'], $path);

            if ($params !== false) {
                // middleware
                foreach ($route['middleware'] as $m) {
                    if (
                        $m === 'auth' &&
                        !\App\Controllers\AuthController::check()
                    ) {
                        header('Location: /login');

                        exit;
                    }
                }
                $handler = $route['handler'];

                if (is_array($handler)) {
                    [$class, $action] = $handler;
                    $controller = new $class();
                    call_user_func_array([$controller, $action], $params);
                    return;
                } elseif (is_callable($handler)) {
                    call_user_func_array($handler, $params);

                    return;
                }
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }

    private static function match(string $routePath, string $actualPath)
    {
        $routePath = rtrim($routePath, '/');
        $actualPath = rtrim($actualPath, '/');
        if ($routePath === '') $routePath = '/';
        if ($actualPath === '') $actualPath = '/';
        $routeParts = explode('/', trim($routePath, '/'));
        $pathParts = explode('/', trim($actualPath, '/'));
        // special case root
        if ($routePath === '/' && $actualPath === '/') return [];
        if (count($routeParts) !== count($pathParts)) {
            return false;
        }
        $params = [];
        foreach ($routeParts as $i => $rp) {
            if (preg_match('/^\{(.+)\}$/', $rp, $m)) {
                $params[] = $pathParts[$i];
            } elseif ($rp !== $pathParts[$i]) {
                return false;
            }
        }
        return $params;
    }
}
