<?php

namespace SmallRuralDog\Admin\Renderer\Action;

use SmallRuralDog\Admin\Renderer\Button;

/**
 * @method $this blank($v)
 * @method $this url($v)
 */
class UrlAction extends Button
{
    public string $actionType = 'url';
}
