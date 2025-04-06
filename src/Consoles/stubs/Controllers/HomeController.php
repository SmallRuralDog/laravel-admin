<?php

namespace App\Admin\Controllers;

use Illuminate\Routing\Controller;
use SmallRuralDog\Admin\Renderer\Page;
use SmallRuralDog\Admin\Renderer\Tpl;

class HomeController extends Controller
{
    public function index()
    {

        $page = Page::make()->title("首页")->body([
            Tpl::make()->tpl("
                <div>
                    欢迎来到 Laravel Admin
                </div>
            ")
        ]);
        return amis_data($page);
    }
}
