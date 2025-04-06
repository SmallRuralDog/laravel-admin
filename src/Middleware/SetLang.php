<?php

namespace SmallRuralDog\Admin\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLang
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->cookie('admin-language')) {
            $adminLanguage = $request->cookie('admin-language');
            // - 替换成 _
            $adminLanguage = str_replace('-', '_', $adminLanguage);
            app()->setLocale($adminLanguage);
        }else{
            app()->setLocale(admin_config('language.default'));
        }
        return $next($request);
    }
}
