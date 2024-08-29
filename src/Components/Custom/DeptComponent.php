<?php

namespace SmallRuralDog\Admin\Components\Custom;

use Admin;
use SmallRuralDog\Admin\Components\Enhance\AutoRoute;
use SmallRuralDog\Admin\Enums\DataPermissionsType;
use SmallRuralDog\Admin\Models\SystemDept;
use SmallRuralDog\Admin\Models\SystemRole;
use SmallRuralDog\Admin\Renderer\Form\Select;
use SmallRuralDog\Admin\Renderer\Form\TreeSelect;

class DeptComponent extends AutoRoute
{

    public function deptBindRoleSelect()
    {

        return Select::make()
            ->extractValue(true)
            ->joinValues(false)
            ->multiple(true)
            ->labelField("name")
            ->valueField("id")
            ->searchable(true)
            ->options(function () {
                return SystemRole::query()->get(['id', 'name', 'slug'])->toArray();
            });
    }


    public function deptSelect()
    {

        $options = $this->_deptSelect();
        return TreeSelect::make()
            ->labelField('name')
            ->valueField("id")
            ->options($options)
            ->showIcon(false)
            ->withChildren(true)
            ->rootCreatable(true);
    }


    public function _deptSelect()
    {
        $admin = Admin::userInfo();

        [$check,$ids] = $admin->getUserDeptSonIds();
        if ($check) {
            $orm = SystemDept::query()->whereIn('id', $ids);
        } else {
            $orm = SystemDept::query();
        }

        $list =  $orm->get()->sortByDesc('order')->toArray();

        return arr2tree($list);
    }

}
