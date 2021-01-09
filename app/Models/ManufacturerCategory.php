<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManufacturerCategory extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manufacturer_categories';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'manufacturer_id','created_at','updated_at','deleted_at','category_id'
    ];

    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class,'manufacturer_id','id');
    }
}
