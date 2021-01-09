<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Rules\IsFrontEndUser;
use Illuminate\Support\Facades\Password;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    //use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['bail','required','email','exists:users', new IsFrontEndUser]
        ]);
        $user = User::where('email',$request->email)->first();
        if($user->email_verified_at==null || $user->email_verified_at == '') {
            $message = "User email is not verified yet. Please verify your email address to login.'";
            return response()->json(['status'=>false,'message'=>$message],200);
        }
        if($user->status == 0) {
            $message = 'User is not activated. Please try to contact admin.';
            return response()->json(['status'=>false,'message'=>$message],200);
        }

        $response = Password::broker()->sendResetLink($request->only('email'));

        return response()->json(['status'=>true,'message'=>'We have e-mailed your password reset link!'],200);
    }

    public function sendAccountActivationLink(Request $request){
        $request->validate([
            'email' => ['bail','required','email','exists:users']
        ]);
        $user = User::where('email',$request->email)->first();

        if($user->email_verified_at==null || $user->email_verified_at == '') {
             // send account creation mail for account activation.
            User::sendAccountActivationMail($user->email,$user);
            return response()->json(array('status'=>true,'message'=>'A verification link has been sent to your email account.'),200);
        }else{
            $message = 'User account already verified.';
            return response()->json(['status'=>false,'message'=>$message],200);
        }
    }
}
