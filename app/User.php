<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;
use App\Services\EmailService;
use Mail;
use App\Mail\{
    NewUserNotification, ContactUsNotification, NewCouponNotification, UserContactUsNotification, NewAccountNotification, LocationQuoteMailToAdmin, LocationQuoteMailToUser
};

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email', 
        'password',
        'phone',
        'register_via',
        'status',
        'role_id',
        'provider_id',
        'provider',
        'image',
        'email_verified_at',
        'email_token',
        'customer_type_selected',
        'country_code',
        'city',
        'state',
        'country',
        'zipcode',
        'company_name', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute() {
        return ucfirst($this->name);
    }

    public function getFirstNameAttribute(){
        $parts = explode(" ", $this->name);
        if(count($parts) > 1) {
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        }
        else
        {
            $firstname = $parts[0];
        }

        return $firstname;
    }

    public function getLastNameAttribute(){
        $parts = explode(" ", $this->name);
        if(count($parts) > 1) {
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        }
        else
        {
            $firstname = $parts[0];
            $lastname = " ";
        }
        return $lastname;
    }

    public function getRoleAttribute($role_id){
        $role = Role::where('id', $role_id)->value('name');
        return ucfirst($role);
    }

    public function getRoleNameAttribute(){
        $role = Role::where('id', $this->role_id)->value('name');
        return ucfirst($role);
    }

    public function getGuardNameAttribute(){
        return Role::where('id', $this->role_id)->value('guard');
    }

    public function scopeUserOnly($query)
    {
        $role = Role::where('guard', 'web')->pluck('id')->toArray();
        return $query->whereIn('role_id', $role);
    }

    public static function sendAccountActivationMail($email,$email_token) {      
        try{
            Mail::to($email)->send(new NewUserNotification($email_token));
        }catch(\Exception $e){
            
        }
    }

    //course locations quote
    public static function sendLocationsQuoteMailToAdmin($email,$data) {      
        Mail::to($email)->send(new LocationQuoteMailToAdmin($data));
    }
    public static function sendLocationsQuoteMailToUser($email,$data) {      
       Mail::to($email)->send(new LocationQuoteMailToUser($data));
    }



    public static function sendContactMailToAdmin($email,$data) { 
        try{
            Mail::to($email)->send(new ContactUsNotification($data));
        }catch(\Exception $e){
            // 
        }  
        
    }

    public static function sendContactMailToUser($email,$data) {
        Mail::to($email)->send(new UserContactUsNotification($data));
    }

    public static function sendCouponToUser($email,$data) {      
        try{
            Mail::to($email)->send(new NewCouponNotification($data));
        }catch(\Exception $e){
                
        }
    }

    /**
    * send new account creation notification mail to admin
    */
    public static function sendNewAccountNotifyMailToAdmin($email, $data) {      
        try{
            Mail::to($email)->send(new NewAccountNotification($data));
        }
        catch(\Exception $e){
                
        }
    }
}
