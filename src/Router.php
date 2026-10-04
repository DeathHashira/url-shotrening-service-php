<?php

namespace Src;

class Router
{
    public static array $staticRoutes = [];
    public static array $dynamicRoutes = [];

    private static function getMethod(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    private static function getPath(): string
    {
        return parse_url($_SERVER["REQUEST_URI"])["path"];
    }

    private static function add(string $method, string $path, callable $handler, ?string $pattern=null, ?array $params=null): void
    {
        if (empty($pattern)) {
            static::$staticRoutes[$method][$path] = $handler;
        } else {
            static::$dynamicRoutes[$method][$path]["handler"] = $handler;
            static::$dynamicRoutes[$method][$path]["pattern"] = $pattern;
        }
    }

    public static function post(string $path, callable $handler): void
    {
        static::add("post", $path, $handler);
    }

    public static function get(string $path, callable $handler): void
    {
        static::add("get", $path, $handler);
    }

    public static function patch(string $path, callable $handler): void
    {
        static::add("patch", $path, $handler);
    }

    public static function delete(string $path, callable $handler): void
    {
        static::add("delete", $path, $handler);
    }

    public static function resolve(): void
    {
        $path = self::getPath();
        $method = self::getMethod();
        $handler = Router::$staticRoutes[$method][$path] ?? null;
        
        if (is_callable($handler)) {
            $handler()->send();
        } else {
            foreach (self::$dynamicRoutes as $route) {
                if (preg_match($route["pattern"], $path)) {
                    $params = self::extractParams($path);
                    $handler = $route["handler"];
                    $handler($params[0])->send();
                }
            }
        }
    }

    private static function extractParams(string $path): array
    {
        return preg_match("/\{([^/}]+)\}/", $path);
    }
}