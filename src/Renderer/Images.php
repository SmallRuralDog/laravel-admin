<?php

namespace SmallRuralDog\Admin\Renderer;

/**
 * @method $this defaultImage($v)
 * @method $this placeholder($v)
 * @method $this delimiter($v)
 * @method $this thumbMode($v)
 * @method $this thumbRatio($v)
 * @method $this name($v)
 * @method $this value($v)
 * @method $this source($v)
 * @method $this options($v)
 * @method $this src($v)
 * @method $this originalSrc($v)
 * @method $this enlargeAble($v)
 * @method $this showDimensions($v)
 * @method $this className($v)
 * @method $this listClassName($v)
 */
class Images extends BaseSchema
{
    public string $type = 'images';

    public function getValue($value)
    {
        if (is_array($value)) {
            $value = array_map(function ($v) {
                return admin_file_url($v);
            }, $value);

            return collect($value)->values()->toArray();
        }
        return admin_file_url($value);
    }

    /**
     * 静态模式
     * @return $this
     */
    public function static(){
        $this->type = 'static-images';
        return $this;
    }
}
