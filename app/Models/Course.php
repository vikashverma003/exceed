<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
        'manufacturer_id',
        'category_id',
        'price',
        'offer_price',
        'views',
        'duration',
        'status',
        'product_id',
        'currency',
        'image',
        'sample_video',
        'meta_description',
        'meta_keywords',
        'course_name_slug',
        'short_code',
        'duration_type',
        'short_note',
        'banner',
        'inner_image',
        'thumbnail',
        'order',
        'deleted_at'
    ];

    public function outlines(){
        return $this->hasMany(CourseOutline::class, 'course_id','id');
    }

    public function locations(){
        return $this->hasMany(CourseTiming::class, 'course_id','id');
    }

    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class,'manufacturer_id','id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id')->withTrashed();
    }
}
