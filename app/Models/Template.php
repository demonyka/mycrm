<?php

namespace App\Models;

use App\Models\Staff\Permission;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = "templates";
    protected $fillable = [
        'name',
        'fields',
    ];
}
