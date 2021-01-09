<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'name','logo','created_at','updated_at','status','desc','color','icon','banner','meta_keywords','meta_description','meta_tags'
    ];

    public function courses(){
        return $this->hasMany(Course::class,'category_id','id')->withTrashed();
    }

    public function manufacturerlists(){
        return $this->hasMany(ManufacturerCategory::class,'category_id','id');
    }
}
