<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Models\{
    Cart, CartAttendence
};
use App\Rules\{
    IsFrontEndUser, IsFrontEndPassword
};
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('user.guest')->except('logout');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function validateLogin(Request $request)
    {   
        $errors =[
            'email' => ['bail','required','string','email','exists:users', new IsFrontEndUser],
            'password' => ['bail','required','string','min:8'],
        ];
        $request->validate($errors);
    }

    public function validateLogin2(Request $request)
    {   
        $errors =[
            'password' => [new IsFrontEndPassword($request->email)],
        ];
        $request->validate($errors);
    }

    public function showLoginForm()
    {
        return redirect('/');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $this->validateLogin2($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $data = $this->attemptLogin($request);

        if(is_array($data)) {
            return response()->json($data, 400);
        }
        else {
            if ($data) {
                return $this->sendLoginResponse($request);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
    *Function to validate user based on user's type and and user's email verified status.
    */
    protected function credentials(Request $request){
        return ['email' => $request->email, 'password' => $request->password];
    }

    protected function attemptLogin(Request $request)
    {
        $valid = Auth::validate($this->credentials($request));

        if($valid) {
            $user = User::where('email', $request->input('email'))->first();
            
            if($user->email_verified_at==null || $user->email_verified_at == '') {
                return ['message' => 'User email is not verified yet. Please verify your email address to login.'];
            }
            if($user->status == 0) {
                return ['message' => 'User is not activated. Please try to contact admin.'];
            }
        }

        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }


    /**
    * Function to save user's selected courses after login.
    */
    
    protected function authenticated(Request $request){
        if(Session::has('carts'))
        {
            $data = session()->get('carts');
                            
            foreach ($data as $key => $value) {
                Cart::updateOrCreate(
                    [
                        'user_id' => Auth::user()->id,
                        'course_id' => $value['course_id'],
                        'course_timing_id' => $value['course_timing_id']
                    ],
                    [
                        'seat'=> $value['seat'],
                        'location' => $value['location'],
                        'date' => $value['date'],
                        'offer_price' => $value['offer_price'],
                        'price' =>  $value['price'],
                        'currency' => $value['currency'],
                        'coupon' => $value['coupon'],
                        'coupon_applied' => $value['coupon_applied'],
                        'discount' => $value['discount'],
                    ]
                );
            }
            Session::forget('carts');
        }

        if(Session::has('attendences'))
        {
            $data = session()->get('attendences');
            
            foreach ($data as $key => $value) {
                CartAttendence::updateOrCreate(
                    [
                        'user_id' => Auth::user()->id,
                        'course_id' => $value['course_id']
                    ],
                    [
                        'type'=> $value['type'],
                        'first_name' => $value['first_name'],
                        'last_name' => $value['last_name'],
                        'email' => $value['email'],
                        'phone' =>  $value['phone'],
                        'position' => '',
                        'company_name' => '',
                        'country' => '',
                        'city' => '',
                        'message' => '',
                    ]
                );
            }
            Session::forget('multiattendences');
        }


        if ($request->ajax()) {
            return response()->json(['redirect_to' => url()->previous(), 'message' => 'Logged in successfully.','status'=>true], 200);
        } 
        else {
            return redirect()->intended($this->redirectPath());
        }        
    }
}
