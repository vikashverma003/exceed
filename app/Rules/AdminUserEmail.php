<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\{
    Admin, Role
};

class AdminUserEmail implements Rule
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
        $admin_email = Admin::where('email',$value)->count();
        if($admin_email){
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
        return 'The Email you have entered is incorrect.';
    }
}
