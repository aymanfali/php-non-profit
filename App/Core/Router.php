<?php
namespace App\Core;

final class Router
{
    private static array $routes = ['GET' => [], 'POST' => []];

    public static function get(string $path, $handler): void  { self::$routes['GET'][self::norm($path)]  = $handler; }
    public static function post(string $path, $handler): void { self::$routes['POST'][self::norm($path)] = $handler; }

    public static function dispatch(string $method, string $uri): void
    {
        $path = self::norm(parse_url($uri, PHP_URL_PATH) ?: '/');
        $handler = self::$routes[$method][$path] ?? null;
        if (!$handler) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }
        if (is_array($handler)) {
            [$class, $action] = $handler;
            (new $class())->$action();
        } else {
            $handler();
        }
    }

    private static function norm(string $p): string
    {
        $p = rtrim($p, '/');
        return $p === '' ? '/' : $p;
    }
}
