<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
        'order_id',
    	'course_id',
    	'timing_id',
    	'manufacturer_id', 
    	'category_id', 
    	'product_id', 
    	'seats', 
        'duration', 
        'duration_type', 
    	'location',
    	'date',
        'start_date',
        'start_time',
        'end_time',
        'city',
        'state',
        'country',
    	'amount_paid',
    	'created_at',
    	'updated_at',
        'price',
        'offer_price',
        'discount',
        'training_type'
    ];

    public function course(){
        return $this->belongsTo(Course::class,'course_id','id')->withTrashed();
    }
}
