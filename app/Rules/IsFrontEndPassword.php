<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class IsFrontEndPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $current_password = User::where('email', $this->data)->value('password');

        return Hash::check($value, $current_password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The password is incorrect.';
    }
}
    