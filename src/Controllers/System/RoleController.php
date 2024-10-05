<?php

namespace SmallRuralDog\Admin\Controllers\System;

use Admin;
use SmallRuralDog\Admin\Components\Form;
use SmallRuralDog\Admin\Components\Grid;
use SmallRuralDog\Admin\Controllers\AdminController;
use SmallRuralDog\Admin\Enums\DataPermissionsType;
use SmallRuralDog\Admin\Models\SystemRole;
use SmallRuralDog\Admin\Renderer\Button;
use SmallRuralDog\Admin\Renderer\Form\Group;
use SmallRuralDog\Admin\Renderer\Form\InputTree;
use SmallRuralDog\Admin\Renderer\Form\Select;

class RoleController extends AdminController
{

    protected function grid()
    {
        return Grid::make(SystemRole::query(), function (Grid $grid) {


            $grid->column('name', '名称');
            $grid->column('slug', '标识');
            $grid->column('data_permissions_type', '数据权限类型')->mapping(SystemRole::DATA_PERMISSIONS_TYPE);
            $grid->column('created_at', '创建时间');
            $grid->setDialogFormSize('lg');

            $grid->actions(function (Grid\Actions $actions) {

                $actions->callEditAction(function (Button $button) {
                    $button->visibleOn('slug != "administrator"');
                });

                $actions->callDeleteAction(function (Button $button) {
                    $button->visibleOn('slug != "administrator"');
                });

            });

            $grid->drawer();

        });
    }

    protected function form()
    {
        return Form::make(SystemRole::query(), function (Form $form) {
            $form->customLayout([
                Group::make()->label("基础信息")->body(
                    [
                        $form->item('name', '名称')->required()->useFormItem(),
                        $form->item('slug', '标识')->required()->useFormItem(),
                    ]
                ),

                $form->item('data_permissions_type', '数据权限类型')
                    ->required()
                    ->value(DataPermissionsType::SELF->getValue())
                    ->useFormItem(Select::make()
                        ->options(SystemRole::DATA_PERMISSIONS_TYPE)
                    ),


                $form->item('menus', '菜单与权限')->useFormItem(InputTree::make()
                    ->extractValue(true)
                    ->joinValues(false)
                    ->labelField("name")
                    ->valueField("id")
                    ->multiple(true)
                    ->autoCheckChildren(true)
                    ->cascade(true)
                    ->searchable(true)
                    ->showOutline(true)
                    ->initiallyOpen(false)
                    ->unfoldedLevel(2)
                    ->treeContainerClassName("role-menu-tree")
                    ->options(function () {
                        $list = Admin::userInfo()->getAllPermissionMenus()->toArray();
                        return arr2tree($list);
                    })),
            ]);
        });

    }

}
