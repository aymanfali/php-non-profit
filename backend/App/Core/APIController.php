<?php

namespace App\Core;

abstract class APIController extends Controller
{
    protected $modelClass;

    public function __construct()
    {
        header('Content-Type: application/json');
    }

    protected function getInput(): array
    {
        $data = $_POST;
        if (empty($data)) {
            $data = json_decode(file_get_contents('php://input'), true) ?? [];
        }
        return $data;
    }

    protected function jsonResponse($data, int $status = 200): void
    {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    protected function getModel()
    {
        if (!$this->modelClass) {
            throw new \Exception('Model class not set.');
        }
        return new $this->modelClass();
    }
}
