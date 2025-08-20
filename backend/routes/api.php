
<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Core\DotEnv;
use App\Core\Router;

Router::get(DotEnv::env('APP_URL') . '/home', [HomeController::class, 'index']);


Router::get(DotEnv::env('APP_URL') . '/users', [UserController::class, 'index']); // List all users
Router::get(DotEnv::env('APP_URL') . '/users/{id}', [UserController::class, 'index']); // Show user by ID
Router::post(DotEnv::env('APP_URL') . '/users', [UserController::class, 'store']); // Create user
Router::post(DotEnv::env('APP_URL') . '/users/update/{id}', [UserController::class, 'update']); // Update user by ID
Router::post(DotEnv::env('APP_URL') . '/users/delete/{id}', [UserController::class, 'delete']); // Delete user by ID

