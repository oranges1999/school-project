<?php

namespace App\Models;

use App\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $casts = [
        'password' => 'hashed',
        'role' => Role::class
    ];
}
