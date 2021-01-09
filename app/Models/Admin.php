<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;

class Admin extends Authenticatable
{
    use Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';
    protected $guard = 'admin';
    /**
     * The fillable denotes column names associated with the model.
     *
     * @var array
     */
    protected $fillable = [
        'name','email','password','role_id','is_super','remember_token','created_at','updated_at'
    ];

    public function getRoleNameAttribute(){
        return Role::where('id', $this->role_id)->value('name');
    }

    public function scopeSuperAdminOnly($query)
    {
        return $query->where('is_super', 1);
    }
    public function scopeSubAdminOnly($query)
    {
        return $query->where('is_super', 0);
    }

    public function scopeIsAdmin(){
        if($this->is_super==1){
            return true;
        }
        return false;
    }

    public function permissions()
    {
        return $this->hasMany(AdminPermission::class,'admin_id','id');
    }
}
