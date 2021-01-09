<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_permissions';

    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id','admin_id','created_at','updated_at'
    ];
}
