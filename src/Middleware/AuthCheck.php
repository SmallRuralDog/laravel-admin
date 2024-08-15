<?php

namespace SmallRuralDog\Admin\Middleware;

use Admin;
use Closure;
use Exception;
use Illuminate\Http\Request;
use ReflectionClass;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $controller = new ReflectionClass($request->route()->getController());
            $noNeedLogin = $controller->getDefaultProperties()['noNeedLogin'] ?? [];
            $action = $request->route()->getActionMethod();
            if (!in_array($action, $noNeedLogin)) {
                abort_if(Admin::guard()->guest(), 401, '请登录后再操作');
                $user = Admin::userInfo();
                $user->initPermission();
            }
            return $next($request);
        } catch (Exception $exception) {
            if ($request->ajax() || $request->wantsJson()) {
                return amis_error($exception->getMessage(), 401);
            }
            return redirect(admin_url('view/login'));
        }

    }
}
