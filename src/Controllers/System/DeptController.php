<?php

namespace SmallRuralDog\Admin\Controllers\System;

use SmallRuralDog\Admin\Components\Custom\DeptComponent;
use SmallRuralDog\Admin\Components\Form;
use SmallRuralDog\Admin\Components\Grid;
use SmallRuralDog\Admin\Controllers\AdminController;
use SmallRuralDog\Admin\Models\SystemDept;
use SmallRuralDog\Admin\Renderer\Each;
use SmallRuralDog\Admin\Renderer\Form\InputNumber;
use SmallRuralDog\Admin\Renderer\Tpl;

class DeptController extends AdminController
{

    protected function grid(): Grid
    {
        return Grid::make(SystemDept::query(), function (Grid $grid) {
            $grid->builder()->orderByDesc('order');
            $grid
                ->hideFooter()
                ->loadDataOnce()
                ->toTree();
            $grid->useCRUD()
                ->expandConfig([
                    'expand' => 'all'
                ])
                ->columnsTogglable(false)
                ->perPage(100)
                ->keepItemSelectionOnPageChange(true);
            $grid->column('name', __("admin::admin.name"));
            $grid->column('roles', __("admin::admin.roles"))
                ->remark(__("admin::admin.roles_remark"))
                ->useTableColumn(Each::make()->items(Tpl::make()->tpl("<span class='label label-default m-r-sm'>\${name}</span>")));
            $grid->column('order', __("admin::admin.order"))->inputNumber();
            $grid->column('updated_at', __("admin::admin.updated_at"));

            $grid->drawer();
        });

    }

    protected function form(): Form
    {
        return Form::make(SystemDept::query(), function (Form $form) {
            $form->customLayout([
                $form->item('name', __("admin::admin.name"))
                    ->required()
                    ->vString()
                    ->useFormItem(),

                $form->item('parent_id', __("admin::admin.parent"))->value(0)->useFormItem(DeptComponent::make()->deptSelect()),

                $form->item('roles', __("admin::admin.roles"))
                    ->useFormItem(DeptComponent::make()->deptBindRoleSelect()),

                $form->item('order', __("admin::admin.order"))
                    ->value(1)
                    ->useFormItem(InputNumber::make()),

            ]);
        });
    }
}
