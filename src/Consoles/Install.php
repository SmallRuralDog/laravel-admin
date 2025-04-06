<?php

namespace SmallRuralDog\Admin\Consoles;

use Illuminate\Console\Command;
use SmallRuralDog\Admin\Models\AdminTablesSeeder;
use SmallRuralDog\Admin\Models\SystemUser;

class Install extends Command
{
    protected $signature = 'admin:install';

    protected $description = 'Install the Laravel Admin';

    public function handle()
    {
        $this->initDatabase();
        $this->publishAssets();
        $this->initAdminDirectory();
    }

    /**
     * 初始化数据库
     */
    public function initDatabase(): void
    {
        $this->call('migrate');
        if (SystemUser::query()->count() == 0) {
            $this->call('db:seed', ['--class' => AdminTablesSeeder::class]);
        }
    }
    /**
     * 发布资源
     */
    public function publishAssets(): void
    {
        $this->call('vendor:publish', ['--tag' => 'admin-assets']);
    }

    /**
     * 初始化 Admin 目录
     */
    public function initAdminDirectory(): void
    {
        //判断 admin 目录是否存在
        if (!is_dir(admin_config('directory'))) {
            //创建 admin 目录
            mkdir(admin_config('directory'));
        }
        //判断 admin/routes.php 文件是否存在
        if (!file_exists(admin_config('directory') . '/routes.php')) {
            //复制 routes.php 文件
            copy(__DIR__.('/stubs/routes.php'), admin_config('directory') . '/routes.php');
        }
        //判断 admin/bootstrap.php 文件是否存在
        if (!file_exists(admin_config('directory') . '/bootstrap.php')) {
            //复制 bootstrap.php 文件
            copy(__DIR__.('/stubs/bootstrap.php'), admin_config('directory') . '/bootstrap.php');
        }
        //判断 admin/Controllers 目录是否存在
        if (!is_dir(admin_config('directory') . '/Controllers')) {
            //创建 admin/Controllers 目录
            mkdir(admin_config('directory') . '/Controllers');
        }
        //判断 admin/Controllers/HomeController.php 文件是否存在
        if (!file_exists(admin_config('directory') . '/Controllers/HomeController.php')) {
            //复制 HomeController.php 文件
            copy(__DIR__.('/stubs/Controllers/HomeController.php'), admin_config('directory') . '/Controllers/HomeController.php');
        }
    }

}
