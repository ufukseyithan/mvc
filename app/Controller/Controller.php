<?php

namespace App\Controller;

use Exception;

class Controller {
    protected function view($view, $data = []) {
        extract($data);

        $viewFile = "resources/views/$view.php";

        if (file_exists($viewFile))
            require_once $viewFile;
        else
            throw new Exception("View '$view' not found.");
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}