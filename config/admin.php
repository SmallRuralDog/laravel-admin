<?php
return [
    'title' => env('ADMIN_TITLE', 'Laravel Admin'),//后台标题
    'domain' => env('ADMIN_DOMAIN'),//后台域名

    'logo' => '//p3-armor.byteimg.com/tos-cn-i-49unhts6dw/dfdba5317c0c20ce20e64fac803d52bc.svg~tplv-49unhts6dw-image.image',
    'loginBanner' => [
        [
            'title' => '内置了常见问题的解决方案',
            'image' => 'https://vuejs-core.cn/vue-admin-arco/static/png/login-banner-Cqtv5-d6.png',
            'desc' => '国际化，路由配置，状态管理应有尽有'
        ],
    ],
    'loginTitle' => '登录',
    'loginDesc' => '欢迎登录',

    'path' => 'admin',
    'route' => [
        'middleware' => ['web', 'auth'],
        'domain' => env('ADMIN_ROUTE_DOMAIN'),
        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),
    ],
];
