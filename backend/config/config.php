<?php

use App\Core\DotEnv;

$envPath = __DIR__ . '/../.env';
require_once __DIR__ . '/../App/Core/DotEnv.php';
$dotenv = new DotEnv($envPath);
$dotenv->load();

return [
    'app' => [
        'env' => DotEnv::env('APP_ENV', 'production'),
        'debug' => filter_var(
            DotEnv::env('APP_DEBUG', false),
            FILTER_VALIDATE_BOOLEAN
        ),
        'url' => DotEnv::env('APP_URL', 'http://localhost'),
        'key' => DotEnv::env('APP_KEY', ''),
    ],
    'db' => [
        'dsn' => sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            DotEnv::env('DB_HOST', '127.0.0.1'),
            DotEnv::env('DB_PORT', '3306'),
            DotEnv::env('DB_NAME', 'non_profit_org')
        ),
        'user' => DotEnv::env('DB_USERNAME', 'root'),
        'pass' => DotEnv::env('DB_PASSWORD', '')
    ],
    'storage' => [
        'logs' => __DIR__ . '/../storage/logs',
        'uploads' => __DIR__ . '/../storage/uploads',
    ]
];
