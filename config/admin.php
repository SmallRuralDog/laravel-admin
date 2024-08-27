<?php

use SmallRuralDog\Admin\Models\SystemUser;

return [
    'title' => env('ADMIN_TITLE', 'Laravel Admin'),//后台标题
    'domain' => env('ADMIN_DOMAIN'),//后台域名

    'logo' => '//p3-armor.byteimg.com/tos-cn-i-49unhts6dw/dfdba5317c0c20ce20e64fac803d52bc.svg~tplv-49unhts6dw-image.image',
    'loginBanner' => [
        [
            'title' => '开箱即用的后台解决方案',
            'image' => 'https://vuejs-core.cn/vue-admin-arco/static/png/login-banner-Cqtv5-d6.png',
            'desc' => '权限，菜单，数据管理等功能',
        ],
    ],
    'loginTitle' => '登录',
    'loginDesc' => '欢迎登录',

    'directory' => app_path('Admin'),
    'bootstrap' => app_path('Admin/bootstrap.php'),
    'route' => [
        'domain' => env('ADMIN_ROUTE_DOMAIN'),
        'prefix' => env('ADMIN_ROUTE_PREFIX', 'adm'),
        'middleware' => ['web', 'admin'],
    ],
    'auth' => [
        'guard' => 'admin',
        'guards' => [
            'admin' => [
                'driver' => 'session',
                'provider' => 'admin',
            ],
        ],
        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model' => SystemUser::class,
            ],
        ],
    ],
];
