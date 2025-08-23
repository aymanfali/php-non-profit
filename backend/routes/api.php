<?php

use App\Controllers\AuthController;
use App\Controllers\ContactController;
use App\Controllers\Dashboard\DashboardAboutController;
use App\Controllers\Dashboard\DashboardContactsController;
use App\Controllers\Dashboard\DashboardHomeController;
use App\Controllers\Dashboard\DashboardImpactController;
use App\Controllers\Dashboard\DashboardNewsController;
use App\Controllers\Dashboard\DashboardSettingsController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Core\DotEnv;
use App\Core\Router;

// Auth API endpoints
Router::post(DotEnv::env('APP_URL') . '/auth/login', [AuthController::class, 'login']);
Router::post(DotEnv::env('APP_URL') . '/auth/register', [AuthController::class, 'register']);
Router::get(DotEnv::env('APP_URL') . '/auth/check', [AuthController::class, 'checkSession']);
Router::get(DotEnv::env('APP_URL') . '/auth/logout', [AuthController::class, 'logout']);

// main dashboard API endpoint
Router::get(DotEnv::env('APP_URL') . '/dashboard', [DashboardHomeController::class, 'index']);

// users dashboard API endpoint
Router::get(DotEnv::env('APP_URL') . '/users', [UserController::class, 'index']); 
Router::get(DotEnv::env('APP_URL') . '/users/{id}', [UserController::class, 'index']);
Router::post(DotEnv::env('APP_URL') . '/users', [UserController::class, 'store']); 
Router::post(DotEnv::env('APP_URL') . '/users/update/{id}', [UserController::class, 'update']); 
Router::post(DotEnv::env('APP_URL') . '/users/delete/{id}', [UserController::class, 'delete']);

// impacts dashboard API endpoints
Router::get(DotEnv::env('APP_URL') . '/impacts', [DashboardImpactController::class, 'index']); 
Router::get(DotEnv::env('APP_URL') . '/impacts/{id}', [DashboardImpactController::class, 'index']);
Router::post(DotEnv::env('APP_URL') . '/impacts', [DashboardImpactController::class, 'store']); 
Router::post(DotEnv::env('APP_URL') . '/impacts/update/{id}', [DashboardImpactController::class, 'update']); 
Router::post(DotEnv::env('APP_URL') . '/impacts/delete/{id}', [DashboardImpactController::class, 'delete']);

// news dashboard API endpoints
Router::get(DotEnv::env('APP_URL') . '/news', [DashboardNewsController::class, 'index']); 
Router::get(DotEnv::env('APP_URL') . '/news/{id}', [DashboardNewsController::class, 'index']);
Router::post(DotEnv::env('APP_URL') . '/news', [DashboardNewsController::class, 'store']); 
Router::post(DotEnv::env('APP_URL') . '/news/update/{id}', [DashboardNewsController::class, 'update']); 
Router::post(DotEnv::env('APP_URL') . '/news/delete/{id}', [DashboardNewsController::class, 'delete']);

// contacts dashboard API endpoints
Router::get(DotEnv::env('APP_URL') . '/contacts', [DashboardContactsController::class, 'index']); 
Router::post(DotEnv::env('APP_URL') . '/contacts', [ContactController::class, 'store']); 
Router::get(DotEnv::env('APP_URL') . '/contacts/{id}', [DashboardContactsController::class, 'index']);
Router::post(DotEnv::env('APP_URL') . '/contacts/delete/{id}', [DashboardContactsController::class, 'delete']);

// about_us dashboard API endpoints
Router::get(DotEnv::env('APP_URL') . '/about_us/{id}', [DashboardAboutController::class, 'index']); 
Router::post(DotEnv::env('APP_URL') . '/about_us/update/{id}', [DashboardAboutController::class, 'update']);

// settings dashboard API endpoints to delete data
Router::post(DotEnv::env('APP_URL') . '/settings/delete_users', [DashboardSettingsController::class, 'destroyUsers']);
Router::post(DotEnv::env('APP_URL') . '/settings/delete_news', [DashboardSettingsController::class, 'destroyNews']);
Router::post(DotEnv::env('APP_URL') . '/settings/delete_impacts', [DashboardSettingsController::class, 'destroyImpacts']);
Router::post(DotEnv::env('APP_URL') . '/settings/delete_contacts', [DashboardSettingsController::class, 'destroyContacts']);

// website public API endpoints
Router::get(DotEnv::env('APP_URL') . '/', [HomeController::class, 'index']);
Router::get(DotEnv::env('APP_URL') . '/impacts/view/{id}', [HomeController::class, 'view']);
