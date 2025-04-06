<?php

namespace SmallRuralDog\Admin\Consoles;

use Illuminate\Console\Command;
use SmallRuralDog\Admin\Models\AdminTablesSeeder;
use SmallRuralDog\Admin\Models\SystemUser;

class Update extends Command
{
    protected $signature = 'admin:update';

    protected $description = '更新 Laravel Admin';

    public function handle()
    {
        $this->publishAssets();
    }

    /**
     * 发布资源
     */
    public function publishAssets(): void
    {
        $this->info('开始发布资源');
        $this->call('vendor:publish', ['--tag' => 'admin-assets']);
        $this->info('资源发布完成');
    }

}
