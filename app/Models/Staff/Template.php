<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = "staff_templates";
    protected $fillable = [
        'name',
        'fields',
    ];
}
