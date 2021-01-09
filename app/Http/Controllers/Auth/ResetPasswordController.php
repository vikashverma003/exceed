<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/reset-success';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $res = self::validateReset($token, $request->email);
        if(!$res['status']){
            return $res['message'];
        }
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function validateReset($token, $email) 
    {
        $credentials =  ['token'=>$token,'email'=>$email];

        if (is_null($user = $this->broker()->getUser($credentials))) {
            return ['status'=>false,'message'=>trans(Password::INVALID_USER)];
        }

        if (! $this->broker()->tokenExists($user, $credentials['token'])) {
            
            return ['status'=>false,'message'=>trans(Password::INVALID_TOKEN)];
        }
        return ['status'=>true];

     }

    public function resetSuccess(){
    	$passwordChanged = \Session::get('passwordChanged');
    	if($passwordChanged){
    		\Session::forget('passwordChanged');
    	}
    	flash('Password updated successfully. Please login with new credentials.')->success()->important();
        return view('auth.passwords.reset-success');
    }
}
