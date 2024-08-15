<?php


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use SmallRuralDog\Admin\Controllers\AuthController;
use SmallRuralDog\Admin\Controllers\IndexController;


Route::group([
    'domain' => config('amis-admin.route.domain'),
    'prefix' => config('amis-admin.route.prefix', 'admin'),
    'middleware' => config('amis-admin.route.middleware'),
], static function (Router $router) {
    $router->get('/', [IndexController::class, "root"]);
    $router->get('/view', [IndexController::class, "root"]);
    $router->get('/view/{name}', [IndexController::class, "root"]);

    Route::get('/auth/captcha', [AuthController::class, 'captcha'])->name('admin.auth.captcha');
});
