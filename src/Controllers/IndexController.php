<?php

namespace SmallRuralDog\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexController extends AdminBase
{


    public function root(Request $request): Response
    {
        $theme = $request->cookie('arco-theme');

        $data['amisVersion'] = $amisVersion = '6.7.0';
        $data['darkCss'] = '';
        if ($theme == 'dark') {
            $data['darkCss'] = ' <link rel="stylesheet" href="/admin/amis/@' . $amisVersion . '/dark.css"/>';
        }

        $config = [
            'title' => config('admin.title'),
            'logo' => config('admin.logo'),
            'loginBanner' => config('admin.loginBanner'),
            'loginTitle' => config('admin.loginTitle'),
            'loginDesc' => config('admin.loginDesc'),
            'apiBase' => admin_url("/"),
            'prefix' => config('admin.route.prefix'),
            'captchaUrl' => route('admin.auth.captcha')
        ];

        $data['config'] = $config;


        return response()->view('admin::root', $data);

    }
}
