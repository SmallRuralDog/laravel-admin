<?php

namespace SmallRuralDog\Admin\Components\Form\Trait;

use Arr;
use Illuminate\Http\JsonResponse;
use Ramsey\Collection\Collection;
use SmallRuralDog\Admin\Components\Form\Item;
use Validator;
use Illuminate\Validation\Validator as V;

trait FormValidator
{

    /**
     * 验证数据
     */
    private function validatorData($data): ?JsonResponse
    {
        $rules = [];
        /* @var Item $item */
        foreach ($this->items as $item) {
            /**@var Collection $itemRule */
            $itemRule = $item->getRule()->toArray();
            $rules[$item->getName()] = $itemRule;
        }

        //合并自定义规则
        $rules = Arr::collapse([$rules, $this->addRules]);

        //如果是快捷编辑，只提取编辑字段的规则
        if ($this->isQuickEdit) {
            $rules = collect($rules)->filter(function ($item, $key) use ($data) {
                return in_array($key, collect($data)->keys()->toArray());
            })->toArray();
        }

        $validator = Validator::make($data, $rules);

        $res = $this->validator($validator);
        if ($res) {
            return $res;
        }
        $res = $this->callValidatorEnd($data);
        if ($res) {
            return $res;
        }
        return null;

    }

    /**
     * 验证器处理错误
     */
    public function validator(V $validator): ?JsonResponse
    {
        if ($validator->fails()) {
            $lastMessage = collect($validator->errors()->messages())
                ->map(function ($item) {
                    return Arr::first($item);
                })
                ->toArray();
            return amis_error($lastMessage, 422);
        }
        return null;
    }
}
