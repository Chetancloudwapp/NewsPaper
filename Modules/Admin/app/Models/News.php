<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\NewsFactory;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): NewsFactory
    {
        //return NewsFactory::new();
    }

    public function galleryimages(){
        return $this->hasMany('Modules\Admin\app\Models\NewsImage')->select('news_id','images','id');
    }

    public function Category(){
        return $this->belongsTo('Modules\Admin\app\Models\Categories', 'category')->select('id','title');
    }

    public function Tag(){
        return $this->belongsTo('Modules\Admin\app\Models\Tag', 'tag')->select('id','name');
    }

    public function tags()
{
    return $this->belongsTo(Tag::class);
}
}

