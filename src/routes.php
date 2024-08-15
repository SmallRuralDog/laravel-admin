<?php


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use SmallRuralDog\Admin\Controllers\AuthController;
use SmallRuralDog\Admin\Controllers\IndexController;


Route::group([
    'domain' => config('admin.route.domain'),
    'prefix' => config('admin.route.prefix', 'admin'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', [IndexController::class, "root"]);
    $router->get('/view', [IndexController::class, "root"]);
    $router->get('/view/{name}', [IndexController::class, "root"]);

    Route::get('/auth/captcha', [AuthController::class, 'captcha'])->name('admin.auth.captcha');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('admin.auth.login');
});
