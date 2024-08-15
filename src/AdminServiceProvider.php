<?php

namespace SmallRuralDog\Admin;

use Arr;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{

    protected array $routeMiddleware = [
        'admin.auth' => Middleware\AuthCheck::class,
        'admin.bootstrap' => Middleware\Bootstrap::class,
        'admin.session' => Middleware\Session::class,
        'admin.permission' => Middleware\PermissionCheck::class,
    ];

    protected array $middlewareGroups = [
        'admin' => [
            'admin.auth',
            'admin.bootstrap',
            'admin.session',
            'admin.permission',
        ],
    ];

    public function boot(): void
    {

        //发布配置文件
        $this->publishes([
            __DIR__ . '/../config/admin.php' => config_path('admin.php'),
        ], 'admin-config');

        //发布资源文件
        $this->publishes([
            __DIR__ . '/../admin-web/dist/amis' => public_path('admin/amis'),
            //__DIR__ . '/../admin-web/dist/assets' => public_path('admin/assets'),
        ], 'admin-assets');

        //加载迁移文件
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        //加载路由文件
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        //加载自定义路由文件
        if (file_exists($routes = admin_path('routes.php'))) {
            $this->loadRoutesFrom($routes);
        }
        //加载视图文件
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');


    }

    public function register(): void
    {
        //合并配置文件
        $this->mergeConfigFrom(__DIR__ . '/../config/admin.php', 'admin');

        //注册服务
        $this->app->singleton('admin', function () {
            return new AdminService();
        });

        $this->loadAdminAuthConfig();
        $this->registerRouteMiddleware();

    }

    protected function loadAdminAuthConfig(): void
    {
        config(Arr::dot(config('admin.auth', []), 'auth.'));
    }

    protected function registerRouteMiddleware(): void
    {
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
