<?php

namespace SmallRuralDog\Admin;

use AdminService;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{

    public function boot(): void
    {

        //发布配置文件
        $this->publishes([
            __DIR__ . '/../config/admin.php' => config_path('admin.php'),
        ]);
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

    }
}
