<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Core\DotEnv;
use App\Core\Router;


Router::get(DotEnv::env('APP_URL') . '/auth/register', [AuthController::class, 'showRegister']);
Router::post(DotEnv::env('APP_URL') . '/auth/register', [AuthController::class, 'register']);
Router::get(DotEnv::env('APP_URL') . '/auth/login', [AuthController::class, 'showLogin']);
Router::post(DotEnv::env('APP_URL') . '/auth/login', [AuthController::class, 'login']);
Router::get(DotEnv::env('APP_URL') . '/auth/logout', [AuthController::class, 'logout']);

Router::get(DotEnv::env('APP_URL') . '/home', [HomeController::class, 'index']);

Router::get(DotEnv::env('APP_URL') . '/users', [UserController::class, 'index']);
Router::get(DotEnv::env('APP_URL') . '/users/create', [UserController::class, 'create']);
Router::post(DotEnv::env('APP_URL') . '/users', [UserController::class, 'store']);
Router::get(DotEnv::env('APP_URL') . '/users/edit', [UserController::class, 'edit']);
Router::post(DotEnv::env('APP_URL') . '/users/update', [UserController::class, 'update']);
Router::post(DotEnv::env('APP_URL') . '/users/delete', [UserController::class, 'delete']);
