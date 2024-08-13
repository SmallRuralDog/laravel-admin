<?php
return [
    'path' => 'admin',

    'route' => [
        'middleware' => ['web', 'auth'],
        'domain' => env('ADMIN_ROUTE_DOMAIN'),
        'prefix' => env('ADMIN_ROUTE_PREFIX','admin'),
    ],
];
