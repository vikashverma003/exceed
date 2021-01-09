<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
     use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'name','description','created_at','updated_at','status','category_id','manufacturer_id','deleted_at','meta_keywords','meta_description','banner','meta_tags'
    ];
    
    public function categories(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class,'manufacturer_id','id');
    }
    public function courses(){
        return $this->hasMany(Course::class,'id','product_id');
    }
}
