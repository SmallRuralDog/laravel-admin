<?php

namespace SmallRuralDog\Admin\Controllers;

use Admin;
use Arr;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;
use SmallRuralDog\Admin\Models\SystemUser;
use SmallRuralDog\Admin\Renderer\Button;
use SmallRuralDog\Admin\Renderer\Form\AmisForm;
use SmallRuralDog\Admin\Renderer\Form\InputText;
use SmallRuralDog\Admin\Renderer\Tab;
use SmallRuralDog\Admin\Renderer\Tabs;

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
            return amis_data([
                'access_token' => $this->guard()->user()->id,
            ]);
        }

        abort(400, '用户名或密码错误');


    }

    public function captcha(Request $request)
    {

    }

    public function userSetting(Request $request)
    {

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
                    abort_if(!Hash::check($old_password, $user->password), 400, '旧密码错误');
                    $user->password = bcrypt($new_password);
                }
                if ($name) $user->name = $name;

                $user->save();
                return amis_success("修改成功");
            } catch (Exception $e) {
                return amis_error($e->getMessage());
            }

        }


        $form = AmisForm::make()
            ->title('个人设置')
            ->wrapWithPanel(false)
            ->data(Admin::userInfo()->only(['username', 'name']))
            ->api(route('admin.userSetting'));
        $form->body([
            InputText::make()->name('username')->label('用户名')->readOnly(true)->disabled(true),
            InputText::make()->name('name')->label('名称')->required(true)->placeholder("请输入名称"),
            InputText::make()->password()->name('old_password')->label('旧密码')->placeholder("请输入旧密码"),
            InputText::make()->password()->name('new_password')->label('密码')->placeholder("请输入密码"),
            InputText::make()->password()->name('new_password_confirmation')->label('确认密码')->placeholder("请输入确认密码"),
            Button::make()->label('保存')->level('primary')->actionType('submit'),
        ]);


        $page = Tabs::make()
            ->tabsMode("chrome")
            ->tabs([
                Tab::make()
                    ->title("个人设置")
                    ->body($form),
            ]);

        return amis_data($page);
    }
}
