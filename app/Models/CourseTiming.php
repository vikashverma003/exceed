<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTiming extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'course_timings';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'location',
        'city',
        'start_date',
        'date',
        'start_time',
        'end_time',
        'country',
        'training_type',
        'timezone',
        'dubai_start_date_time'
    ];

    public function course(){
        return $this->belongsTo(Course::class,'course_id','id')->withTrashed();
    }
}
