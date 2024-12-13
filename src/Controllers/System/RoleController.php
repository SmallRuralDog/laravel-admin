<?php

namespace SmallRuralDog\Admin\Controllers\System;

use Admin;
use SmallRuralDog\Admin\Components\Form;
use SmallRuralDog\Admin\Components\Grid;
use SmallRuralDog\Admin\Controllers\AdminController;
use SmallRuralDog\Admin\Enums\DataPermissionsType;
use SmallRuralDog\Admin\Models\SystemRole;
use SmallRuralDog\Admin\Renderer\Button;
use SmallRuralDog\Admin\Renderer\Flex;
use SmallRuralDog\Admin\Renderer\Form\Group;
use SmallRuralDog\Admin\Renderer\Form\InputTree;
use SmallRuralDog\Admin\Renderer\Form\Select;

class RoleController extends AdminController
{

    protected function grid()
    {
        return Grid::make(SystemRole::query(), function (Grid $grid) {


            $grid->column('name', __("admin::admin.name"));
            $grid->column('slug', __("admin::admin.slug"));
            $grid->column('data_permissions_type', __("admin::admin.data_permissions_type"))->mapping(SystemRole::DATA_PERMISSIONS_TYPE);
            $grid->column('created_at', __("admin::admin.created_at"));
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
                Group::make()->label(__("admin::admin.basic_info"))->body(
                    [
                        $form->item('name', __("admin::admin.name"))->required()->useFormItem(),
                        $form->item('slug', __("admin::admin.slug"))->required()->useFormItem(),
                    ]
                ),

                $form->item('data_permissions_type', __("admin::admin.data_permissions_type"))
                    ->required()
                    ->value(DataPermissionsType::SELF->getValue())
                    ->useFormItem(Select::make()
                        ->options(SystemRole::DATA_PERMISSIONS_TYPE)
                    ),


                $form->item('menus', __("admin::admin.menus"))->useFormItem(InputTree::make()
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
                    ->heightAuto(true)
                    ->style([
                        'height' => 'calc(100vh - 350px)'
                    ])
                    ->options(function () {
                        $list = Admin::userInfo()->getAllPermissionMenus()
                            ->map(function ($item) {
                                $item->name = __($item->name);
                                return $item;
                            })
                            ->toArray();
                        return arr2tree($list);
                    })),


            ]);
        });

    }

}
