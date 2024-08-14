<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\Json;


use Illuminate\Database\Eloquent\Casts\Attribute;


class Clip extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function template()
    {
        return $this->hasOne(ClipTemplate::class, 'id', 'template_id');
    }

    protected $casts = [
        'custom_json_data' => Json::class
    ];

}
