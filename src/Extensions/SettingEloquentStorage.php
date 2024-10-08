<?php

namespace SmallRuralDog\Admin\Extensions;

use Cache;
use Illuminate\Database\Eloquent\Builder;
use SmallRuralDog\Admin\Models\SystemSetting;

class SettingEloquentStorage implements SettingStorage
{
    protected string $settingsCacheKey = 'app_settings';

    public function all($fresh = false)
    {
        if ($fresh) {
            return $this->modelQuery()->pluck('value', 'slug');
        }
        return Cache::rememberForever($this->getSettingsCacheKey(), function () {
            return $this->modelQuery()->pluck('value', 'slug');
        });
    }

    public function get($key, $default = null, $fresh = false)
    {
        return $this->all($fresh)->get($key, $default);
    }

    public function has($key)
    {
        return $this->all()->has($key);
    }

    public function set($key, $val = null)
    {
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                $this->set($name, $value);
            }
            return true;
        }
        $setting = $this->getSettingModel()->firstOrNew([
            'slug' => $key,
        ]);
        $setting->value = $val;
        $setting->save();
        $this->flushCache();
        return $val;
    }

    public function remove($key)
    {
        $deleted = $this->getSettingModel()->where('slug', $key)->delete();
        $this->flushCache();
        return $deleted;
    }

    public function flushCache(): bool
    {
        return Cache::forget($this->getSettingsCacheKey());
    }

    /**
     * Get settings cache key.
     *
     * @return string
     */
    protected function getSettingsCacheKey(): string
    {
        return $this->settingsCacheKey;
    }

    /**
     * Get settings eloquent model.
     *
     * @return SystemSetting
     */
    protected function getSettingModel(): SystemSetting
    {
        return app(SystemSetting::class);
    }

    protected function modelQuery(): SystemSetting
    {
        return $this->getSettingModel();
    }
}
