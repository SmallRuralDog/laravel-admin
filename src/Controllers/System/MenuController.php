<?php

namespace SmallRuralDog\Admin\Controllers\System;

use Admin;
use App\Models\User;
use Arr;
use SmallRuralDog\Admin\Components\Custom\MenuComponent;
use SmallRuralDog\Admin\Components\Form;
use SmallRuralDog\Admin\Components\Grid;
use SmallRuralDog\Admin\Controllers\AdminController;
use SmallRuralDog\Admin\Models\SystemMenu;
use SmallRuralDog\Admin\Renderer\Form\Group;
use SmallRuralDog\Admin\Renderer\Form\InputNumber;
use SmallRuralDog\Admin\Renderer\Form\InputSwitch;
use SmallRuralDog\Admin\Renderer\Form\Radios;
use SmallRuralDog\Admin\Renderer\Tpl;
use Validator;

class MenuController extends AdminController
{

    protected function grid()
    {
        return Grid::make(SystemMenu::query(), function (Grid $grid) {

            $grid->builder()->orderByDesc('order');
            $grid
                ->hideFooter()
                ->loadDataOnce()
                ->toTree();
            $grid->useCRUD()
                ->expandConfig([
                    'expand' => 'first'
                ])
                ->columnsTogglable(false)
                ->perPage(100)
                ->keepItemSelectionOnPageChange(true);

            $grid->column('name', '名称');
            $grid->column('icon', '图标')->useTableColumn(Tpl::make()->tpl('<i class="${icon} mr-2"></i>${icon}'))->width(150);
            $grid->column('type', '类型')->mapping(SystemMenu::TYPE_LABEL);
            $grid->column('path', '节点路由');
            $grid->column('permission', '权限标识');
            $grid->column('order', '排序')->inputNumber();
            $grid->column('show', '显示')->status();
            $grid->column('status', '启用')->status();
            $grid->column('updated_at', '更新时间');

            $grid->drawer();
            $grid->setDialogFormSize('lg');
        });
    }

    protected function form()
    {
        return Form::make(SystemMenu::query(), function (Form $form) {

            $form->customLayout([

                $form->item('type', '菜单类型')
                    ->value('dir')
                    ->useFormItem(
                        Radios::make()->options([
                            'dir' => '目录',
                            'menu' => '菜单',
                            'permission' => '权限',
                        ])
                    )->disabled($this->isEdit),
                $form->item('name', '节点名称')
                    ->required()
                    ->useFormItem(),
                $form->item('parent_id', '上级节点')->value(0)->useFormItem(MenuComponent::make()->routeParentSelect()),

                $form->item('path', '路由地址')
                    ->useFormItem(MenuComponent::make()->routePathInput())->requiredOn('type=="menu"')->visibleOn('(type=="menu" || type=="permission") && name'),

                $form->item('auto_son_permission', '自动生成资源路由子权限')
                    ->labelRemark('会根据路由地址，自动查找出资源路由，并生成对应的权限')
                    ->useFormItem(MenuComponent::make()->routePermissionInput())
                    ->visibleOn('type=="menu" && name && path'),

                $form->item('permission', '权限')
                    ->useFormItem()
                    ->required(true)
                    ->visibleOn('type=="permission"'),


                $form->item('icon', '节点图标')
                    ->useFormItem()
                    ->required(true)
                    ->visibleOn('type=="dir"')
                    ->description("查看图标列表 <a target='_blank' href='https://fontawesome.com/search?m=free'>Font Awesome</a>")
                    ->placeholder("例如：fa-solid fa-house"),
                $form->item('order', '排序')
                    ->value(1)
                    ->vRequired()
                    ->vInteger()
                    ->vBetween(1, 99999)
                    ->useFormItem(InputNumber::make()),

                Group::make()->body([
                    $form->item('is_ext', '是否外链')->value(false)->useFormItem(InputSwitch::make())->columnRatio(2),
                    $form->item('ext_open_mode', '外链打开方式')
                        ->value('blank')
                        ->useFormItem(Radios::make()->options([
                            'self' => '当前窗口',
                            'blank' => '新窗口',
                        ]))->visibleOn('is_ext'),
                ]),
                Group::make()->body([
                    $form->item('show', '是否显示')->value(true)->useFormItem(InputSwitch::make())->columnRatio(2),
                    $form->item('active_menu', '高亮菜单')->useFormItem(MenuComponent::make()->routeParentSelect())->visibleOn('!show'),
                ]),
                $form->item('status', '状态')->value(true)->useFormItem(InputSwitch::make()),

            ]);

            $form->useValidatorEnd(function (Form $form, array $data) {
                if (data_get($data, 'is_ext')) {
                    $validator = Validator::make($data, [
                        'path' => 'required|url',
                    ]);
                    return $form->validator($validator);
                }
                return null;
            });

            $form->saved(function (Form $form) {
                $auto_son_permission = request()->input('auto_son_permission', []);
                $this->autoCreateMenuSonPermission($form->model(), $auto_son_permission);
            });

            $form->ignored('auto_son_permission');
        });
    }

    private function autoCreateMenuSonPermission(SystemMenu $systemMenu, array $auto_son_permission)
    {

        $count = count($auto_son_permission);

        foreach ($auto_son_permission as $index => $routeName) {
            $permissionName = get_name_by_resource_route($routeName);

            SystemMenu::query()
                ->updateOrCreate([
                    'type' => 'permission',
                    'parent_id' => $systemMenu->getKey(),
                    'permission' => $routeName,
                ], [
                    'name' => $permissionName,
                    'order' => $count - $index,
                ]);
        }
    }
}
