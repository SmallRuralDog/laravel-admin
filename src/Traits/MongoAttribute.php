<?php

namespace SmallRuralDog\Admin\Traits;

trait MongoAttribute
{
    public function setAttribute($key, $value): static
    {
        parent::setAttribute($key, $value);
        $type = data_get($this->casts, $key);
        switch ($type) {
            case "bool":
            case "boolean":
                $this->attributes[$key] = (bool)$value;
                break;
            case "int":
            case "integer":
                $this->attributes[$key] = (int)$value;
                break;
            case "float":
            case "double":
                $this->attributes[$key] = (float)$value;
                break;
            default:
                break;
        }
        return $this;
    }
}
