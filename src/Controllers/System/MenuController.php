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

            $grid->useRow(function ($item) {
                $item->name = __($item->name);
                return $item;
            });

            $grid->useCRUD()
                ->expandConfig([
                    'expand' => 'first'
                ])
                ->columnsTogglable(false)
                ->perPage(100)
                ->keepItemSelectionOnPageChange(true);

            $grid->column('name', __("admin::admin.name"));
            $grid->column('icon', __("admin::admin.icon"))->useTableColumn(Tpl::make()->tpl('<i class="${icon} mr-2"></i>${icon}'))->width(150);
            $grid->column('type', __("admin::admin.type"))->mapping(SystemMenu::TYPE_LABEL);
            $grid->column('path', __("admin::admin.path"));
            $grid->column('permission', __("admin::admin.permission"));
            $grid->column('order', __("admin::admin.order"))->inputNumber();
            $grid->column('show', __("admin::admin.is_show"))->status();
            $grid->column('status', __("admin::admin.status"))->status();
            $grid->column('updated_at', __("admin::admin.updated_at"));

            $grid->drawer();
            $grid->setDialogFormSize('lg');
        });
    }

    protected function form()
    {
        return Form::make(SystemMenu::query(), function (Form $form) {

            $form->customLayout([

                $form->item('type', __("admin::admin.type"))
                    ->value('dir')
                    ->useFormItem(
                        Radios::make()->options([
                            'dir' => __("admin::admin.dir"),
                            'menu' => __("admin::admin.menu"),
                            'permission' => __("admin::admin.permission"),
                        ])
                    )->disabled($this->isEdit),
                $form->item('name', __("admin::admin.name"))
                    ->required()
                    ->useFormItem(),
                $form->item('parent_id', __("admin::admin.parent"))->value(0)->useFormItem(MenuComponent::make()->routeParentSelect()),

                $form->item('path', __("admin::admin.path"))
                    ->useFormItem(MenuComponent::make()->routePathInput())->requiredOn('type=="menu"')->visibleOn('(type=="menu" || type=="permission") && name'),

                $form->item('auto_son_permission', __("admin::admin.auto_son_permission"))
                    ->labelRemark(__("admin::admin.auto_son_permission_remark"))
                    ->useFormItem(MenuComponent::make()->routePermissionInput())
                    ->visibleOn('type=="menu" && name && path'),

                $form->item('permission', __("admin::admin.permission"))
                    ->useFormItem()
                    ->required(true)
                    ->visibleOn('type=="permission"'),


                $form->item('icon', __("admin::admin.icon"))
                    ->useFormItem()
                    ->required(true)
                    ->visibleOn('type=="dir"')
                    ->description("<a target='_blank' href='https://fontawesome.com/search?m=free'>Font Awesome</a>")
                    ->placeholder("fa-solid fa-house"),
                $form->item('order', __("admin::admin.order"))
                    ->value(1)
                    ->vRequired()
                    ->vInteger()
                    ->vBetween(1, 99999)
                    ->useFormItem(InputNumber::make()),

                Group::make()->body([
                    $form->item('is_ext', __("admin::admin.is_ext"))->value(false)->useFormItem(InputSwitch::make())->columnRatio(2),
                    $form->item('ext_open_mode', __("admin::admin.ext_open_mode"))
                        ->value('blank')
                        ->useFormItem(Radios::make()->options([
                            'self' => __("admin::admin.self"),
                            'blank' => __("admin::admin.blank"),
                        ]))->visibleOn('is_ext'),
                ]),
                Group::make()->body([
                    $form->item('show', __("admin::admin.is_show"))->value(true)->useFormItem(InputSwitch::make())->columnRatio(2),
                    $form->item('active_menu', __("admin::admin.active_menu"))->useFormItem(MenuComponent::make()->routeParentSelect())->visibleOn('!show'),
                ]),
                $form->item('status', __("admin::admin.status"))->value(true)->useFormItem(InputSwitch::make()),

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
