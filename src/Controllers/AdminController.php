<?php

namespace SmallRuralDog\Admin\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SmallRuralDog\Admin\Components\Form;
use SmallRuralDog\Admin\Components\Grid;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        try {
            return amis_data($this->grid($request)->render());
        } catch (HttpException $exception) {
            return amis_error($exception->getMessage());
        }
    }


    public function create(Request $request): JsonResponse
    {
        try {
            $this->isCreate = true;
            return amis_data($this->form($request)->render());
        } catch (\Exception $exception) {
            return amis_error($exception->getMessage());
        }

    }

    public function edit(Request $request, $id): JsonResponse
    {
        try {
            $this->isEdit = true;
            $this->resourceKey = $id;
            return amis_data($this->form($request)->edit($id)->render());
        } catch (HttpException $exception) {
            return amis_error($exception->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
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
        } catch (HttpException $exception) {
            return amis_error($exception->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            $this->isCreate = true;
            return $this->form($request)->store();
        } catch (HttpException $exception) {
            return amis_error($exception->getMessage());
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            $this->resourceKey = $id;
            return $this->form($request)->destroy($id);
        } catch (HttpException $exception) {
            return amis_error($exception->getMessage());
        }
    }
}
