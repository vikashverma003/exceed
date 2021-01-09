<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;
use App\Models\Role;

class IsFrontEndUser implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value):bool
    {
    	$roles = Role::where('guard','web')->pluck('id')->toArray();
    	
        $user_email = User::whereIn('role_id',$roles)->where('email',$value)->count();
        if($user_email){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Email you have entered does not exists.';
    }
}
    