<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    protected $fillable = [
        'user_id',
		'code',
		'limit',
		'discount',
		'used',
		'expired_at',
		'status',
		'created_at',
		'updated_at',
    ];

    public function user(){
    	return $this->belongsTo(\App\User::class);
    }
}
