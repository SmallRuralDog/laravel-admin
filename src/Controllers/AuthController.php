<?php

namespace SmallRuralDog\Admin\Controllers;

class AuthController extends AdminBase
{



    public function captcha()
    {

        return captcha_img();
    }
}
