<?php

use App\Router;
use App\Controller\UserController;
use App\Middleware\AuthMiddleware;

Router::get('/users', [UserController::class, 'index']);
Router::get('/users/{id:\d+}', [UserController::class, 'show']);
Router::post('/users', [UserController::class, 'create'], [AuthMiddleware::class]);