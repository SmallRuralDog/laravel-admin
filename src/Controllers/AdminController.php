<?php

namespace SmallRuralDog\Admin\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SmallRuralDog\Admin\Components\Form;
use SmallRuralDog\Admin\Components\Grid;

/**
 * @method Grid grid(Request $request)
 * @method form(Request $request)
 */
class AdminController extends AdminBase
{
    /**
     * @var bool 是否创建
     */
    protected bool $isCreate = false;
    /**
     * @var bool 是否编辑
     */
    protected bool $isEdit = false;

    /**
     * @var mixed|null 当前更新的id
     */
    protected mixed $resourceKey = null;


    public function index(Request $request): JsonResponse
    {
        return amis_data($this->grid($request)->render());
    }


    public function create(Request $request): JsonResponse
    {
        $this->isCreate = true;
        return amis_data($this->form($request)->render());
    }

    public function edit(Request $request, $id): JsonResponse
    {
        $this->isEdit = true;
        $this->resourceKey = $id;
        return amis_data($this->form($request)->edit($id)->render());
    }


    public function update(Request $request, $id)
    {
        $this->resourceKey = $id;
        $this->isEdit = true;

        /**@var Form $form */
        $form = $this->form($request);

        if ($id === "quickSave") {
            return $form->quickUpdate();
        }
        if ($id === "quickSaveItem") {
            return $form->quickItemUpdate();
        }
        return $form->update($id);
    }


    public function store(Request $request)
    {
        $this->isCreate = true;
        return $this->form($request)->store();
    }


    public function destroy(Request $request, $id)
    {
        $this->resourceKey = $id;
        return $this->form($request)->destroy($id);
    }
}
