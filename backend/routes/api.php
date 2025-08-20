<?php

use App\Controllers\AuthController;
use App\Controllers\Dashboard\DashboardHomeController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Core\DotEnv;
use App\Core\Router;

// Auth API endpoints
Router::post(DotEnv::env('APP_URL') . '/auth/login', [AuthController::class, 'login']);
Router::post(DotEnv::env('APP_URL') . '/auth/register', [AuthController::class, 'register']);
Router::get(DotEnv::env('APP_URL') . '/auth/check', [AuthController::class, 'checkSession']);
Router::get(DotEnv::env('APP_URL') . '/auth/logout', [AuthController::class, 'logout']);

Router::get(DotEnv::env('APP_URL') . '/home', [HomeController::class, 'index']);

Router::get(DotEnv::env('APP_URL') . '/dashboard', [DashboardHomeController::class, 'index']);

Router::get(DotEnv::env('APP_URL') . '/users', [UserController::class, 'index']); // List all users
Router::get(DotEnv::env('APP_URL') . '/users/{id}', [UserController::class, 'index']); // Show user by ID
Router::post(DotEnv::env('APP_URL') . '/users', [UserController::class, 'store']); // Create user
Router::post(DotEnv::env('APP_URL') . '/users/update/{id}', [UserController::class, 'update']); // Update user by ID
Router::post(DotEnv::env('APP_URL') . '/users/delete/{id}', [UserController::class, 'delete']); // Delete user by ID

