<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Auth;
use App\Rules\IsUserCurrentPassword;
use Hash;
use App\Models\{
    Course, Order, OrderAttendence
};

class ProfileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //$this->middleware('auth');
    }

    /**
    * show all products based on filter data and master search
    */
    public function showProfilePage()
    {
        return view('frontend.profile.index');
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password'=>['bail','required','string','min:8', new IsUserCurrentPassword],
            'new_password'=>'bail|required|string|min:8',
            'confirmed_password'=>'bail|required|string|min:8|same:new_password',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        if(!$user){
            return response()->json(['status'=>false,'message'=>'User not found. Please try again later.'], 200);
        }else{
            $user->password = Hash::make($request->new_password);
            $user->save();
            Auth::logout();
            $url = url('/');

            return response()->json(['status'=>true, 'message'=>'Password changed successfully. Please login with new credentials.','url'=>$url], 200);
        }
    }


    public function updateProfile(Request $request){
        $request->validate([
            'first_name'=>'bail|required|string|max:100',
            'last_name'=>'bail|nullable|string|max:100',
            'phone'=>'bail|required|numeric|digits_between:6,15',
            'country_code'=>'bail|required|string|max:50',
	        'city'=>'bail|required|string|max:50',
	        'state'=>'bail|nullable|string|max:50',
	        'country'=>'bail|required|string|max:100',
	        'company_name'=>'bail|nullable|string|max:255',
            'zipcode'=>'bail|nullable|string|max:255',
        ],
        [
            'phone.digits_between'=>'The phone number must be between 6 and 15.',
        ]
    );

        $user = User::where('id', Auth::user()->id)->first();
        if(!$user){
            return response()->json(['status'=>false,'message'=>'User not found. Please try again later.'], 200);
        }else{
            $user->name = $request->first_name.' '.$request->last_name;
            $user->phone = $request->phone;
            $user->country_code = $request->country_code;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->country = $request->country;
            $user->company_name = $request->company_name;
            $user->zipcode = $request->zipcode;
            $user->save();
            return response()->json(['status'=>true, 'message'=>'profile changed successfully.'], 200);
        }
    }


    /**
    * show all products based on filter data and master search
    */
    public function verifyEmail($token)
    {
        $user = User::where('email_token', $token)->first();
        if (!$user) {
            return redirect('/')->with('verifyinfo','Invalid email verification token. Please try with valid url.');
        }
        if ($user->email_verified_at == '' || $user->email_verified_at==null) {
            
            $user->email_verified_at = Carbon::now();
            $user->status = 1;
            $user->email_token = null;
            if ($user->save()) {
                return redirect('/')->with('verifymessage','Your account is verified now. You may login to continue.');
            }
        }else{
            return redirect('/')->with('verifyinfo','Your account is already verified.');
        }
    }

    /*
    * save customer type selection value i.e. either individual or corporate .then role id respectively.
    */
    public function saveCustomerType(Request $request){
        $id = Auth::user()->id;
        $customer_selected = $request->customer_type_selected;
        if(!in_array($customer_selected, ['individual','corporate'])){
            return response()->json(['status'=>false,'message'=>'Please select customer type.'],400);
        }else{
            $role_id = ($customer_selected=='individual') ? 1 : 2 ;
            User::where('id', $id)->update(['customer_type_selected'=>1,'role_id'=>$role_id]);
            
            return response()->json(['status'=>true,'message'=>'customer type selection updated successfully.'],200);
        }
    }

    public function myCourses(Request $request){
        $courses = Order::where('user_id', Auth::user()->id)->with(['items','items.course'])->get();
        // echo "<pre>";
        // print_r($courses->toArray());die;
        return view('frontend.mycourses.index', compact('courses'));
    }


    public function transactions(Request $request){
     
        $transactions = Order::where('user_id', Auth::user()->id);

        if($request->filled('amount')){
            $transactions->where('total_amount_paid','LIKE',  '%' .$request->input('amount'). '%');
        }
        if($request->filled('discount')){
            $transactions->where('discount','LIKE',  '%' .$request->input('discount'). '%');
        }
        if($request->filled('from_dates') && $request->filled('to_dates'))
        {
        	$date1 = str_replace('/', '-', $request->from_dates);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->to_dates);
            $date2 = date('Y-m-d', strtotime($date2));
            $transactions->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('from_dates')) {
        	$date = str_replace('/', '-', $request->from_dates);
            $date = date('Y-m-d', strtotime($date));
            $transactions->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('end_dates')){
            $date = str_replace('/', '-', $request->end_dates);
            $date = date('Y-m-d', strtotime($date));
            $transactions->whereDate('created_at','<=' ,$date);
        }else{}

        $transactions = $transactions->orderBy('id','desc')->paginate(10);
        
        if($request->ajax()){
            return view('frontend.transactions.listing', compact('transactions'));
        }
        return view('frontend.transactions.index', compact('transactions'));
    }

    public function transactionDetails(Request $request, $id){
        $transaction = Order::where('user_id', Auth::user()->id)->where('id', $id)->with(['items','items.course','items.course.locations'])->firstOrFail();
        
        return view('frontend.transactions.details', compact('transaction'));
    }
}
