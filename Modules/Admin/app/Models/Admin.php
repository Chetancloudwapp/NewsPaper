<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\AdminFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name','email','password'];

    protected $guard = 'admin';
    protected $hidden  = [
        'password',
    ];

    protected static function newFactory(): AdminFactory
    {
        //return AdminFactory::new();
    }
}
