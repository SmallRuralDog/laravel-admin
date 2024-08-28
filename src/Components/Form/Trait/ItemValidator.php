<?php

namespace SmallRuralDog\Admin\Components\Form\Trait;

use Closure;
use Illuminate\Support\Collection;
use SmallRuralDog\Admin\Components\Form\Item;

trait ItemValidator
{
    use LaravelValidator;

    /**
     * @var Collection
     *
     */
    protected Collection $rule;

    /**
     * 设置验证规则
     * https://laravel.com/docs/validation#available-validation-rules
     * @param Closure $rule
     * @return Item|ItemValidator
     */
    public function rule(Closure $rule): self
    {
        $rule($this->rule);
        return $this;
    }

    /**
     * 获取验证规则
     */
    public function getRule(): Collection
    {
        return $this->rule;
    }

    /**
     * 不能为空
     */
    public function required(bool $enable = true): self
    {
        if ($enable) $this->rule->add('required');
        return $this;
    }

}
