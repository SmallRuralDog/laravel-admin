<?php

namespace SmallRuralDog\Admin\Renderer\Action;

use SmallRuralDog\Admin\Renderer\Button;

/**
 * @method $this drawer($v)
 * @method $this nextCondition($v)
 * @method $this reload($v)
 * @method $this redirect($v)
 */
class DrawerAction extends Button
{
    public string $actionType = 'drawer';
}
