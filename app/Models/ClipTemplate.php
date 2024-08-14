<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\Json;

class ClipTemplate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public $casts = [
        'json_data' => Json::class
    ];
}
