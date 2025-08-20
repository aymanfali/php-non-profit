
<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Core\DotEnv;
use App\Core\Router;

Router::get(DotEnv::env('APP_URL') . '/home', [HomeController::class, 'index']);


Router::get(DotEnv::env('APP_URL') . '/users', [UserController::class, 'index']);
Router::post(DotEnv::env('APP_URL') . '/users', [UserController::class, 'store']);
Router::post(DotEnv::env('APP_URL') . '/users/update', [UserController::class, 'update']);
Router::post(DotEnv::env('APP_URL') . '/users/delete', [UserController::class, 'delete']);

