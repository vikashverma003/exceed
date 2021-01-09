<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{
    protected $table = 'orders';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
    	'total_amount_paid',
    	'currency',
    	'coupon',
    	'coupon_applied',
    	'discount',
    	'created_at',
    	'updated_at',
    ];

    public function items(){
        return $this->hasMany(OrderItem::class,'order_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
