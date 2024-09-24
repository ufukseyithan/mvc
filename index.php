<?php

use App\Router;

spl_autoload_register(function ($class) {
    $classFile = substr(str_replace('\\', DIRECTORY_SEPARATOR, $class), 4);

    if (file_exists("app/$classFile.php"))
        require "app/$classFile.php";
});

session_start();

require_once "routes/web.php";

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

Router::dispatch($method, $uri);

