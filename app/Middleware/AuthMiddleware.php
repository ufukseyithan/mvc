<?php

namespace App\Middleware;

class AuthMiddleware {
    public function handle($params) {
        if (!isset($_SESSION['user'])) {
            echo "Unauthorized";
            return false;
        }

        return true;
    }
}