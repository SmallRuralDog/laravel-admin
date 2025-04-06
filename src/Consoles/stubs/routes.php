<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\HomeController;
Route::group([
    'domain' => config('admin.route.domain'),
    'prefix' => config('admin.route.prefix', 'admin'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/home', [HomeController::class, 'index']);
});
