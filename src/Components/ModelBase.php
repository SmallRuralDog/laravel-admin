<?php

namespace SmallRuralDog\Admin\Components;

trait ModelBase
{
    protected ?string $primaryKey = null;


    /**
     * 获取资源路由名称
     */
    public function getRouteName(): string
    {
        return $this->routeName;
    }


    /**
     * 获取批量选择key标识
     */
    public function getBulkSelectIds(): string
    {
        return '${ids|raw}';
    }

    /**设置主键*/
    public function setPrimaryKey(string $primaryKey): self
    {
        $this->primaryKey = $primaryKey;
        return $this;
    }


    /**获取主键*/
    public function getPrimaryKey(): string
    {
        if ($this->primaryKey) {
            return $this->primaryKey;
        }
        return $this->builder()->getModel()->getKeyName();
    }

    /**获取查询构建器*/
    public function builder()
    {
        return $this->builder;
    }

    public function model()
    {
        return $this->builder()->getModel();
    }

    /**获取index的url*/
    public function getIndexUrl($parameters = []): string
    {
        return route($this->getRouteName() . '.index', $parameters);
    }

    /**获取创建的url*/
    public function getCreateUrl($parameters = []): string
    {
        return route($this->getRouteName() . '.create', $parameters);
    }

    /**获取store的url*/
    public function getStoreUrl($parameters = []): string
    {
        return 'post:' . route($this->getRouteName() . '.store', $parameters);
    }

    /**获取更新的url*/
    public function getEditUrl($key, $parameters = []): string
    {

        $routeName = $this->getRouteName();
        $route = route($routeName . '.index') . '/' . '${' . $key . '}' . '/edit';


        return get_url_with_parameter($route, $parameters);
    }

    /**获取显示的url*/
    public function getShowUrl($key, $parameters = []): string
    {
        $routeName = $this->getRouteName();

        $route = route($this->getRouteName() . '.index') . '/' . '${' . $key . '}';

        return get_url_with_parameter($route, $parameters);
    }

    /**获取更新的url*/
    public function getUpdateUrl($key, $parameters = []): string
    {
        $routeName = $this->getRouteName();
        $route = route($routeName . '.index') . '/' . $key;

        return 'put:' . get_url_with_parameter($route, $parameters);
    }

    /**获取快速更新的url*/
    public function getQuickUpdateUrl($key, $parameters = []): string
    {
        $routeName = $this->getRouteName();
        $route = route($this->getRouteName() . '.index') . '/' . $key;

        return 'put:' . get_url_with_parameter($route, $parameters);
    }

    /**获取删除的url*/
    public function getDestroyUrl($key, $parameters = []): string
    {
        $routeName = $this->getRouteName();
        $route = route($routeName . '.index') . '/' . '${' . $key . '}';

        return 'delete:' . get_url_with_parameter($route, $parameters);
    }

}
