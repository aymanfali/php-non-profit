<?php

use App\Controllers\AboutController;
use App\Controllers\AuthController;
use App\Controllers\ContactController;
use App\Controllers\Dashboard\UserController;
use App\Controllers\Dashboard\DashboardAboutController;
use App\Controllers\Dashboard\DashboardContactsController;
use App\Controllers\Dashboard\DashboardHomeController;
use App\Controllers\Dashboard\DashboardImpactController;
use App\Controllers\Dashboard\DashboardNewsController;
use App\Controllers\Dashboard\DashboardSettingsController;
use App\Controllers\ImpactsController;
use App\Controllers\NewsController;
use App\Core\DotEnv;
use App\Core\Router;

$base = DotEnv::env('APP_URL');

// grouping helper function
function group(string $prefix, $callback)
{
    $callback($prefix);
}

/**
 * ==============
 * AUTH ROUTES
 * ==============
 */
group($base . '/auth', function ($prefix) {
    Router::post("$prefix/login", [AuthController::class, 'login']);
    Router::post("$prefix/register", [AuthController::class, 'register']);
    Router::get("$prefix/check", [AuthController::class, 'checkSession']);
    Router::get("$prefix/logout", [AuthController::class, 'logout']);
});

/**
 * ==============
 * DASHBOARD ROUTES
 * ==============
 */
group($base . '/dashboard', function ($prefix) {
    Router::get($prefix, [DashboardHomeController::class, 'index']);

    // Users
    group($prefix . '/users', function ($p) {
        Router::get($p, [UserController::class, 'index']);
        Router::get("$p/{id}", [UserController::class, 'index']);
        Router::post($p, [UserController::class, 'store']);
        Router::post("$p/update/{id}", [UserController::class, 'update']);
        Router::post("$p/delete/{id}", [UserController::class, 'delete']);
    });

    // Impacts
    group($prefix . '/impacts', function ($p) {
        Router::get($p, [DashboardImpactController::class, 'index']);
        Router::get("$p/{id}", [DashboardImpactController::class, 'index']);
        Router::post($p, [DashboardImpactController::class, 'store']);
        Router::post("$p/update/{id}", [DashboardImpactController::class, 'update']);
        Router::post("$p/delete/{id}", [DashboardImpactController::class, 'delete']);
    });

    // News
    group($prefix . '/news', function ($p) {
        Router::get($p, [DashboardNewsController::class, 'index']);
        Router::get("$p/{id}", [DashboardNewsController::class, 'index']);
        Router::post($p, [DashboardNewsController::class, 'store']);
        Router::post("$p/update/{id}", [DashboardNewsController::class, 'update']);
        Router::post("$p/delete/{id}", [DashboardNewsController::class, 'delete']);
    });

    // Contacts
    group($prefix . '/contacts', function ($p) {
        Router::get($p, [DashboardContactsController::class, 'index']);
        Router::get("$p/{id}", [DashboardContactsController::class, 'index']);
        Router::post("$p/delete/{id}", [DashboardContactsController::class, 'delete']);
    });

    // About Us
    group($prefix . '/about_us', function ($p) {
        Router::get("$p/{id}", [DashboardAboutController::class, 'index']);
        Router::post("$p/update/{id}", [DashboardAboutController::class, 'update']);
    });

    // Settings
    group($prefix . '/settings', function ($p) {
        Router::post("$p/delete_users", [DashboardSettingsController::class, 'destroyUsers']);
        Router::post("$p/delete_news", [DashboardSettingsController::class, 'destroyNews']);
        Router::post("$p/delete_impacts", [DashboardSettingsController::class, 'destroyImpacts']);
        Router::post("$p/delete_contacts", [DashboardSettingsController::class, 'destroyContacts']);
    });
});

/**
 * ==============
 * PUBLIC WEBSITE ROUTES
 * ==============
 */
group($base, function ($prefix) {
    // Impacts
    Router::get("$prefix/impacts", [ImpactsController::class, 'index']);
    Router::get("$prefix/impacts/{id}", [ImpactsController::class, 'show']);

    // News
    Router::get("$prefix/news", [NewsController::class, 'index']);
    Router::get("$prefix/news/{id}", [NewsController::class, 'show']);

    // About
    Router::get("$prefix/about_us", [AboutController::class, 'show']);

    // Contacts
    Router::post("$prefix/contacts", [ContactController::class, 'store']);
});
