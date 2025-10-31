<?php

namespace SmallRuralDog\Admin\Components\Grid\Trait;

use Closure;
use SmallRuralDog\Admin\Components\Grid\DialogForm;
use SmallRuralDog\Admin\Renderer\Action\DialogAction;

trait GridDialogForm
{
    protected bool $isDialogForm = false;

    protected DialogForm $dialogForm;

    protected bool $isDrawerForm = true;

    /**
     * 弹窗表单模式
     * @return DialogForm
     */
    protected function dialogForm(): DialogForm
    {
        $this->isDialogForm = true;
        $this->dialogForm = new DialogForm($this);
        return $this->dialogForm;
    }

    /**
     * 抽屉表单模式
     * @return void
     */
    public function drawer(): void
    {
        $this->isDrawerForm = true;
        $this->isDialogForm = false;
    }

    public function isDrawerForm(): bool
    {
        return $this->isDrawerForm;
    }

    /**
     * 设置弹窗表单大小 sm | lg | md | xl
     * @param string|int $size
     * @return void
     */
    public function setDialogFormSize(string|int $size): void
    {
        $this->dialogForm->size($size);
    }

    /**
     * 设置弹窗表单宽度
     * @param string|int $width
     * @return void
     */
    protected function setDialogFormWidth(string|int $width): void
    {
        $this->dialogForm->width($width);
    }

    /**
     * 设置弹窗表单高度
     * @param string|int $height
     * @return void
     */
    protected function setDialogFormHeight(string|int $height): void
    {
        $this->dialogForm->height($height);
    }

    /**
     * 使用弹窗表单
     */
    public function useDialogForm(Closure $closure): self
    {
        $closure($this->dialogForm);
        return $this;
    }

    public function renderDialogForm($api, $edit = false): DialogAction
    {
        return $this->dialogForm->render($api, $edit);
    }

    public function isDialogForm(): bool
    {
        return $this->isDialogForm;
    }
}
