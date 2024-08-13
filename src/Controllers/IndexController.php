<?php

namespace SmallRuralDog\Admin\Controllers;

use Illuminate\Http\Request;

class IndexController extends AdminBase
{


    public function root(Request $request)
    {


        return response()->view('admin::root');

    }
}
