<?php

namespace SmallRuralDog\Admin\Components\Grid;

use SmallRuralDog\Admin\Components\Form;
use SmallRuralDog\Admin\Components\Grid;
use SmallRuralDog\Admin\Renderer\Action\DialogAction;
use SmallRuralDog\Admin\Renderer\Action\DrawerAction;
use SmallRuralDog\Admin\Renderer\Service;

class DialogForm
{
    protected Grid $grid;
    protected ?Form $form = null;

    protected DialogAction|DrawerAction $createDialogAction;
    protected DialogAction|DrawerAction $editDialogAction;


    protected int|string $size = 'lg';


    protected int|string $width = "";
    protected int|string $height  = "";

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
        $this->createDialogAction = DialogAction::make()->label(__("admin::admin.create"))->level('primary')->icon('fa fa-add');
        $this->editDialogAction = DialogAction::make()->label(__("admin::admin.edit"))->level('link')->icon('fa fa-edit icon-mr mr-2');

    }

    /**
     * 设置弹窗大小
     */
    public function size(int|string $size): DialogForm
    {
        $this->size = $size;
        return $this;
    }

    /**
     * 设置弹窗宽度
     */
    public function width(int|string $width): DialogForm
    {
        $this->size("custom");
        $this->width = $width;
        return $this;
    }

    /**
     * 设置弹窗高度
     */
    public function height(int|string $height): DialogForm
    {
        $this->size("custom");
        $this->height = $height;
        return $this;
    }

    /**
     * 较小的弹框
     */
    public function sm(): void
    {
        $this->size("sm");
    }

    /**
     * 较大的弹框
     */
    public function lg(): void
    {
        $this->size("lg");
    }

    /**
     * 很大的弹框
     */
    public function xl(): void
    {
        $this->size("xl");
    }

    /**
     * 占满屏幕的弹框
     */
    public function full(): void
    {
        $this->size("full");
    }

    /**
     * 设置表单，添加操作时，不需要异步加载表单渲染配置
     */
    public function form(Form $form): DialogForm
    {
        $this->form = $form;
        $this->form->dialog();
        return $this;
    }

    /**
     * 渲染弹窗
     * @param $api
     * @param bool $edit
     * @return DialogAction
     */
    public function render($api, bool $edit = false): DialogAction
    {
        if ($edit) {
            $body = [
                'title' => __("admin::admin.edit"),
                'size' => $this->size,
                'body' => Service::make()->schemaApi($api),
            ];

            if ($this->width) {
                $body['width'] = $this->width;
            }

            if ($this->grid->isDrawerForm()) {
                $this->editDialogAction->actionType('drawer')->drawer($body);
            } else {
                $this->editDialogAction->dialog($body);
            }
            return $this->editDialogAction;
        }
        $body = [
            'title' => __("admin::admin.create"),
            'size' => $this->size,
            'body' => $this->form ?: Service::make()->schemaApi($api),
        ];
        if ($this->width) {
            $body['width'] = $this->width;
        }
        if ($this->grid->isDrawerForm()) {
            $this->createDialogAction->actionType('drawer')->drawer($body);
        } else {
            $this->createDialogAction->dialog($body);
        }
        return $this->createDialogAction;
    }

}
