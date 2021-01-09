<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manufacturers';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'name','logo','created_at','updated_at','deleted_at','status','banner'
    ];

    public function courses(){
        return $this->belongsTo(Course::class, 'id','manufacturer_id')->withTrashed();
    }

    public function categories(){
        return $this->hasMany(ManufacturerCategory::class,'category_id','manufacturer_id');
    }

    public function products(){
        return $this->hasMany(Manufacturer::class,'id','manufacturer_id');
    }

    public function m_categories(){
        return $this->belongsToMany(Category::class,'manufacturer_categories','manufacturer_id','category_id');
    }
}
