<?php

namespace SmallRuralDog\Admin\Components;

use Admin;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use SmallRuralDog\Admin\Components\Grid\Actions;
use SmallRuralDog\Admin\Components\Grid\Filter;
use SmallRuralDog\Admin\Components\Grid\GridModel;
use SmallRuralDog\Admin\Components\Grid\Toolbar;
use SmallRuralDog\Admin\Components\Grid\Trait\GridActions;
use SmallRuralDog\Admin\Components\Grid\Trait\GridCRUD;
use SmallRuralDog\Admin\Components\Grid\Trait\GridData;
use SmallRuralDog\Admin\Components\Grid\Trait\GridDialogForm;
use SmallRuralDog\Admin\Components\Grid\Trait\GridFilter;
use SmallRuralDog\Admin\Components\Grid\Trait\GridPermission;
use SmallRuralDog\Admin\Components\Grid\Trait\GridToolbar;
use SmallRuralDog\Admin\Components\Grid\Trait\GridTree;
use SmallRuralDog\Admin\Renderer\CRUD;
use SmallRuralDog\Admin\Renderer\Page;

class Grid
{
    use GridCRUD, GridToolbar, GridData, GridTree, GridFilter, GridActions, GridDialogForm, ModelBase, GridPermission;

    /**
     * 页面Page对象
     * @var Page
     */
    protected Page $page;

    /**路由名称 */
    protected string $routeName;


    protected Builder $builder;
    protected GridModel $model;

    /** 请求动作 */
    protected string $_action;

    protected Request $request;


    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->request = request();
        $this->_action = (string)request()->input('_action');

        $routeName = $this->request->route()->getName();

        $routeName = explode('.', $routeName);

        $routeName = array_slice($routeName, 0, -1);

        $routeName = implode('.', $routeName);

        $this->routeName = $routeName;
        $this->page = Page::make();
        $this->crud = CRUD::make();
        $this->filter = new Filter();
        $this->actions = new Actions($this);
        $this->toolbar = new Toolbar($this);

        $admin = Admin::userInfo();

        $this->hasEditPermission = $admin->can($routeName . '.edit') && $admin->can($routeName . '.update');
        $this->hasDeletePermission = $admin->can($routeName . '.destroy');
        $this->hasCreatePermission = $admin->can($routeName . '.create') && $admin->can($routeName . '.store');

        $this->initCRUD();

        $this->dialogForm();
    }

    /**
     * 创建一个Grid
     */
    public static function make(Builder $builder, Closure $fun): static
    {
        $grid = new static();

        $grid->builder = $builder;
        $grid->model = new GridModel($builder, $grid);

        $fun($grid);
        return $grid;
    }

    /**获取页面组件*/
    public function usePage(): Page
    {
        return $this->page;
    }

    /**
     * 获取请求
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * 渲染Grid
     */
    public function render()
    {

        //获取数据
        if ($this->_action === "getData") {
            return $this->buildData();
        }

        $this->page->toolbar($this->toolbar->renderToolbar())->body([
            $this->renderHeader(),
            $this->renderCRUD(),
            $this->renderFooter(),
        ]);

        return $this->page;
    }
}
