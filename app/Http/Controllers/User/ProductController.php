<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Course, Cart, CartAttendence, OrderAttendence, OrderItem, Order, Coupon, CourseTiming
};
use \Carbon\Carbon;
use Auth;
use Session;
use Mail;
use App\Mail\OrderConfirmationMail;

class ProductController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
    * get cart page
    *
    */
    public function getCart(Request $request){
    	//Session::forget('carts');
        //Session::forget('attendences');
    	$total = 0;
        if (auth()->check()){
            $data = Cart::where('user_id', Auth::user()->id)->with(['course','timings'])->get();
            $total = 0;
            $userCartCourses =[];

            foreach ($data as $key => $value) {
                $total+=($value->seat*$value->offer_price);
                $value['course'] = Course::where('id', $value->course_id)->first();
	            $value['timings'] = CourseTiming::where('id', $value->course_timing_id)->first();
                $userCartCourses[] = $value;
            }
            
        }
        else{
        	$userCartCourses = [];

        	if(Session::has('carts'))
        	{
        		$data = session()->get('carts');
       			
       			$total = 0;
	            foreach ($data as $key => $value) {
	                $total+=($value['seat']*$value['offer_price']);
	                $value['course'] = Course::where('id', $value['course_id'])->first();
	                $value['timings'] = CourseTiming::where('id', $value['course_timing_id'])->first();
	                $userCartCourses[] = $value;
	            }

        	}
        }


        return view('frontend.cart.index', ['cart'=>$userCartCourses, 'total'=>$total]);
    }

    /**
    * get getCheckout page
    */
    public function getCheckout(Request $request){
        
        $userCartCourses = Cart::where('user_id', Auth::user()->id)->get();
        if($userCartCourses->count()==0){
            return redirect('/cart');
        }

        $total = 0;
        foreach ($userCartCourses as $key => $value) {
            $total+=($value->seat*$value->offer_price);
        }

        $discount = isset($userCartCourses[0]->discount) ? $userCartCourses[0]->discount: 0;
        $Totaldiscount = ($discount/100)*$total;
        $grandTotal = $total - $Totaldiscount;

        $coupon_applied = isset($userCartCourses[0]->coupon_applied) ? $userCartCourses[0]->coupon_applied: 0;
        $coupon_applied_code = isset($userCartCourses[0]->coupon) ? $userCartCourses[0]->coupon: '';

        return view('frontend.checkout.index', ['total'=>$total, 'coupon_applied'=>$coupon_applied,'coupon_applied_code'=>$coupon_applied_code, 'discount'=>$discount, 'grandTotal'=>$grandTotal]);
    }

    /**
    * common method which return cart total of user
    **/
    private function getCartTotal(){
    	$userCartCourses = Cart::where('user_id', Auth::user()->id)->get();

        $total = 0;
        foreach ($userCartCourses as $key => $value) {
            $total+=($value->seat*$value->offer_price);
        }

        $discountP = isset($userCartCourses[0]->discount) ? $userCartCourses[0]->discount: 0;
        $discount = ($discountP/100)*$total;
        $grandTotal = $total - $discount;
        return $grandTotal;
    }


    /**
    * add or update cart items
    *
    */
    public function addUpdateCart(Request $request){
        
        $course_id = decrypt($request->course);
        $course = Course::where('id', $course_id)->first();
        if(!$course){
            return response()->json(['status'=>false , 'message'=>'Oops, Course not found. Please try again later.'], 200);
        }

        if(!auth()->check())
        {
            if(Session::has('carts'))
        	{
        		$data = session()->get('carts');
       		   

                $session_course_ids = array_column($data, 'course_id');
                $session_course_timing_ids = array_column($data, 'course_timing_id');

                $already_added =false;
                foreach ($data as $key => $value)
                {
                    if(in_array($course_id, $session_course_ids)){
                        if(in_array($request->course_timing_id, $session_course_timing_ids)){
                            $already_added =true;
                        }
                    }
                }

                if($already_added){
                    return response()->json(['status'=>false,'message'=>'This Course already added to cart for selected Location.'], 200);
                }


       			foreach ($data as $key => $value) {
                    if($value['course_id']==$course_id && $value['course_timing_id']==$request->course_timing_id){
                    	Session::forget('carts.' . $key);
                    }
                }
        	}

        	
        	$cart = [];
            $cart['course_timing_id'] = $request->course_timing_id;
            $cart['course_id'] = $course_id;

            $cart['discount'] = $request->input('discount') ? $request->input('discount') : 0;
            $cart['coupon_applied'] = $request->input('coupon_applied') ? $request->input('coupon_applied') : 0;
            $cart['coupon'] = $request->input('coupon') ? $request->input('coupon') : '';
            $cart['currency'] = $request->input('currency') ? $request->input('currency') : '';
            $cart['price'] = $course->price ? $course->price : 0;
            $cart['offer_price'] = $course->offer_price ? $course->offer_price : 0;
            $cart['date'] = $request->input('date') ? $request->input('date') : '';
            $cart['location'] = $request->input('location') ? $request->input('location') : '';
            $cart['seat'] = $request->input('seat') ? $request->input('seat') : 1;

            Session::push('carts', $cart);
        	$cartCount = self::cartCount();
    		return response()->json(['status'=>true , 'message'=>'The item is successfully added to cart.','count'=>$cartCount], 200);

        }else{
        	$auth_id = Auth::user()->id;

            $courses_exists = Cart::where('user_id', $auth_id)->where('course_id', $course_id)->where('course_timing_id', $request->input('course_timing_id'))->count();
            if($courses_exists > 0){
                return response()->json(['status'=>false,'message'=>'This Course already added to cart for selected Location.'], 200);
            }

	        $res = Cart::updateOrCreate(
	                [
	                    'user_id' => $auth_id,
	                    'course_id' => $course_id,
	                    'course_timing_id' => $request->input('course_timing_id')
	                ],
	                [
	                    'seat'=> $request->input('seat') ? $request->input('seat') : 1,
	                    'location' => $request->input('location') ? $request->input('location') : '',
	                    'date' => $request->input('date') ? $request->input('date') : '',
	                    'offer_price' => $course->offer_price ? $course->offer_price : 0,
	                    'price' =>  $course->price ? $course->price : 0,
	                    'currency' => $request->input('currency') ? $request->input('currency') : '',
	                    'coupon' => $request->input('coupon') ? $request->input('coupon') : '',
	                    'coupon_applied' => $request->input('coupon_applied') ? $request->input('coupon_applied') : 0,
	                    'discount' => $request->input('discount') ? $request->input('discount') : 0,
	                ]
	            );
	        if($res){
	            $cartCount = self::cartCount();
                return response()->json(['status'=>true , 'message'=>'The item is successfully added to cart.','count'=>$cartCount], 200);
	        }else{
	            return response()->json(['status'=>false , 'message'=>'Internal server error. Please try again later.'], 200);
	        }
        }
    }

    /**
    * add or update cart items
    *
    */
    public function addUpdateMultipleCart(Request $request){
    	$course_id = decrypt($request->course);
    	$course = Course::where('id', $course_id)->first();
        if(!$course){
            return response()->json(['status'=>false , 'message'=>'Oops, Course not found. Please try again later.'], 200);
        }

        if(!auth()->check())
        {
            if(Session::has('carts'))
        	{
        		$data = session()->get('carts');
       			       			
       			foreach ($data as $key => $value) {
                    if($value['course_id']==$course_id && $value['course_timing_id']==$request->course_timing_id){
                    	Session::forget('carts.' . $key);
                    }
                }
        	}
        	if($request->filled('course_timing_id')){
                $all_carts = Session()->get('carts',[]);
        		foreach ($request->input('course_timing_id') as $key => $value) {
                    $already_exist = 0;
                    $seats = $request->input('seat') ? $request->input('seat') : 1;
                    if(count($all_carts) > 0)
                    {
                        foreach($all_carts as $key=>$cartt)
                        {
                            if($cartt['course_timing_id'] == $value && $cartt['course_id'] == $course_id)
                            {
                                $seats = $cartt['seat'] + 1;
                                $already_exist = 1;
                                Session::forget('carts.' . $key);

                            }
                        }
                    }
                   
                        $cart = [];
                        $cart['course_timing_id'] = $value;
                        $cart['course_id'] = $course_id;
                        $cart['discount'] = $request->input('discount') ? $request->input('discount') : 0;
                        $cart['coupon_applied'] = $request->input('coupon_applied') ? $request->input('coupon_applied') : 0;
                        $cart['coupon'] = $request->input('coupon') ? $request->input('coupon') : '';
                        $cart['currency'] = $request->input('currency') ? $request->input('currency') : '';
                        $cart['price'] = $course->price ? $course->price : 0;
                        $cart['offer_price'] = $course->offer_price ? $course->offer_price : 0;
                        $cart['date'] = $request->input('date') ? $request->input('date') : '';
                        $cart['location'] = $request->input('location') ? $request->input('location') : '';
                        $cart['seat'] = $seats;
                        Session::push('carts', $cart);
                    
        		}
        	}
            $cartCount = self::cartCount();
    		return response()->json(['status'=>true , 'message'=>'The item is successfully added to cart.','count'=>$cartCount], 200);


        }else{
        	
	        $auth_id = Auth::user()->id;
	        if($request->has('course_timing_id')){
	        	foreach ($request->course_timing_id as $key => $value) {
                    $check = Cart::where('user_id',$auth_id)->where('course_id',$course_id)->where('course_timing_id',$value)->first();
                    $seats = $request->input('seat') ? $request->input('seat') : 1;
                    if($check)
                    {
                        $seats = $seats + 1;
                    }
	        		$res = Cart::updateOrCreate(
		                [
		                    'user_id' => $auth_id,
		                    'course_id' => $course_id,
		                    'course_timing_id' => $value
		                ],
		                [
		                    'seat'=> $seats,
		                    'location' => $request->input('location') ? $request->input('location') : '',
		                    'date' => $request->input('date') ? $request->input('date') : '',
		                    'offer_price' => $course->offer_price ? $course->offer_price : 0,
		                    'price' =>  $course->price ? $course->price : 0,
		                    'currency' => '',
		                    'coupon' => '',
		                    'coupon_applied' => 0,
		                    'discount' => 0,
		                ]
		            );
	        	}
	        	if($res){
		            $cartCount = self::cartCount();
                    return response()->json(['status'=>true , 'message'=>'The item is successfully added to cart.','count'=>$cartCount], 200);
		        }else{
		            return response()->json(['status'=>false , 'message'=>'Internal server error. Please try again later.'], 200);
		        }
	        }else{
	        	return response()->json(['status'=>false , 'message'=>'Internal server error. Please try again later.'], 200);
	        }
        }
        
    }

    /**
    *remove selected course and its details from cart
    **/
    public function removeCourseFromCart(Request $request){
        if(!auth()->check()){
        	$course_id = ($request->course);
	        $course_timing_id = $request->id;
	        $course = Course::where('id', $course_id)->first();
	        if(!$course){
	            return response()->json(['status'=>false , 'message'=>'Oops, Course not found. Please try again later.'], 200);
	        }

	        if(Session::has('carts'))
        	{
        		$data = session()->get('carts');
       			foreach ($data as $key => $value) {
                    if($value['course_id']==$course_id && $value['course_timing_id']==$course_timing_id){
                    	Session::forget('carts.' . $key);
                    }
                }
                return response()->json(['status'=>true, 'message'=>'The course is successfully removed from cart.'], 200);

        	}else{
        		return response()->json(['status'=>false , 'message'=>'Oops, Course not found. Please try again later.'], 200);
        	}
        }
        else
        {
        	$course_id = ($request->course);
	        $course_timing_id = $request->id;
	        $course = Course::where('id', $course_id)->first();
	        if(!$course){
	            return response()->json(['status'=>false , 'message'=>'Oops, Course not found. Please try again later.'], 200);
	        }

	        $res = Cart::where('user_id', Auth::user()->id)->where('course_id', $course_id)->where('course_timing_id', $course_timing_id)->delete();
	        if($res)
	        {
	        	if(Cart::where('user_id', Auth::user()->id)->where('course_id', $course_id)->count()==0)
	        	{
	        		CartAttendence::where('user_id', Auth::user()->id)->where('course_id', $course_id)->delete();
	        	}
	           
	            return response()->json(['status'=>true, 'message'=>'The course is successfully removed from cart.'], 200);
	        }else{
	            return response()->json(['status'=>false, 'message'=>'Oops, Cart data not found. Please try again later.'], 200);
	        } 
        }
    }

    /**
    * update course seats from cart page.
    **/
    public function updateCourseSeats(Request $request){
        $course = $request->course;
        $course_timing_id = $request->course_timing_id;
        $seats = $request->val;
        $total = 0;
        

        if(!auth()->check()){
	        if(Session::has('carts'))
        	{
        		$data = session()->get('carts');

       			foreach ($data as $key => $value) {
                    if($value['course_id']==$course && $value['course_timing_id']==$course_timing_id){
                    	$data[$key]['seat'] = $seats;
                    }
                }
                
                Session::forget('carts');
                Session::put('carts', $data);
                
                $Coursedata = session()->get('carts');
                foreach ($Coursedata as $key => $value) {
                    $total+=($value['seat']*$value['offer_price']);
                }
                return response()->json(['status'=>true, 'message'=>'The cart is successfully updated.','total'=>$total], 200);

        	}else{
        		return response()->json(['status'=>false , 'message'=>'Oops, Course not found. Please try again later.'], 200);
        	}
        }else{
        	$cart = Cart::where('course_id', $course)->where('course_timing_id', $course_timing_id)->where('user_id', Auth::user()->id)->first();
            if($cart){
                $cart->seat = $seats;
                $cart->save();

                $Coursedata = Cart::where('user_id', Auth::user()->id)->get();
                foreach ($Coursedata as $key => $value) {
                    $total+=($value->seat*$value->offer_price);
                }
                return response()->json(['status'=>true, 'message'=>'The cart is successfully updated.','total'=>$total], 200);
            }else{
                return response()->json(['status'=>false, 'message'=>'Oops, Cart data not found. Please try again later.'], 200);
            }
        }
    }

    /**
    * save multiple attendence to cart table
    */
    public function saveAttedences(Request $request){
        if($request->course_contact_type=='individual')
        {
            $request->validate([
                'first_name'=>'bail|required|string|max:50',
                'last_name'=>'bail|required|string|max:50',
                'email'=>'bail|required|email|max:50',
                'phone' => 'bail|required|numeric|digits_between:5,15',
                'country_code' => 'bail|required|string|max:50',
                'position'=>'bail|required|string|max:100',
                'company_name'=>'bail|required|string|max:250',
                'country'=>'bail|required|string|max:100',
                'city'=>'bail|required|string|max:100',
                'message'=>'bail|required|string|max:500',
                'course_contact_id'=>'bail|required|string|max:500',
            ]);

            if(Auth::user())
            {
            	CartAttendence::where('user_id', Auth::user()->id)->where('course_id', decrypt($request->course_contact_id))->delete();

	            $obj =  new CartAttendence;
	            $obj->type = 'individual';
	            $obj->first_name = $request->first_name;
	            $obj->last_name = $request->last_name;
	            $obj->email = $request->email;
	            $obj->phone = $request->phone;
	            $obj->position = $request->position;
	            $obj->company_name = $request->company_name;
	            $obj->country = $request->country;
	            $obj->city = $request->city;
	            $obj->message = $request->message;
	            $obj->course_id = decrypt($request->course_contact_id);
	            $obj->user_id = Auth::user()->id;
	            if($obj->save()){
	                return response()->json(['status'=>true, 'message'=>'Contact informations updated successfully.'], 200);
	            }
	            return response()->json(['status'=>false, 'message'=>'Contact informations not updated.'], 200);
            }
            else
            {
            	if(Session::has('attendences'))
            	{
            		$data = session()->get('attendences');
           			$course_ids = array_column($data, 'course_id');
           			
           			foreach ($course_ids as $key => $value) {
                        if(decrypt($request->course_contact_id==$value)){
	           				Session::forget('attendences.' . $key);
	           			}
                    }
            	}

            	$attendences = [];
        		$attendences['type'] = 'individual';
        		$attendences['first_name'] = $request->first_name;
        		$attendences['last_name'] = $request->last_name;
        		$attendences['email'] = $request->email;
        		$attendences['phone'] = $request->phone;
        		$attendences['position'] = $request->position;
        		$attendences['company_name'] = $request->company_name;
        		$attendences['country'] = $request->country;
        		$attendences['city'] = $request->city;
        		$attendences['message'] = $request->message;
        		$attendences['course_id'] = decrypt($request->course_contact_id);
        		
        		Session::push('attendences', $attendences);

        		return response()->json(['status'=>true, 'message'=>'Contact informations updated successfully.'], 200);
            }
        }else
        {
            $request->validate([
                'first_name.*'=>'bail|required|string|max:50',
                'last_name.*'=>'bail|required|string|max:50',
                'email.*'=>'bail|required|email|max:50',
                'phone.*'=>'bail|required|string|max:50',
                'course_contact_id'=>'bail|required|string|max:500',
            ],
            [
                'first_name.*.required'=>'The first name field is required.',
                'last_name.*.required'=>'The last name field is required.',
                'email.*.required'=>'The email field is required.',
                'email.*.email'=>'The email format is incorrect.',
                'phone.*.required'=>'The phone field is required.',

                'first_name.*.max'=>'The first name field may not be greater than 50 characters.',
                'last_name.*.max'=>'The last name field may not be greater than 50 characters.',
                'email.*.max'=>'The email field may not be greater than 50 characters.',
                'phone.*.max'=>'The phone field may not be greater than 50 characters.',
            ]);
            if(Auth::user())
            {
            	CartAttendence::where('user_id', Auth::user()->id)->where('course_id', decrypt($request->course_contact_id))->delete();

	            $data = [];
	            foreach ($request->first_name as $key => $value) {
	                $data[] = ['first_name'=>$value,'last_name'=>$request->last_name[$key], 'email'=>$request->email[$key], 'phone'=>$request->phone[$key], 'course_id'=>decrypt($request->course_contact_id),'user_id'=>Auth::user()->id,'type'=>'corporate'];
	            }
	            $res= CartAttendence::insert($data);
	            
	            if($res){
	                return response()->json(['status'=>true, 'message'=>'Contact informations updated successfully.'], 200);
	            }
	            return response()->json(['status'=>false, 'message'=>'Contact informations not updated.'], 200);
            }
            else
            {
            	if(Session::has('attendences'))
            	{
            		$data = session()->get('attendences');
           			
           			foreach ($data as $key => $value) {
           				foreach ($value as $keyy => $valuee) {
           					
           					if($valuee['course_id'] == decrypt($request->course_contact_id))
           					{
		           				Session::forget('attendences.' . $key);
		           				break;
		           			}
           				}
                    }
            	}

            	
	            foreach ($request->first_name as $key => $value) {
	            	$multiattendences = [];
	                $multiattendences = ['first_name'=>$value,'last_name'=>$request->last_name[$key], 'email'=>$request->email[$key], 'phone'=>$request->phone[$key], 'course_id'=>decrypt($request->course_contact_id),'type'=>'corporate'];
	                Session::push('attendences', $multiattendences);
	            }
        		

        		return response()->json(['status'=>true, 'message'=>'Contact informations updated successfully.'], 200);
            }
        }
    }

    /**
    * apply coupon to cart
    **/
    public function applyCoupon(Request $request){
        $coupon = $request->input('coupon');
        if(!$coupon){
            return response()->json(['status'=>false, 'message'=>'Please enter valid coupon.'], 200);
        }
        $couponcode = Coupon::where('status', 1)->where('user_id', Auth::user()->id)->where('code', $coupon)->whereDate('expired_at', '>=', date('Y-m-d'))->first();
        if(!$couponcode){
            return response()->json(['status'=>false, 'message'=>'The coupon code entered is not valid. Perhaps you used the wrong coupon code or coupon got expired.'], 200);
        }else
        {
            if($couponcode->used >= $couponcode->limit){
                return response()->json(['status'=>false, 'message'=>'The coupon code entered is maximum used. Please try another coupon.'], 200);
            }else{
                Cart::where('user_id', Auth::user()->id)->update(['coupon'=>$couponcode->code,'coupon_applied'=>1,'discount'=>$couponcode->discount]);
                
                return response()->json(['status'=>true, 'message'=>'The coupon code entered is successfully applied.'], 200);
            }
        }
    }

    /**
    * remove coupon to cart
    **/
    public function removeCoupon(Request $request){
        if(Cart::where('user_id', Auth::user()->id)->count()==0){
            return response()->json(['status'=>false, 'message'=>'Please add course to cart or refresh the page.'],200);
        }
        
        Cart::where('user_id', Auth::user()->id)->update(['coupon'=>'','coupon_applied'=>0,'discount'=>0]);

        return response()->json(['status'=>true, 'message'=>'The coupon code entered is successfully removed.'], 200);
    }

    /**
    * payment from checkout page
    **/
    public function payment(Request $request){
    	// delete card items after payment
        if(Cart::where('user_id', Auth::user()->id)->count()==0){
            return response()->json(['status'=>false, 'message'=>'Please add course to cart or refresh the page.'],200);
        }

        
        try{
	       \DB::beginTransaction();
	        $total = self::getCartTotal();
	        $orders = Cart::where('user_id', Auth::user()->id)->get()->toArray();

	        $objOrder = new Order();
	        $objOrder->user_id = Auth::user()->id;
	        $objOrder->total_amount_paid = $total;
	        $objOrder->currency = $orders[0]['currency'];
			$objOrder->coupon = $orders[0]['coupon'];
			$objOrder->coupon_applied = $orders[0]['coupon_applied'];
			$objOrder->discount = $orders[0]['discount'];
			$objOrder->save();
            
            if($orders[0]['coupon_applied']==1)
            {
                Coupon::where('code', $orders[0]['coupon'])->where('user_id', Auth::user()->id)->increment('used');
            }
            
	        foreach ($orders as $item)
	        {
                $selectedCourse = Course::where('id', $item['course_id'])->first();
                $selectedCourseTimings = CourseTiming::where('id', $item['course_timing_id'])->first();
	            $obj = new OrderItem();
	            $obj->order_id = $objOrder->id;
				$obj->course_id = $item['course_id'];
				$obj->timing_id = $item['course_timing_id'];
				$obj->manufacturer_id =  $item['manufacturer_id'];
				$obj->category_id =  $item['category_id'];
				$obj->product_id =  $item['product_id'];
				$obj->seats =  $item['seat'];
                $obj->price =  $item['price'];
                $obj->offer_price =  $item['offer_price'];
                
				$obj->duration =  (isset($selectedCourse->duration) ? $selectedCourse->duration : 0);
                $obj->duration_type =  (isset($selectedCourse->duration_type) ? $selectedCourse->duration_type : 'Days');
				
				$obj->location = isset($selectedCourseTimings->location) ? $selectedCourseTimings->location: '';
                $obj->city = isset($selectedCourseTimings->city) ? $selectedCourseTimings->city: '';
                $obj->country = isset($selectedCourseTimings->country) ? $selectedCourseTimings->country: '';
				
				$obj->start_date = isset($selectedCourseTimings->start_date) ? $selectedCourseTimings->start_date : '';
                $obj->date = isset($selectedCourseTimings->date) ? $selectedCourseTimings->date: '';
                
                $obj->start_time = isset($selectedCourseTimings->start_time) ? $selectedCourseTimings->start_time: '';
                $obj->end_time = isset($selectedCourseTimings->end_time) ? $selectedCourseTimings->end_time: '';
                $obj->training_type = isset($selectedCourseTimings->training_type) ? $selectedCourseTimings->training_type: 'N/A';
				
				$obj->amount_paid = $item['offer_price'];			
				$obj->save();
	        }

	        // $order_attendences = CartAttendence::where('user_id', Auth::user()->id)->get()->toArray();
	        // foreach ($order_attendences as $item)
	        // {
	        // 	$item['order_id'] = $objOrder->id;
	        //     OrderAttendence::insert($item);
	        // }
	        // CartAttendence::where('user_id', Auth::user()->id)->delete();
	        
	        \DB::commit();
            $OrderConfirmData =[];
            $OrderConfirmData['order_id'] = $objOrder->id;
            $OrderConfirmData['order_date'] = $objOrder->created_at;
            $OrderConfirmData['order_total'] = $total;

            $courseTimings = [];
            $course_timing_ids = Cart::where('user_id', Auth::user()->id)->pluck('course_timing_id')->toArray();

            if($course_timing_ids){
                $locations = CourseTiming::whereIn('id', $course_timing_ids)->get();
                
                foreach ($locations as $key => $value){
                    $seats = Cart::where('user_id', Auth()->user()->id)->groupBy('course_timing_id')->where('course_timing_id', $value->id)->sum('seat');
                    $seats = $seats ?? 1;
                    $courseTimings[$value->course_id][] =[
                        'start_date'=>\Carbon\Carbon::parse($value->start_date)->format('d/m/Y'),
                        'date'=>\Carbon\Carbon::parse($value->date)->format('d/m/Y'),
                        'start_time'=>date("h:i A", strtotime($value->start_time)),
                        'original_date'=>$value->date,
                        'end_time'=>date("h:i A", strtotime($value->end_time)),
                        'country'=>$value->country,
                        'training_type'=>$value->training_type,
                        'city'=>$value->city,
                        'location'=>$value->location,
                        'seats'=>$seats,
                        'timezone' => $value->timezone
                    ];
                }
            }
            $OrderConfirmData['courseTimings'] = $courseTimings;
            $OrderConfirmData['first_name'] = Auth::user()->first_name;
            Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($OrderConfirmData));
	        Cart::where('user_id', Auth::user()->id)->delete();

            return response()->json(['status'=>true ,'message'=>'The payment made is successfully verified.', 'url'=>url('/mycourses')], 200);
        }catch(\Exception $e){
        	\DB::rollback();
        	return response()->json(['status'=>false, 'message'=>$e->getMessage()],200);
        }
    }


    /**
    * Return count of cart
    **/
    public function cartCount(){
        $total = 0;
        if (auth()->check()){
            $total =  Cart::where('user_id', Auth::user()->id)->count();
        }else
        {
            if(Session::has('carts'))
            {
                $cartdata = session()->get('carts');
                $total = count($cartdata);
            }else{
                $total= 0;
            }
        }
        return $total;
    }
}
