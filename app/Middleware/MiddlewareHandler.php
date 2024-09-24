<?php

namespace App\Middleware;

class MiddlewareHandler 
{
    public static function handle(array $middlewares, $params, callable $next) {
        foreach ($middlewares as $middleware) {
            $instance = new $middleware;

            if (!$instance->handle($params)) {
                return false;
            }
        }

        return $next();
    }
}