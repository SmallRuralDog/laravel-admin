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
    }

    public function initDatabase(): void
    {
        $this->call('migrate');
        if (SystemUser::query()->count() == 0) {
            $this->call('db:seed', ['--class' => AdminTablesSeeder::class]);
        }
    }

}
