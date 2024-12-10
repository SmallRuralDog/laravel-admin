<?php

namespace SmallRuralDog\Admin\Controllers;

use Admin;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class IndexController extends AdminBase
{

    public array $noNeedLogin = ['root', 'index','setLang'];

    public array $noNeedPermission = ['root', 'index','setLang', 'userMenus'];

    public function index(Request $request)
    {
        return redirect(route('admin.root'));
    }

    public function setLang(Request $request): JsonResponse
    {
        try {
            $lang = $request->input('lang');
            $cookie = cookie('admin-language', $lang, 60*24*10);
            return amis_data([])->cookie($cookie);
        } catch (Exception $exception) {
            return amis_error($exception->getMessage());
        }

    }

    public function root(Request $request): Response
    {
        $theme = $request->cookie('arco-theme');

        $data['amisVersion'] = $amisVersion = '@6.10.0';
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
            'openCaptcha' => false,
            'captchaUrl' => route('admin.auth.captcha'),
            'language' => config('admin.language'),
            'currentLanguage' => $request->cookie('admin-language') ?: config('admin.language.default'),
        ];

        $data['config'] = $config;


        return response()->view('admin::root', $data);

    }

    public function userMenus(Request $request): JsonResponse
    {
        try {
            $menus = Admin::userInfo()->getMenus();
            return amis_data($menus);
        } catch (HttpException $exception) {
            return amis_error($exception->getMessage());
        }

    }

}
