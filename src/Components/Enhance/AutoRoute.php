<?php

namespace SmallRuralDog\Admin\Components\Enhance;

class AutoRoute
{
    use AutoRouteAction;

    public static function make(): static
    {
        return new static();
    }
}
