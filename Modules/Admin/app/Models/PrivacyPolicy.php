<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\PrivacyPolicyFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacyPolicy extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title','description'];
    
    protected static function newFactory(): PrivacyPolicyFactory
    {
        //return PrivacyPolicyFactory::new();
    }

    protected $casts = [
        'id' => 'string',
    ];
}
