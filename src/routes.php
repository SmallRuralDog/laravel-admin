<?php


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use SmallRuralDog\Admin\Controllers\AuthController;
use SmallRuralDog\Admin\Controllers\HandleController;
use SmallRuralDog\Admin\Controllers\IndexController;
use SmallRuralDog\Admin\Controllers\System\DeptController;
use SmallRuralDog\Admin\Controllers\System\MenuController;
use SmallRuralDog\Admin\Controllers\System\RoleController;
use SmallRuralDog\Admin\Controllers\System\UserController;


Route::group([
    'domain' => config('admin.route.domain'),
    'prefix' => config('admin.route.prefix', 'admin'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', [IndexController::class, "index"]);
    $router->get('/view', [IndexController::class, "root"])->name('admin.root');
    $router->get('/view/{name}', [IndexController::class, "root"])->where('name', '.*');
    $router->get('/setLang', [IndexController::class, "setLang"])->name('admin.setLang');

    $router->any('/handleAction', [HandleController::class, 'action'])->name('admin.handleAction');

    $router->post('/uploadImage', [HandleController::class, 'uploadImage'])->name('admin.handleUploadImage');
    $router->post('/uploadFile', [HandleController::class, 'uploadFile'])->name('admin.handleUploadFile');

    $router->get('/userMenus', [IndexController::class, 'userMenus']);

    $router->get('/auth/captcha', [AuthController::class, 'captcha'])->name('admin.auth.captcha');
    $router->post('/auth/login', [AuthController::class, 'login'])->name('admin.auth.login');
    $router->get('/auth/logout', [AuthController::class, 'logout'])->name('admin.auth.logout');


    $router->resource("/system/dept", DeptController::class)->names('admin.system.dept');
    $router->resource("/system/menu", MenuController::class)->names('admin.system.menu');
    $router->resource("/system/role", RoleController::class)->names('admin.system.role');
    $router->resource("/system/user", UserController::class)->names('admin.system.user');

    $router->any("/userSetting", [AuthController::class, 'userSetting'])->name('admin.userSetting');

});
