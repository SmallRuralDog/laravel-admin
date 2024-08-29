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

                abort_if(count($deptIds) == 0, 403, '无权限');

                $grid->builder()->where('dept_id', $deptIds);
            }


            $grid->column('username', '用户名');
            $grid->column('name', '姓名');
            $grid->column('roles', '角色')
                ->remark('绑定角色后，该用户将拥有该角色的权限')
                ->useTableColumn(Each::make()->items(Tpl::make()->tpl("<span class='label label-default m-l-sm'>\${name}</span>")));

            $grid->column('dept.name', '所属部门')->remark('用户所属部门,如果部门绑定了权限,用户将继承部门权限');

            $grid->column('create_user.name', '创建人');

            $grid->column('created_at', '创建时间');

            $grid->filter(function (Grid\Filter $filter) {

                $filter->setAddColumnsClass("m:grid-cols-1");

                $filter->like('username', '用户名');
                $filter->like('name', '姓名');


                $filter->where('dept_id', '部门', function ($q, $v) {
                    $ids = Admin::getDeptSonById((int)$v, true);
                    $q->whereIn('dept_id', $ids);
                })->useFormItem(DeptComponent::make()->deptSelect()->searchable(true));

                $filter->where('created_at', '创建时间', function ($q, $v) {
                    $v = explode(",", $v);
                    $q->where('created_at', '>=', $v[0]);
                    $q->where('created_at', '<=', $v[1]);
                })->useFormItem(InputDateRange::make());
            });

        });
    }

    protected function form()
    {
        return Form::make(SystemUser::query(), function (Form $form) {

            $form->customLayout([
                Group::make()->body([
                    $form->item('username', '用户名')->required()->useFormItem(),
                    $form->item('name', '昵称')
                        ->required()
                        ->useFormItem(),
                ]),
                Group::make()->body([

                    $form->item('password', '密码')
                        ->vConfirmed()
                        ->required($this->isCreate)
                        ->useFormItem(InputText::make()->password()),
                    $form->item('password_confirmation', '确认密码')
                        ->required($this->isCreate)
                        ->useFormItem(InputText::make()->password()),
                ]),
                Group::make()->body(function () use ($form) {
                    $body = [
                        $form->item('dept_id', '所属部门')
                            ->value(0)->useFormItem(DeptComponent::make()->deptSelect()),
                    ];
                    if (Admin::userInfo()->isAdministrator()) {
                        $body[] = $form->item('roles', "角色")
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
