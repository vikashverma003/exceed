<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id', 
    	'course_id',
    	'course_timing_id',
    	'manufacturer_id', 
    	'category_id', 
    	'product_id', 
    	'seat', 
    	'location',
    	'date',
    	'offer_price',
    	'price',
    	'currency',
    	'coupon',
    	'coupon_applied',
    	'discount',
    	'created_at',
    	'updated_at',
    ];

    public function course(){
        return $this->belongsTo(Course::class)->withTrashed();
    }

    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class);
    }

    public function timings(){
        return $this->belongsTo(CourseTiming::class,'course_timing_id','id');
    }
}
