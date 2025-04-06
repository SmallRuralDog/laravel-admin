<?php

namespace SmallRuralDog\Admin\Controllers\System;

use Admin;
use SmallRuralDog\Admin\Components\Custom\DeptComponent;
use SmallRuralDog\Admin\Components\Form;
use SmallRuralDog\Admin\Components\Grid;
use SmallRuralDog\Admin\Controllers\AdminController;
use SmallRuralDog\Admin\Models\SystemUser;
use SmallRuralDog\Admin\Renderer\Each;
use SmallRuralDog\Admin\Renderer\Form\Group;
use SmallRuralDog\Admin\Renderer\Form\InputDateRange;
use SmallRuralDog\Admin\Renderer\Form\InputText;
use SmallRuralDog\Admin\Renderer\Tpl;

class UserController extends AdminController
{
    protected function grid()
    {
        return Grid::make(SystemUser::query()->with(['createUser']), function (Grid $grid) {
            $admin = Admin::userInfo();
            [$check, $deptIds] = $admin->getUserDeptSonIds();
            if ($check) {

                abort_if(count($deptIds) == 0, 403, __("admin::admin.no_permission"));

                $grid->builder()->where('dept_id', $deptIds);
            }


            $grid->column('username', __("admin::admin.username"));
            $grid->column('name', __("admin::admin.name"));
            $grid->column('roles', __("admin::admin.roles"))
                ->remark(__("admin::admin.roles_remark"))
                ->useTableColumn(Each::make()->items(Tpl::make()->tpl("<span class='label label-primary m-l-sm'>\${name}</span>")));

            $grid->column('dept.name', __("admin::admin.dept"))->remark(__("admin::admin.dept_remark"));

            $grid->column('create_user.name', __("admin::admin.create_user"));

            $grid->column('created_at', __("admin::admin.created_at"));

            $grid->filter(function (Grid\Filter $filter) {

                $filter->setAddColumnsClass("m:grid-cols-1");

                $filter->like('username', __("admin::admin.username"));
                $filter->like('name', __("admin::admin.name"));


                $filter->where('dept_id', __("admin::admin.dept"), function ($q, $v) {
                    $ids = Admin::getDeptSonById((int)$v, true);
                    $q->whereIn('dept_id', $ids);
                })->useFormItem(DeptComponent::make()->deptSelect()->searchable(true));

                $filter->where('created_at', __("admin::admin.created_at"), function ($q, $v) {
                    $v = explode(",", $v);
                    $q->where('created_at', '>=', $v[0]);
                    $q->where('created_at', '<=', $v[1]);
                })->useFormItem(InputDateRange::make());
            });
            $grid->drawer();
        });
    }

    protected function form()
    {
        return Form::make(SystemUser::query(), function (Form $form) {

            $form->customLayout([
                Group::make()->body([
                    $form->item('username', __("admin::admin.username"))->required()->useFormItem(),
                    $form->item('name', __("admin::admin.name"))
                        ->required()
                        ->useFormItem(),
                ]),
                Group::make()->body([

                    $form->item('password', __("admin::admin.password"))
                        ->vConfirmed()
                        ->required($this->isCreate)
                        ->useFormItem(InputText::make()->password()),
                    $form->item('password_confirmation', __("admin::admin.password_confirmation"))
                        ->required($this->isCreate)
                        ->useFormItem(InputText::make()->password()),
                ]),
                Group::make()->body(function () use ($form) {
                    $body = [
                        $form->item('dept_id', __("admin::admin.dept"))
                            ->value(0)->useFormItem(DeptComponent::make()->deptSelect()),
                    ];
                    if (Admin::userInfo()->isAdministrator()) {
                        $body[] = $form->item('roles', __("admin::admin.roles"))
                            ->useFormItem(DeptComponent::make()->deptBindRoleSelect());
                    }
                    return $body;
                }),
            ]);


            $form->saving(function (Form $form) {
                $form->deleteInput('password_confirmation');
                if ($form->password && $form->model()->get('password') != $form->password) {
                    $form->password = bcrypt($form->password);
                }
                if (!$form->password) {
                    $form->deleteInput('password');
                    $form->ignored('password');
                }
            });
        });
    }
}
