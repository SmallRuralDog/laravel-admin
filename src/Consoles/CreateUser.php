<?php

namespace SmallRuralDog\Admin\Consoles;

use Illuminate\Console\Command;

class CreateUser extends Command
{
    protected $signature = 'admin:create-administrator';

    protected $description = 'Create a new administrator';



    public function handle()
    {
        $this->info('Creating user...');

        //输入用户名
        $username = $this->ask('Enter username');
        //输入密码
        $password = $this->secret('Enter password');

        //创建用户
        $user = new \SmallRuralDog\Admin\Models\SystemUser();
        $user->username = $username;
        $user->password = bcrypt($password);
        $user->save();

        $role = \SmallRuralDog\Admin\Models\SystemRole::query()->where('name', 'administrator')->first();
        if ($role) {
            $user->roles()->sync([$role->id]);
        }

        $this->info('User created successfully.');
    }

}
