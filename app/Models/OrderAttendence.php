<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAttendence extends Model
{
    protected $table = 'order_attendences';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
        'order_id',
    	'course_id',
    	'type', 
    	'first_name',
    	'last_name',
    	'email',
    	'phone',
    	'position',
    	'company_name',
    	'country',
    	'city',
        'message',
    	'created_at',
    	'updated_at',
    ];
}
