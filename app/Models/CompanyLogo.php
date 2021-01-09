<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyLogo extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_logos';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'title','logo','created_at','updated_at','status'
    ];
}
