<?php
namespace App\Core;


final class Router
{
    private static array $routes = ['GET' => [], 'POST' => []];

    public static function get(string $path, $handler): void  { self::$routes['GET'][$path]  = $handler; }
    public static function post(string $path, $handler): void { self::$routes['POST'][$path] = $handler; }

    public static function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $found = false;
        foreach (self::$routes[$method] as $route => $handler) {
            $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_\-]+)', $route);
            $routePattern = str_replace('/', '\/', $routePattern);
            if (preg_match('/^' . $routePattern . '$/', $path, $matches)) {
                array_shift($matches); // Remove full match
                if (is_array($handler)) {
                    [$class, $action] = $handler;
                    $result = (new $class())->$action(...$matches);
                    if (isset($result)) echo $result;
                } else {
                    $result = $handler(...$matches);
                    if (isset($result)) echo $result;
                }
                $found = true;
                break;
            }
        }
        if (!$found) {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
