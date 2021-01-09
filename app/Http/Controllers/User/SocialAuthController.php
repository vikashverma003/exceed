<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Socialite;
use App\User;
use Auth;
use Carbon\Carbon;

class SocialAuthController extends Controller
{
	private $redirectTo;
	
	public function __construct()
	{
		$this->redirectTo ="/";
	}

	/**
	* redirect to social media login page for Login/SIgnup purpose
	*/
	public function redirect($provider) {
		return Socialite::driver($provider)->redirect();
	}

	/**
	* Handle response return from social media
	* If user exists then login the user with details else register the user 
	*/
	public function callback(Request $request,$provider) {
		if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }
		$userData = Socialite::driver($provider)->stateless()->user();

		$users = User::where(['email' => $userData->getEmail()])->first();

		if($users){
            Auth::login($users);
            return redirect($this->redirectTo);
        }
        else{
			$user = User::create([
				'name'  => $userData->getName(),
				'email'       => $userData->getEmail()??'',
				'image'       => $userData->getAvatar(),
				'provider_id' => $userData->getId(),
				'provider'    => $provider,
				'password' => '',
	            'phone' => '',
	            'role_id' => 1,
	            'register_via' => $provider,
	            'status'=>1,
	            'email_verified_at' => Carbon::now(),
	            'customer_type_selected'=>0
	        ]);
			Auth::login($user);

     		return redirect($this->redirectTo);
        }
	}
}