<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string status
 * @property string username
 * @property string email
 * @property mixed tpl_data
 * @property string password
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'status',
        'username',
        'email',
        'tpl_data',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected $appends = ['fullname', 'positions'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'work',
            function (Builder $builder) {
                $builder->where('status', '!=', 'dismiss');
            }
        );
    }

    public function minimum()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'firstname' => $this->getFirstnameAttribute(),
            'fullname' => $this->getFullnameAttribute(),
            'avatar_path' => json_decode($this->tpl_data, true)['avatar_path'] ?? null,
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function isSuperuser()
    {
        return in_array($this->username, explode(',', config('crm.superusers')));
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperuser()) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role->permissions()->where('permission', $permission)->first() !== null) {
                return true;
            }
        }
        return false;
    }

    public function getTplValue(string $slug)
    {
        $tplData = $this->tpl_data;

        if (is_string($tplData)) {
            $tplData = json_decode($tplData, true);
        }

        if (is_array($tplData) && array_key_exists($slug, $tplData)) {
            return $tplData[$slug];
        }

        return null;
    }

    public function getFullnameAttribute(): string
    {
        $value = $this->getTplValue('lastname') . " " . $this->getTplValue('firstname') . " " .
            $this->getTplValue('middlename');

        if (!trim($value)) {
            $value = $this->username;
        }

        return trim($value);
    }

    public function getFirstnameAttribute(): string
    {
        $value = $this->getTplValue('firstname');

        if(!trim($value)) {
            $value = $this->username;
        }

        return trim($value);
    }

    public function getPermissionsAttribute()
    {
        if ($this->isSuperuser()) {
            return Permission::all()->pluck('permission');
        }
        $roles = $this->roles;
        $permissions = [];
        foreach ($roles as $role) {
            foreach ($role->permissions()->pluck('permission') as $permission) {
                array_push($permissions, $permission);
            }
        }
        return array_unique($permissions);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'user_positions', 'user_id', 'position_id');
    }

    public function getPositionsAttribute()
    {
        return $this->positions()->pluck('name');
    }
}
