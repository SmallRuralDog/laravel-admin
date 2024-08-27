<?php

namespace SmallRuralDog\Admin\Renderer\Form;

/**
 * 验证码输入框
 * @method $this length($v)
 * @method $this masked($v)
 * @method $this separator($v)
 */
class InputVerificationCode extends FormOptions
{

    public string $type = 'input-verification-code';
}
