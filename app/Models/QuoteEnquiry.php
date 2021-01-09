<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteEnquiry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_enquires';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name', 
        'email', 'message','phone','created_at','updated_at','company_name','course_id','course','country_code','country','city','zipcode','state'
    ];
}
