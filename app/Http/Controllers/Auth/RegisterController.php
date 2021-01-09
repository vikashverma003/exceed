<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Models\{Role, Setting};
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('special_chars', function($attribute, $value, $parameters){
            return preg_match('/^([a-zA-Z\s]*)$/', $value);
        });
        
        return Validator::make($data, [
            'first_name' => 'bail|required|special_chars|max:50',
            'last_name' => 'bail|required|special_chars|max:50',
            'email' => 'bail|required|string|email|max:255|unique:users',
            'password' => 'bail|required|string|min:8|max:15',
            'phone'=>'bail|required|unique:users|numeric|digits_between:5,15',
            'customer_type'=>'bail|required|in:individual,corporate',
            'country_code'=>'bail|required|string|max:50',
	        'city'=>'bail|required|string|max:50',
	        'state'=>'bail|nullable|string|max:50',
	        'country'=>'bail|required|string|max:100',
	        'company_name'=>'bail|nullable|string|max:255',
            'zipcode'=>'bail|nullable|string|max:50',
        ],
        [
            'first_name.required' => 'Please enter first name.',
            'first_name.max' => 'Please enter first name less than 50 characters.',
            'first_name.special_chars' => 'Please enter a valid first name without special characters and numbers.',
            'last_name.required' => 'Please enter last name.',
            'last_name.max' => 'Please enter last name less than 50 characters.',
            'last_name.special_chars' => 'Please enter a valid last name without special characters and numbers.',
            'email.required' => 'Please enter Email.',
            'phone.unique' => 'This phone number already exists.',
            'email.unique' => 'This email already exists.',
            'email.email' => 'Please enter a valid Email.',
            'password.required' => 'Please enter password.',
            'password.max' => 'Please enter password between 8 to 15 characters.',
            'password.min' => 'Please enter password between 8 to 15 characters.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['customer_type']=='individual'){
            $role_id = Role::whereIn('name',['individual','indivisual'])->value('id');
        }
        else if ($data['customer_type']=='corporate') {
           $role_id = Role::where('name','corporate')->value('id');
        }else{
            $role_id = 1;
        }

        $user = User::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'register_via' =>'web',
            'role_id' =>$role_id ?? 1,
            'password' => Hash::make($data['password']),
            'email_token' => base64_encode($data['email']),
            'status' => 0,
            'customer_type_selected'=>1,
            'email_verified_at'=>null,
            'country_code' => $data['country_code'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'company_name' => $data['company_name'],
            'zipcode' => isset($data['zipcode']) ? $data['zipcode']: '',
        ]);

        // send account creation mail for account activation.
        User::sendAccountActivationMail($user->email,$user);
        $contact_email = Setting::where('type','contactemails')->where('key','new_account_email')->value('value');
        // send new user account creation notification email to admin
        User::sendNewAccountNotifyMailToAdmin($contact_email, $user);
        
        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $this->registered($request, $user);
        
        return response()->json(array('status'=>true,'message'=>'Registration has been done successfully. A verification link has been sent to your email account.'),200);
    }

    protected function registered(Request $request, $user)
    {
        //Auth::login($user);
        if(!$user->status){
            // store msg in session and display to user
            Auth::logout();
        }
    }
}
