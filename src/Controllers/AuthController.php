<?php

namespace SmallRuralDog\Admin\Controllers;

use Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;

class AuthController extends AdminBase
{

    public array $noNeedLogin = ['login', 'captcha'];

    public array $noNeedPermission = ['userSetting'];

    private function guard()
    {
        return Admin::guard();
    }

    public function login(Request $request)
    {

        Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $credentials = $request->only(['username', 'password']);
        $remember = $request->boolean('remember', false);

        if ($this->guard()->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return amis_success("登录成功");
        }

        abort(400, '用户名或密码错误');


    }

    public function captcha(Request $request)
    {

    }
}
