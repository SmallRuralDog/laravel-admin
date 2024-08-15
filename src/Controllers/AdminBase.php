<?php
namespace SmallRuralDog\Admin\Controllers;

use App\Http\Controllers\Controller;

class AdminBase extends Controller
{
    /**
     * 不需要登录的方法
     * @var array
     */
    public array $noNeedLogin = [];

    /**
     * 不需要权限的方法
     * @var array
     */
    public array $noNeedPermission = [];
}
