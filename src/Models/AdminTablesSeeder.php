<?php

namespace SmallRuralDog\Admin\Models;

use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    public function run()
    {

        SystemUser::truncate();
        $administrator = SystemUser::query()->create([
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'name' => '超级管理员',
            'dept_id' => 0,
            'create_user_id' => 0,
        ]);
        SystemRole::truncate();
        $administratorRole = SystemRole::query()->create([
            'name' => '超级管理员',
            'slug' => 'administrator',
        ]);
        $administrator->roles()->attach($administratorRole->getKey());

        $menus = [
            [
                'type' => 'dir',
                'name' => "admin::admin.dashboard",//仪表盘
                'icon' => 'fa-solid fa-gauge',
                'order' => 99,
                'children' => [
                    [
                        'type' => 'menu',
                        'name' => 'admin::admin.data_overview',//数据概览
                        'path' => 'home',
                        'order' => 1,
                    ]
                ]
            ],
            [
                'type' => 'dir',
                'name' => 'admin::admin.system_management',//系统管理
                'icon' => 'fa-solid fa-gear',
                'order' => 98,
                'children' => [
                    [
                        'type' => 'menu',
                        'name' => 'admin::admin.user_management',//用户管理
                        'path' => 'system/user',
                        'order' => 96,
                        'resource' => true,
                        'resource_names' => 'admin.system.user',
                        'children' => [
                            [
                                'type' => 'menu',
                                'name' => 'admin::admin.user_setting',//个人设置
                                'order' => 1,
                                'path' => 'userSetting',
                                'show' => false,
                            ]
                        ]
                    ],
                    [
                        'type' => 'menu',
                        'name' => 'admin::admin.role_management',//角色管理
                        'path' => 'system/role',
                        'order' => 97,
                        'resource' => true,
                        'resource_names' => 'admin.system.role'

                    ],
                    [
                        'type' => 'menu',
                        'name' => 'admin::admin.dept_management',//部门管理
                        'path' => 'system/dept',
                        'order' => 99,
                        'resource' => true,
                        'resource_names' => 'admin.system.dept'
                    ],
                    [
                        'type' => 'menu',
                        'name' => 'admin::admin.menu_management',//菜单管理
                        'path' => 'system/menu',
                        'order' => 98,
                        'resource' => true,
                        'resource_names' => 'admin.system.menu'
                    ],
                    [
                        'type' => 'menu',
                        'name' => 'admin::admin.setting_management',//配置管理
                        'path' => 'system/setting',
                        'order' => 95,
                    ],
                ]
            ]
        ];

        SystemMenu::truncate();

        foreach ($menus as $menu) {

            $menuITem = SystemMenu::query()->create([
                'type' => $menu['type'],
                'name' => $menu['name'],
                'icon' => $menu['icon'],
                'order' => $menu['order'],
                'path' => $menu['path'] ?? '',
            ]);
            if (isset($menu['children'])) {

                foreach ($menu['children'] as $child) {
                    $childItem = SystemMenu::query()->create([
                        'type' => $child['type'],
                        'name' => $child['name'],
                        'order' => $child['order'],
                        'parent_id' => $menuITem->getKey(),
                        'path' => $child['path'] ?? '',
                    ]);
                    if (isset($child['resource'])) {
                        $resourceArr = ['.index', '.create', '.edit', '.destroy', '.store', '.update'];
                        foreach ($resourceArr as $r) {
                            $permissionName = get_name_by_resource_route($r);
                            SystemMenu::query()->create([
                                'type' => 'permission',
                                'name' => $permissionName,
                                'order' => 1,
                                'parent_id' => $childItem->getKey(),
                                'permission' => $child['resource_names'] . $r,
                            ]);
                        }
                    }
                    if (isset($child['children'])) {
                        foreach ($child['children'] as $subChild) {
                            SystemMenu::query()->create([
                                'type' => $subChild['type'],
                                'name' => $subChild['name'],
                                'order' => $subChild['order'],
                                'parent_id' => $childItem->getKey(),
                                'path' => $subChild['path'] ?? '',
                                'show' => $subChild['show'] ?? true,
                                'active_menu' => (string)$childItem->getKey(),
                            ]);
                        }
                    }
                }
            }
        }

    }
}
