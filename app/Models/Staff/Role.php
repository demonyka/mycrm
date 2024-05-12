<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;
use App\Models\Staff\User;

class Role extends Model
{
    protected $table = "roles";
    protected $fillable = [
        'name'
    ];

    protected $with = ['permissions'];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }
}
