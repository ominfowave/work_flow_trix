<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;


class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $table = 'users';

    protected $guard_name = 'admin';

    protected $guarded = [];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getLastMessage()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'id')->orderBy('id', 'desc')->limit(1)->first();
    }
}
