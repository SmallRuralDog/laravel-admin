<?php

namespace SmallRuralDog\Admin\Controllers;

use Admin;
use Arr;
use Exception;
use Hash;
use Illuminate\Auth\SessionGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;
use Session;
use SmallRuralDog\Admin\Models\SystemUser;
use SmallRuralDog\Admin\Renderer\Button;
use SmallRuralDog\Admin\Renderer\Form\AmisForm;
use SmallRuralDog\Admin\Renderer\Form\InputText;
use SmallRuralDog\Admin\Renderer\Tab;
use SmallRuralDog\Admin\Renderer\Tabs;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthController extends AdminBase
{

    public array $noNeedLogin = ['login', 'captcha'];

    public array $noNeedPermission = ['userSetting'];

    private function guard(): SessionGuard
    {
        return Admin::guard();
    }


    public function login(Request $request)
    {
        try {
            Validator::make($request->all(), [
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255'],
            ]);
            $credentials = $request->only(['username', 'password']);
            $remember = $request->boolean('remember', false);

            if ($this->guard()->attempt($credentials, $remember)) {
                $request->session()->regenerate();
                return amis_data([
                    'access_token' => $this->guard()->user()->id,
                ]);
            }
            abort(400, __("admin::admin.username_or_password_error"));
        } catch (HttpException $exception) {
            return amis_error($exception->getMessage());
        }
    }

    public function logout()
    {
        try {
            $this->guard()->logout();
            return amis_success();
        } catch (HttpException $exception) {
            return amis_error($exception->getMessage());
        }
    }

    public function captcha(Request $request)
    {
    }

    public function userSetting(Request $request)
    {
        try {
            if ($request->method() == 'POST') {
                try {

                    $validator = Validator::make($request->all(), [
                        'avatar' => 'string',
                        'username' => 'required',
                        'old_password' => 'required_with:new_password',
                        'new_password' => 'confirmed',
                    ]);
                    if ($validator->fails()) {
                        $lastMessage = collect($validator->errors()->messages())
                            ->map(function ($item) {
                                return Arr::first($item);
                            })
                            ->toArray();
                        return amis_error($lastMessage, 422);
                    }

                    $name = $request->get('name');

                    $old_password = $request->get('old_password');
                    $new_password = $request->get('new_password');
                    /** @var SystemUser $user */
                    $user = $this->guard()->user();
                    //验证旧密码是否正确
                    if ($new_password) {
                        abort_if(!Hash::check($old_password, $user->password), 400, __("admin::admin.old_password_error"));
                        $user->password = bcrypt($new_password);
                    }
                    if ($name) $user->name = $name;

                    $user->save();
                    return amis_success(__("admin::admin.edit_success"));
                } catch (Exception $e) {
                    return amis_error($e->getMessage());
                }
            }
            $form = AmisForm::make()
                ->title(__("admin::admin.user_setting"))
                ->wrapWithPanel(false)
                ->data(Admin::userInfo()?->only(['username', 'name']))
                ->api(route('admin.userSetting'));
            $form->body([
                InputText::make()->name('username')->label(__("admin::admin.username"))->readOnly(true)->disabled(true),
                InputText::make()->name('name')->label(__("admin::admin.name"))->required(true),
                InputText::make()->password()->name('old_password')->label(__("admin::admin.old_password")),
                InputText::make()->password()->name('new_password')->label(__("admin::admin.new_password")),
                InputText::make()->password()->name('new_password_confirmation')->label(__("admin::admin.new_password_confirmation")),
                Button::make()->label(__("admin::admin.save"))->level('primary')->actionType('submit'),
            ]);
            $page = Tabs::make()
                ->tabsMode("chrome")
                ->tabs([
                    Tab::make()
                        ->title(__("admin::admin.user_setting"))
                        ->body($form),
                ]);
            return amis_data($page);
        } catch (HttpException $exception) {
            return amis_error($exception->getMessage());
        }
    }
}
