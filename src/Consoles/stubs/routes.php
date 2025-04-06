<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\HomeController;
use App\Admin\Controllers\SettingsController;

Route::group([
    'domain' => config('admin.route.domain'),
    'prefix' => config('admin.route.prefix', 'admin'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/home', [HomeController::class, 'index']);
    $router->get('/system/setting', [SettingsController::class, 'index']);
    $router->post('/system/setting', [SettingsController::class, 'save']);
});
