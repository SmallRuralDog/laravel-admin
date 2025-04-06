<?php

namespace SmallRuralDog\Admin;

use Arr;
use Auth;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SmallRuralDog\Admin\Models\SystemDept;
use SmallRuralDog\Admin\Models\SystemUser;
use Validator;

class AdminService
{
    public static $scripts = [];

    public static $styles = [];





    public static function script($name, $path): static
    {
        static::$scripts[$name] = $path;

        return new static;
    }

    public static function style($name, $path): static
    {
        static::$styles[$name] = $path;

        return new static;
    }

    public static function scripts(): array
    {
        return static::$scripts;
    }

    public static function styles(): array
    {
        return static::$styles;
    }


    public function bootstrap()
    {
        require config('admin.bootstrap', admin_path('bootstrap.php'));
    }

    /**
     * 获取当前登录用户 ID
     * @return int
     */
    public function userId(): int
    {
        return (int)$this->userInfo()?->getKey();
    }

    /**
     * 获取当前登录用户
     */
    public function userInfo(): SystemUser|null
    {
        return $this->guard()?->user();
    }


    public function guard(): Guard|StatefulGuard|SessionGuard
    {
        $guard = config('admin.auth.guard') ?: 'admin';
        return Auth::guard($guard);
    }

    /**
     * 获取部门的所有子部门 ID
     */
    public function getDeptSonById(?int $deptId, bool $addSelf = false): array
    {
        $dept = SystemDept::query()->find($deptId);
        if (!$dept) {
            return [];
        }
        $list = $dept->getAllChildren();
        $col = collect($list)->pluck('id');
        if ($addSelf) {
            $col->prepend($dept->getKey());
        }
        return $col->toArray();
    }

    /**
     * 获取部门和下级部门的用户 ID
     */
    public function getDeptUserIds(int $deptId, bool $addSelf = false): array
    {
        $deptIds = self::getDeptSonById($deptId, $addSelf);
        $userIds = SystemUser::query()->whereIn('dept_id', $deptIds)->pluck('id');
        return $userIds->toArray();
    }


    /**
     * 检查权限
     */
    public function checkRoutePermission(Request $request): void
    {

        $user = $this->userInfo();
        abort_if(!$user, 401, '请登录');
        $route = $request->route();
        $name = $route->getName();

        if (!$name) {
            $name = $request->path();
            $suffix = admin_config('route.prefix');
            $name = str_replace($suffix, '', $name);
            if (str_starts_with($name, '/')) {
                $name = substr($name, 1);
            }
        }
        $hasPermission = $user->can($name);
        abort_if(!$hasPermission, 403, '没有权限');
    }

    public function validator($data, $rules, $message = []): ?JsonResponse
    {

        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            $lastMessage = collect($validator->errors()->messages())
                ->map(function ($item) {
                    return Arr::first($item);
                })
                ->toArray();
            return amis_error($lastMessage, 422);
        }
        return null;
    }
}
