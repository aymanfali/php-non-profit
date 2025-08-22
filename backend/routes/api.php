<?php

use App\Controllers\AuthController;
use App\Controllers\ContactController;
use App\Controllers\Dashboard\DashboardAboutController;
use App\Controllers\Dashboard\DashboardContactsController;
use App\Controllers\Dashboard\DashboardHomeController;
use App\Controllers\Dashboard\DashboardImpactController;
use App\Controllers\Dashboard\DashboardNewsController;
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

Router::get(DotEnv::env('APP_URL') . '/users', [UserController::class, 'index']); 
Router::get(DotEnv::env('APP_URL') . '/users/{id}', [UserController::class, 'index']);
Router::post(DotEnv::env('APP_URL') . '/users', [UserController::class, 'store']); 
Router::post(DotEnv::env('APP_URL') . '/users/update/{id}', [UserController::class, 'update']); 
Router::post(DotEnv::env('APP_URL') . '/users/delete/{id}', [UserController::class, 'delete']);

Router::get(DotEnv::env('APP_URL') . '/impacts', [DashboardImpactController::class, 'index']); 
Router::get(DotEnv::env('APP_URL') . '/impacts/{id}', [DashboardImpactController::class, 'index']);
Router::post(DotEnv::env('APP_URL') . '/impacts', [DashboardImpactController::class, 'store']); 
Router::post(DotEnv::env('APP_URL') . '/impacts/update/{id}', [DashboardImpactController::class, 'update']); 
Router::post(DotEnv::env('APP_URL') . '/impacts/delete/{id}', [DashboardImpactController::class, 'delete']);

Router::get(DotEnv::env('APP_URL') . '/news', [DashboardNewsController::class, 'index']); 
Router::get(DotEnv::env('APP_URL') . '/news/{id}', [DashboardNewsController::class, 'index']);
Router::post(DotEnv::env('APP_URL') . '/news', [DashboardNewsController::class, 'store']); 
Router::post(DotEnv::env('APP_URL') . '/news/update/{id}', [DashboardNewsController::class, 'update']); 
Router::post(DotEnv::env('APP_URL') . '/news/delete/{id}', [DashboardNewsController::class, 'delete']);

Router::get(DotEnv::env('APP_URL') . '/contacts', [DashboardContactsController::class, 'index']); 
Router::post(DotEnv::env('APP_URL') . '/contacts', [ContactController::class, 'store']); 
Router::get(DotEnv::env('APP_URL') . '/contacts/{id}', [DashboardContactsController::class, 'index']);
Router::post(DotEnv::env('APP_URL') . '/contacts/delete/{id}', [DashboardContactsController::class, 'delete']);


Router::get(DotEnv::env('APP_URL') . '/about_us/{id}', [DashboardAboutController::class, 'index']); 
Router::post(DotEnv::env('APP_URL') . '/about_us/update/{id}', [DashboardAboutController::class, 'update']); 
