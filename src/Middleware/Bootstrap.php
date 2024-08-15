<?php

namespace SmallRuralDog\Admin\Middleware;

use Admin;
use Closure;
use Illuminate\Http\Request;

class Bootstrap
{
    public function handle(Request $request, Closure $next)
    {
        Admin::bootstrap();
        return $next($request);
    }

}
