<?php

namespace App;

use Exception;
use App\Middleware\MiddlewareHandler;

class Router {
    private static $routes = [];

    public static function add($method, $pattern, $callback, $middlewares = []) {
        self::$routes[] = [
            'method' => $method, 
            'pattern' => self::convertPattern($pattern), 
            'callback' => $callback, 
            'middlewares' => $middlewares
        ];
    }

    private static function convertPattern($pattern) {
        // Optional parameters {param?}
        $pattern = preg_replace('/\{(\w+)\?\}/', '(?P<$1>[^/]+)?', $pattern);
    
        // Regex parameters {param:regex}
        $pattern = preg_replace('/\{(\w+):([^\}]+)\}/', '(?P<$1>$2)', $pattern);
    
        // Required parameters {param} without regex
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $pattern);
    
        return "#^" . $pattern . "$#";
    }

    public static function dispatch($method, $uri) {
        foreach (self::$routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $middlewares = $route['middlewares'];
                if (!MiddlewareHandler::handle($middlewares, $matches, function() use ($route, $matches) {
                    return self::executeCallback($route['callback'], $matches);
                })) {
                    return;
                }
                
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private static function executeCallback($callback, $params) {
        if (is_array($callback)) {
            [$controller, $action] = $callback;

            var_dump('s');

            return (new $controller)->{$action}(...$params);
        }

        throw new Exception("Invalid callback.");
    }

    public static function get($pattern, $callback, $middlewares = []) {
        self::add('GET', $pattern, $callback, $middlewares);
    }

    public static function post($pattern, $callback, $middlewares = []) {
        self::add('POST', $pattern, $callback, $middlewares);
    }
}