<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = "positions";
    protected $fillable = [
        'name',
    ];
}
