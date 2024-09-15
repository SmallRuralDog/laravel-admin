<?php

namespace SmallRuralDog\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_setting';
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'value' => 'json',
    ];

    protected $primaryKey = "slug";


}
