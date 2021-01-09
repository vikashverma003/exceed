<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Testimonial extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testimonials';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'user_name','user_role','created_at','updated_at','status','comment','user_image'
    ];
}
