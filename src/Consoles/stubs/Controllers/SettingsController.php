<?php

namespace App\Admin\Controllers;

use Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SmallRuralDog\Admin\Controllers\AdminBase;
use SmallRuralDog\Admin\Renderer\Button;
use SmallRuralDog\Admin\Renderer\Form\AmisForm;
use SmallRuralDog\Admin\Renderer\Form\Combo;
use SmallRuralDog\Admin\Renderer\Form\InputImage;
use SmallRuralDog\Admin\Renderer\Form\InputSwitch;
use SmallRuralDog\Admin\Renderer\Form\InputText;
use SmallRuralDog\Admin\Renderer\Form\Textarea;
use SmallRuralDog\Admin\Renderer\Panel;
use SmallRuralDog\Admin\Renderer\Tab;
use SmallRuralDog\Admin\Renderer\Tabs;

class SettingsController extends AdminBase
{

    public function index(): JsonResponse
    {
        $page = Panel::make()
            ->affixFooter(true)
            ->actions([
                Button::make()->label("保存")->level("primary")->type("submit")->target("setting-form"),
            ]);

        $data = settings()->all();

        $logo = data_get($data, 'logo');
        if ($logo) {
            $data['logo'] = InputImage::make()->getValue($logo);
        }


        $form = AmisForm::make()
            ->data($data)
            ->name("setting-form")
            ->affixFooter(true)
            ->wrapWithPanel(false)
            ->api(url()->current());
        $form->body([
            Tabs::make()
                ->tabsMode("chrome")
                ->tabs([
                    Tab::make()
                        ->title("基本设置")
                        ->body([
                            //标题
                            InputText::make()->name("title")->label("标题"),
                            //logo
                            InputImage::make()->name("logo")->label("logo"),
                            //公告内容
                            Combo::make()->multiLine(true)
                                ->name("notice_content")->label("公告内容")->items([
                                    //是否展示
                                    InputSwitch::make()->name("is_show")->label("是否展示")->value(true),
                                    //内容
                                    Textarea::make()->name("content")->label("内容"),
                                    //按钮文字
                                    InputText::make()->name("button_text")->label("按钮文字"),
                                    //打开链接
                                    InputText::make()->name("open_url")->label("打开链接"),
                                ]),
                        ]),
                    Tab::make()
                        ->title("其他设置")
                        ->body([]),
                ]),
        ]);
        $page->body($form);
        return amis_data($page);
    }

    public function save(Request $request): JsonResponse
    {
        $res = Admin::validator($request->all(), []);

        if ($res) {
            return $res;
        }
        $count = 0;
        foreach ($request->all() as $key => $value) {
            if ($key == 'items') continue;

            if ($key == 'logo') {
                $value = InputImage::make()->setValue($value);
            }

            if (settings($key) === $value) continue;
            settings()->set($key, $value);
            $count++;
        }

        return amis_success("本次更新了 $count 个设置项");
    }
}
