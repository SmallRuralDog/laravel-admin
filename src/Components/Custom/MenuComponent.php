<?php

namespace SmallRuralDog\Admin\Components\Custom;

use Illuminate\Http\Request;
use Route;
use SmallRuralDog\Admin\Components\Enhance\AutoRoute;
use SmallRuralDog\Admin\Models\SystemMenu;
use SmallRuralDog\Admin\Renderer\Form\Checkboxes;
use SmallRuralDog\Admin\Renderer\Form\InputText;
use SmallRuralDog\Admin\Renderer\Form\TreeSelect;

class MenuComponent extends AutoRoute
{

    public function routeParentSelect()
    {
        return TreeSelect::make()
            ->labelField('name')
            ->valueField("id")
            ->source($this->action('_routeParentSelect', [
                'type' => '${type}'
            ]));
    }

    public function _routeParentSelect(Request $request)
    {
        $type = $request->input('type');

        $orm = SystemMenu::query();

        if ($type == "menu") {
            $orm->whereIn('type', ['dir', 'menu']);
        }
        if ($type == "permission") {
            $orm->whereIn('type', ['dir', 'menu']);
        }
        if ($type == "dir") {
            $list = [];
        } else {
            $list = $orm
                ->orderByDesc('order')
                ->get()
                ->map(function ($item) {
                    $item->name = __($item->name);
                    return $item;
                })
                ->toArray();
        }

        return amis_data([
            ['id' => 0, 'name' => __("admin::admin.root"), 'children' => arr2tree($list)],
        ]);
    }

    public function routePathInput()
    {

        return InputText::make()->autoComplete($this->action('routePathInputAutoComplete', [
            'path' => '${path}'
        ]));
    }

    public function routePathInputAutoComplete(Request $request)
    {
        $path = $request->input('path');
        $routes = Route::getRoutes();

        $itemRoute = [];

        $suffix = admin_config('route.prefix');

        $nameList = ['.create', '.edit', '.destroy', '.store', '.update'];

        $hiddenList = ['view', 'handleAction','uploadImage','uploadFile','userMenus','auth/captcha', 'auth/login', 'auth/logout'];
        $hiddenList = array_merge($hiddenList, admin_config('hidden_routes', []));
        $hiddenList = array_merge($hiddenList, SystemMenu::query()->pluck('path')->toArray());


        /** @var \Illuminate\Routing\Route $route */
        foreach ($routes as $route) {
            $routePath = $route->uri();
            //不是$suffix 开始的路由不显示
            if (!str_starts_with($routePath, $suffix)) {
                continue;
            }

            $isCheck = false;
            foreach ($nameList as $name) {
                $routeName = $route->getName();
                if ($routeName && str_ends_with($routeName, $name)) {
                    $isCheck = true;
                    break;
                }
            }
            if ($isCheck) {
                continue;
            }


            $routePath = str_replace($suffix, '', $routePath);

            if (str_starts_with($routePath, '/')) {
                $routePath = substr($routePath, 1);
            }
            if ($path && !str_starts_with($routePath, $path)) continue;

            //有参数的路由不显示
            if (str_contains($routePath, '{')) {
                continue;
            }

            if (in_array($routePath, $hiddenList)) {
                continue;
            }


            $itemRoute[] = $routePath;
        }
        //数组去重
        $itemRoute = array_unique($itemRoute);
        return amis_data($itemRoute);
    }

    public function routePermissionInput()
    {
        $api = $this->action('_routePermissionInput', [
            'path' => '${path}'
        ]);
        return Checkboxes::make()
            ->source($api)
            ->joinValues(false)
            ->extractValue(true)
            ->columnsCount([1, 2, 2, 2, 2, 2])
            ->checkAll(true);

    }

    public function _routePermissionInput(Request $request, array $data)
    {
        $path = $request->input('path');
        if (!$path) {
            return amis_data([]);
        }
        $suffix = admin_config('route.prefix');
        $itemRoute = [];
        $nameList = ['.index', '.create', '.edit', '.destroy', '.store', '.update'];

        $routes = Route::getRoutes();

        /** @var \Illuminate\Routing\Route $route */
        foreach ($routes as $route) {
            $routePath = $route->uri();
            $routeName = $route->getName();
            //不是$suffix 开始的路由不显示
            if (!str_starts_with($routePath, $suffix)) {
                continue;
            }
            $routePath = str_replace($suffix, '', $routePath);
            if (str_starts_with($routePath, '/')) {
                $routePath = substr($routePath, 1);
            }
            if($path && !str_starts_with($routePath, $path)) continue;

            //不是$nameList 结尾的路由不显示
            $isCheck = false;
            foreach ($nameList as $n) {
                if ($routeName && str_ends_with($routeName, $n)) {
                    $isCheck = true;
                    break;
                }
            }
            if (!$isCheck) {
                continue;
            }
            $itemRoute[] = [
                'label' => get_name_by_resource_route($routeName) . '-' . $routeName,
                'value' => $routeName,
            ];

        }
        return amis_data($itemRoute);
    }

}
