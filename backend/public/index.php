
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\DotEnv;

(new DotEnv(__DIR__ . '/../.env'))->load();
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Load config (reads .env)
$config = require __DIR__ . '/../config/config.php';

// Boot App (DB etc.)
App\Core\App::init($config);

// Instantiate router and load routes
$router = new App\Core\Router();
require __DIR__ . '/../routes/api.php';

// Dispatch current request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
