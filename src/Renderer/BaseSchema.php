<?php

namespace SmallRuralDog\Admin\Renderer;

use Closure;
use Exception;
use JsonSerializable;
use stdClass;

/**
 * @method $this type($v)
 * @method $this className($v)
 * @method $this style($v)
 * @method $this ref($v)
 * @method $this disabled($v)
 * @method $this disabledOn($v)
 * @method $this hidden($v)
 * @method $this hiddenOn($v)
 * @method $this visible($v)
 * @method $this visibleOn($v)
 * @method $this id($v)
 * @method $this value($v)
 *
 * @method $this onEvent($v) 配置事件
 *
 * @method getValue($value) 给组件赋值时自定义处理
 * @method setValue($value) 组件赋值提交时自定义处理
 * @method onDelete($value) 删除时自定义处理
 * @method defaultAttr() 可以自定义属性的设置
 */
class BaseSchema extends stdClass implements JsonSerializable
{
    public string $type;

    public static function make(): static
    {
        return new static();
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
        return $this;
    }

    public function __get($name)
    {
        return data_get($this, $name);
    }

    public function attr($name, $value): static
    {
        return $this->$name($value);
    }

    /**
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        abort_if(count($arguments) !== 1, 400, "{$name} method parameter error");
        $argument = $arguments[0];
        if ($argument instanceof Closure) {
            $argument = $argument();
        }
        $this->$name = $argument;
        return $this;
    }

    public function jsonSerialize(): array
    {
        if (method_exists($this::class, 'defaultAttr')) {
            $this->defaultAttr();
        }

        return get_object_vars($this);
    }

}
