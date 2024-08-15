<?php

namespace SmallRuralDog\Admin\Middleware;

use Admin;
use Closure;
use Exception;
use Illuminate\Http\Request;
use ReflectionClass;

class PermissionCheck
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $controller = new ReflectionClass($request->route()->getController());
            $noNeedLogin = $controller->getDefaultProperties()['noNeedLogin'] ?? [];
            $noNeedPermission = $controller->getDefaultProperties()['noNeedPermission'] ?? [];
            $noNeedAction = array_merge($noNeedLogin, $noNeedPermission);
            if (!in_array($request->route()->getActionMethod(), $noNeedAction)) {
                Admin::checkRoutePermission($request);
            }
            return $next($request);
        } catch (Exception $exception) {
            return amis_error($exception->getMessage(), 403);
        }
    }

}
