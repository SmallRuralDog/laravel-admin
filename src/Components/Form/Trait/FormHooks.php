<?php

namespace SmallRuralDog\Admin\Components\Form\Trait;

use Arr;
use Closure;
use Illuminate\Http\JsonResponse;
use SmallRuralDog\Admin\Components\Form;

trait FormHooks
{
    protected array $hooks = [];

    protected function registerHook($name, Closure $callback): self
    {
        $this->hooks[$name][] = $callback;
        return $this;
    }

    protected function callHooks($name, $parameters = [])
    {
        $hooks = Arr::get($this->hooks, $name, []);
        foreach ($hooks as $func) {
            if (!$func instanceof Closure) {
                continue;
            }
            $res = $func($this, $parameters);
            if ($res instanceof JsonResponse) {
                return $res;
            }
        }
        return null;
    }

    /**
     * 编辑时触发
     * @param Closure $callback
     * @return Form
     */
    public function editing(Closure $callback): Form
    {
        return $this->registerHook('editing', $callback);
    }

    /**
     * 编辑数据时触发
     * @param Closure $callback
     * @return Form
     */
    public function editData(Closure $callback): Form
    {
        return $this->registerHook('editData', $callback);
    }

    /**
     * 表单提交时触发
     * @param Closure $callback
     * @return Form
     */
    public function submitted(Closure $callback): Form
    {
        return $this->registerHook('submitted', $callback);
    }

    /**
     * 表单保存时触发
     * @param Closure $callback
     * @return Form
     */
    public function saving(Closure $callback): Form
    {
        return $this->registerHook('saving', $callback);
    }

    /**
     * 表单保存后触发
     * @param Closure $callback
     * @return Form
     */
    public function saved(Closure $callback): Form
    {
        return $this->registerHook('saved', $callback);
    }

    /**
     * 删除时触发
     * @param Closure $callback
     * @return Form
     */
    public function deleting(Closure $callback): Form
    {
        return $this->registerHook('deleting', $callback);
    }

    /**
     * 删除后触发
     * @param Closure $callback
     * @return Form
     */
    public function deleted(Closure $callback): Form
    {
        return $this->registerHook('deleted', $callback);
    }


    /**
     * 验证数据后触发，用于自定义验证规则
     * @param Closure $callback
     * @return Form
     */
    public function useValidatorEnd(Closure $callback): Form
    {
        return $this->registerHook('useValidatorEnd', $callback);
    }

    protected function callValidatorEnd($data)
    {
        return $this->callHooks('useValidatorEnd', $data);
    }


    /**
     * 触发编辑时钩子
     * @param $id
     * @return void
     */
    protected function callEditing($id): void
    {
        $this->callHooks('editing', $id);
    }

    /**
     * 触发编辑数据时钩子
     * @param $data
     * @return void
     */
    protected function callEdiData(&$data): void
    {
        $this->callHooks('editData', $data);
    }

    /**
     * 触发提交时钩子
     * @return void
     */
    protected function callSubmitted(): void
    {
        $this->callHooks('submitted');
    }

    /**
     * 触发保存时钩子
     */
    protected function callSaving()
    {
        return $this->callHooks('saving');
    }

    /**
     * 触发保存后钩子
     * @return void
     */
    protected function callSaved(): void
    {
        $this->callHooks('saved');
    }

    /**
     * 触发删除时钩子
     * @param $id
     * @return void
     */
    protected function callDeleting($id): void
    {
        $this->callHooks('deleting', $id);
    }

    /**
     * 触发删除后钩子
     * @return void
     */
    protected function callDeleted(): void
    {
        $this->callHooks('deleted');
    }


}
