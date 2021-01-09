<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Manufacturer, Category, Location, Course, Cms, Testimonial, CompanyLogo, ServiceCardContent, CourseOutline, CourseTiming, ContactUs, QuoteEnquiry, Setting, Product,ManufacturerCategory, Country, Cart, Faq
};
use PDF;
use App\User;
use Mail;
use App\Mail\ShareCourseNotification;
use Session;
use Auth;
use DB;
use URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $homeFooter = 1;
        $manufacturers = Manufacturer::where('status', 1)->withCount(['courses'=>function($q){
            $q->where('status', 1);
        }])->orderBy('name','asc')->get();
        
        $categories = Category::where('status', 1)->orderBy('name','asc')->get();
        $locations = Location::where('status', 1)->orderBy('name','asc')->get();
        $courses = Product::where('status', 1)->orderBy('name','asc')->get();
        $cmsContent = Cms::first();
        $testimonials = Testimonial::where('status', 1)->get();
        $companies = CompanyLogo::where('status', 1)->get();
        $cards = ServiceCardContent::select('card_number','title')->get();

        return view('frontend.home.index',compact('homeFooter','manufacturers','categories','courses','locations','cmsContent','testimonials','companies','cards'));
    }

    /**
     * Show the application about us page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutUsPage(){
        return view('frontend.aboutus.index');
    }

    /**
     * Show the application gallery page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function galleryPage(){
        return view('frontend.gallery.index');
    }

    /**
     * Show the application help page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getHelpPage(){
        $data = Faq::all();
        return view('frontend.help.index', compact('data'));
    }


    /**
     * Show the training site content page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTrainingSiteInfo(Request $request, $slug){
        $content = Setting::where('type','training-sites')->where('key','LIKE', '%' .$slug. '%')->first();
        if($request->ajax()){
            if(!$content){
                return response()->json(['status'=>false],200);
            }
            return response()->json(['status'=>true],200);
        }else{
            if(!$content){
                return redirect('404');
            }
            return view('frontend.training-site.index', compact('content'));
        }
        
    }

    /**
     * Show the application press release page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function pressReleasePage(){
        return view('frontend.pressRelease.index');
    }

    /**
     * Show the manufacturer's courses.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function manufacturerCourses(Request $request, $title){
        $new_title = str_replace('-',' ',$title);
       
        $manufacturerdata = Manufacturer::where('status', 1)->where('name', $new_title)->firstOrFail();     
        
        $courses = Course::where('status', 1)->with(['category'=>function($q){
            $q->where('status', 1);
        }])->with(['manufacturer'=>function($q){
            $q->where('status', 1);
        }])->with(['product'=>function($q){
            $q->where('status', 1);
        }])->where('manufacturer_id', $manufacturerdata->id);
        
        if($request->filled('val')){
            $order = ($request->val=='asc') ? 'asc' : 'desc';
            $courses->orderBy('offer_price',$order);
        }else{
            $courses->orderBy('id','desc');
        }

        // filter
        if($request->filled('products')){
            $request_products = $request->input('products');
            if($request_products){
                $products_ids_data = Product::where('status', 1)->whereIn('id', $request_products)->select('id','category_id')->get();

                $courses->where(function($q) use($products_ids_data){
                    foreach ($products_ids_data as $key => $value) {
                        $q->orWhere(function($qq) use($value){
                            $qq->where('category_id', $value->category_id);
                            $qq->where('product_id', $value->id);
                        });
                    }
                });
            }
        }

        $courses = $courses->paginate(10);
        
        $categories_ids = Course::where('status', 1)->where('manufacturer_id', $manufacturerdata->id)->pluck('category_id')->toArray();
        $all_categories = Category::where('status', 1)->whereIn('id', $categories_ids)->get();

        if($request->ajax()){
            $html = view('frontend.manufacturers.list', compact('manufacturerdata','courses'))->render();
            return response()->json(['status'=>true,'html'=>$html,'totalCount'=>$courses->count(),'dataTotal'=>$courses->total()],200);
        }

        $manufacturers = Manufacturer::where('status', 1)->withCount(['courses'=>function($q){
            $q->where('status', 1);
        }])->orderBy('name','asc')->get();

        return view('frontend.manufacturers.index',['manufacturerdata'=>$manufacturerdata,'courses'=>$courses,'all_categories'=>$all_categories,'title'=>$title,'manufacturers'=>$manufacturers]);
    }


    /**
    * return details page of particular service card
    **/
    public function services(Request $request, $title){
        $title = str_replace('-',' ',$title);
        $content = ServiceCardContent::where('title', $title)->select('title','content')->firstOrFail();
        return view('frontend.services.index',compact('content'));
    }

    /**
    * return details page of particular service card
    **/
    public function getTermsPage(){
        $content = Setting::where('type','content')->where('key','termcontent')->value('value');
        return view('frontend.terms.index', compact('content'));
    }

    /**
    * return details page of particular service card
    **/
    public function getPrivacyPolicyPage(){
        $content = Setting::where('type','content')->where('key','privacycontent')->value('value');
        return view('frontend.privacy.index', compact('content'));
    }

    public function getCookiePolicyPage(){
        $content = Setting::where('type','content')->where('key','cookiecontent')->value('value');
        return view('frontend.cookiecontent.index', compact('content'));
    }

    /**
    * return course detail page
    **/
    public function courseDetails(Request $request, $title){
        $title = str_replace('-',' ',$title);

        $course = Course::where('status', 1)->where('name', $title)->with(['outlines','manufacturer','locations'])->first();
        if(!$course){
            return redirect('/products');
        }

        $course->increment('views');
        
        $relatedCourse = Course::where('manufacturer_id', $course->manufacturer_id)->where('category_id', $course->category_id)->where('product_id', $course->product_id)->whereNotIn('id', [$course->id])->get();
        
        $request->session()->put('course-detail-id', $course->id);

        $manufacturers = Manufacturer::where('status', 1)->withCount(['courses'=>function($q){
            $q->where('status', 1);
        }])->orderBy('name','asc')->get();
        $categories = Category::where('status', 1)->orderBy('name','asc')->get();
        $locations = Location::where('status', 1)->orderBy('name','asc')->get();
        $courses = Product::where('status', 1)->orderBy('name','asc')->get();

        return view('frontend.courseDetails.index',compact('course','relatedCourse','manufacturers','categories','locations','courses'));
    }

    // return course pdf 
    public function coursePdf(Request $request){
        $course_id = $request->session()->get('course-detail-id');
        
        if(!$course_id || $course_id==null || is_null($course_id)){
            return redirect('404');
        }

        $data = CourseOutline::where('status', 1)->where('course_id', $course_id)->get();
        $course_name = Course::where('id', $course_id)->value('name');
        // return view('pdf.course-outline',['data'=>$data,'course_name'=>$course_name]);
        
        $pdf = PDF::setPaper('a4','portrait')->loadView('pdf.course-outline',['data'=>$data,'course_name'=>$course_name]);
        // dd($pdf->stream('outlines.pdf'));
        return $pdf->stream('outlines.pdf');
    }

    /**
    * return course timings based on location name
    */

    public function courseLocationTimings(Request $request){
        $course = $request->input('course');
        $id = $request->input('id');
        if($course && $id){
            $course_id = decrypt($course);
            $timings = CourseTiming::where('course_id', $course_id)->where('id', $id)->whereDate('date', '>=', date('Y-m-d'))->get();

            $data = [];
            foreach ($timings as $key => $value) {
                $data[] =
                        [
                            'start_date'=>\Carbon\Carbon::parse($value->start_date)->format('d/m/Y'),
                            'date'=>\Carbon\Carbon::parse($value->date)->format('d/m/Y'),
                            'start_time'=>date("h:i A", strtotime($value->start_time)),
                            'original_date'=>$value->date,
                            'id'=>$value->id,
                            'training_type'=>$value->training_type,
                            'end_time'=>date("h:i A", strtotime($value->end_time)),
                        ];
            }
            return response()->json(['status'=>true,'message'=>'Timings found successfully.', 'data'=>$data], 200);

        }else{
            return response()->json(['status'=>false,'message'=>'Location or Time not get.'], 400);
        }
    }

    /**
    * save contact us form data from frontend and display to backend admin panel
    */
    public function contactUs(Request $request){
        if (!auth()->check()){
            $validatedData = $request->validate([
                'first_name' => 'bail|required|string|min:2|max:50',
                'last_name' => 'bail|required|string|min:2|max:50',
                'email' => 'bail|required|string|email|max:50',
                'phone' => 'bail|required|numeric|digits_between:5,15',
                'country_code' => 'bail|required|string|max:50',
                'country' => 'bail|required|string|max:50',
                'state' => 'bail|nullable|string|max:50',
                'city' => 'bail|required|string|max:50',
                'message' => 'bail|required|string',
            ]);

            $obj = new ContactUs;
            $obj->first_name = $request->input('first_name');
            $obj->last_name = $request->input('last_name');
            $obj->email = $request->input('email');
            $obj->phone = $request->input('phone');
            $obj->message = $request->input('message');
            $obj->country_code = $request->input('country_code');
            $obj->country = $request->input('country');
            $obj->state = $request->input('state');
            $obj->city = $request->input('city');
            $obj->zipcode = $request->input('zipcode') ? $request->input('zipcode') : 0;
            $obj->company_name = $request->input('company_name') ? $request->input('company_name') : 'N/A';
            if($obj->save())
            {
                $contact_email = Setting::where('type','contactemails')->where('key','contact_email')->value('value');
                $data = $request->all();
                $data['type'] = 'contact';
                User::sendContactMailToAdmin($contact_email,$data);
                User::sendContactMailToUser($request->input('email'),$data);

                $replyMessage = "Thank you ".$request->input('first_name')." your request details have been successfully sent.";
                $replyMessage.="\n\n";
                $replyMessage.="Our Agent will contact you shortly.";
                $replyMessage.="\n\n";
                $replyMessage.="Wish you a nice day";
                return response()->json(['status'=>true,'message'=>$replyMessage], 200);
            }
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200);
        }
        else{
            $validatedData = $request->validate([
                'message' => 'bail|required|string',
            ]);

            $data = [];
            $data['first_name'] = Auth::user()->first_name;
            $data['last_name'] = Auth::user()->last_name  ?? '';
            $data['email'] = Auth::user()->email;
            $data['phone'] = Auth::user()->phone ?? '';
            $data['company_name'] = Auth::user()->company_name ?? '';
            $data['country_code'] = Auth::user()->country_code ?? '';
            $data['country'] = Auth::user()->country ?? '';
            $data['state'] = Auth::user()->state ?? '';
            $data['city'] = Auth::user()->city ?? '';
            $data['zipcode'] = Auth::user()->zipcode ?? '';
            $data['message'] = $request->message;

            if(ContactUs::create($data))
            {
                $contact_email = Setting::where('type','contactemails')->where('key','contact_email')->value('value');
                
                $data['type'] = 'contact';
                User::sendContactMailToAdmin($contact_email,$data);
                User::sendContactMailToUser(Auth::user()->email,$data);

                $replyMessage = "Thank you ".Auth::user()->first_name." your request details have been successfully sent.";
                $replyMessage.="\n\n";
                $replyMessage.="Our Agent will contact you shortly.";
                $replyMessage.="\n\n";
                $replyMessage.="Wish you a nice day";
                return response()->json(['status'=>true,'message'=>$replyMessage], 200);
            }
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200);
        }
    }


    /**
    * Save quotes query to database and display to admin panel.
    */
    public function quoteQuery(Request $request){
        if (!auth()->check()){
            return response()->json(['status'=>false,'message'=>'Please login to submit quote'], 200);
        }
        
        if(!$request->input('course_page')){
            $request->validate([
                'message' => 'bail|required|string|max:5000',
                'course' => 'bail|required|max:200',
                'category'=>'bail|required',
                'manufacturer'=>'bail|required',
                'product'=>'bail|required',
            ]);
        }else{
            $request->validate([
                'message' => 'bail|required|string|max:5000',
                'course' => 'bail|required|max:200',
            ]);
        }
    
        try{
            DB::beginTransaction();
            $data = [];
            $data['first_name'] = Auth::user()->first_name;
            $data['last_name'] = Auth::user()->last_name  ?? '';
            $data['email'] = Auth::user()->email;
            $data['phone'] = Auth::user()->phone ?? '';
            $data['company_name'] = Auth::user()->company_name ?? '';
            $data['country_code'] = Auth::user()->country_code ?? '';
            $data['country'] = Auth::user()->country ?? '';
            $data['state'] = Auth::user()->state ?? '';
            $data['city'] = Auth::user()->city ?? '';
            $data['zipcode'] = Auth::user()->zipcode ?? '';

            $data['message'] = $request->message;
            $data['course'] = is_array($request->input('course')) ? implode(',', $request->input('course')) : $request->input('course');
            $data['course_id'] = is_array($request->input('course_page_course_id')) ? implode(',', $request->input('course_page_course_id')) : ($request->input('course_page_course_id') ?? 0);
            
            $res = QuoteEnquiry::create($data);
            if($res)
            {
                $quotes_email = Setting::where('type','contactemails')->where('key','quotes_email')->value('value');
                $data['type'] = 'quotes';
                User::sendContactMailToAdmin($quotes_email,$data);
                User::sendContactMailToUser(Auth::user()->email,$data);

                $replyMessage = "Thank you ".Auth::user()->first_name." your request details have been successfully sent.";
                $replyMessage.="\n\n";
                $replyMessage.="Our Agent will contact you shortly.";
                $replyMessage.="\n\n";
                $replyMessage.="Wish you a nice day";
                DB::commit();
                return response()->json(['status'=>true,'message'=>$replyMessage], 200);
            }
            DB::rollback();
            return response()->json(['status'=>false,'message'=>'Something went wrong1. Please try again later.'], 200);
        }
        catch(\Exception $e){
            dd($e);
            DB::rollback();
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200);
        }
    }


    // request quote from locations modal
    public function quoteQueryLocationsModal(Request $request){
        if (!auth()->check()){
            return response()->json(['status'=>false,'message'=>'Please login to submit quote'], 200);
        }

        $course_id = decrypt($request->course);
        $course = Course::where('id', $course_id)->first();
        if(!$course){
            return response()->json(['status'=>false , 'message'=>'Oops, Course not found. Please try again later.'], 200);
        }
        
        $request->validate([
            'message' => 'bail|required|string|max:5000',
            'course' => 'bail|required|max:200',
            'course_timing_id' => 'bail|required|array',
        ]);
    
        try{
            DB::beginTransaction();
            $data = [];
            $data['first_name'] = Auth::user()->first_name;
            $data['last_name'] = Auth::user()->last_name  ?? '';
            $data['email'] = Auth::user()->email;
            $data['phone'] = Auth::user()->phone ?? '';
            $data['company_name'] = Auth::user()->company_name ?? '';
            $data['country_code'] = Auth::user()->country_code ?? '';
            $data['country'] = Auth::user()->country ?? '';
            $data['state'] = Auth::user()->state ?? '';
            $data['city'] = Auth::user()->city ?? '';
            $data['zipcode'] = Auth::user()->zipcode ?? '';

            $data['message'] = $request->message;
            $data['course'] = $course->name;
            $data['course_id'] = $course_id;

            $res = QuoteEnquiry::create($data);
            if($res)
            {
                $adminMail = Setting::where('type','contactemails')->where('key','quotes_email')->value('value');
                $data['type'] = 'quotes';
                $course_timing_ids = $request->input('course_timing_id');
                $course_timing_ids = $course_timing_ids ?? [];
                
                $courseTimings = [];
                if($course_timing_ids){
                    $locations = CourseTiming::whereIn('id', $course_timing_ids)->whereDate('date', '>=', date('Y-m-d'))->get();

                    foreach ($locations as $key => $value){
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
                            'course_name'=>$value->course->name,
                            'timezone'=>$value->timezone
                        ];
                    }
                }
                $data['courseTimings'] = $courseTimings;

                User::sendLocationsQuoteMailToAdmin($adminMail,$data);
                User::sendLocationsQuoteMailToUser(Auth::user()->email,$data);

                $replyMessage = "Thank you ".Auth::user()->first_name." your request details have been successfully sent.";
                $replyMessage.="\n\n";
                $replyMessage.="Our Agent will contact you shortly.";
                $replyMessage.="\n\n";
                $replyMessage.="Wish you a nice day";
                DB::commit();
                return response()->json(['status'=>true,'message'=>$replyMessage], 200);
            }
            DB::rollback();
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200);
        }
        catch(\Exception $e){
            dd($e);
            DB::rollback();
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200);
        }
    }

    /**
    * Save quotes query from cart page  to database and display to admin panel.
    */
    public function cartQuoteQuery(Request $request){
        if (!auth()->check()){
            return response()->json(['status'=>false,'message'=>'Please login to submit quote'], 200);
        }
        $errors = [
                'message' => 'bail|required|string|max:5000',
                'quote_selection'=>'bail|required'
            ];
        $request->validate($errors);

        if($request->input('quote_selection')=='new'){
            $errors['category'] = 'bail|required|numeric';
            $errors['manufacturer'] = 'bail|required|numeric';
            $errors['product'] = 'bail|required|numeric';
            $errors['course'] = 'bail|required|max:200';
            $request->validate($errors);
        }
        
        try{
            DB::beginTransaction();
            if (auth()->check()){
                $obj = new QuoteEnquiry;
                $obj->first_name = Auth::user()->first_name;
                $obj->last_name = Auth::user()->last_name  ?? null;
                $obj->email = Auth::user()->email;
                $obj->phone = Auth::user()->phone ?? 0;
                $obj->company_name = Auth::user()->company_name ?? "N/A";
                $obj->country_code = Auth::user()->country_code ?? 0;
                $obj->country = Auth::user()->country ?? "N/A";
                $obj->state = Auth::user()->state ?? "N/A";
                $obj->city = Auth::user()->city ?? "N/A";
                $obj->zipcode = Auth::user()->zipcode ?? 0;
            }

            $obj->message = $request->input('message');
            
            $course_name = '';
            $course_ids = [];
            $course_timing_ids = [];
            
            if($request->input('quote_selection')=='cart'){
                if (auth()->check()){
                    $course_ids = Cart::where('user_id', Auth()->user()->id)->groupBy('course_id')->pluck('course_id')->toArray();
                    $course_timing_ids = Cart::where('user_id', Auth()->user()->id)->groupBy('course_timing_id')->pluck('course_timing_id')->toArray();         
                }
               
                
                $courses = Course::whereIn('id', $course_ids)->pluck('name')->toArray();
                $temp_name = '';
                if($courses){
                    foreach ($courses as $key => $value) {
                        if($key==0){
                            $temp_name=$value;
                        }else{
                            $temp_name=$temp_name.', '.$value;
                        }
                    }
                }
                $course_name = $temp_name;

            }else{
                $course_ids = array($request->input('course'));
                $course_name = Course::where('id', $request->input('course'))->value('name');
            }
            $obj->course = $course_name;
            $obj->course_id = is_array($course_ids) ? implode(',', $course_ids) : $course_ids;

            if($obj->save()){
                $quotes_email = Setting::where('type','contactemails')->where('key','quotes_email')->value('value');
                $data = [];
                $data['type'] = 'quotes';
                $data['course'] = $course_name;
                $data['message'] = $request->message;
                $user_email = '';
                $user_name = '';
                if(auth()->check()){
                    $data['first_name'] = Auth::user()->first_name;
                    $user_name = Auth::user()->first_name;
                    $data['last_name'] = Auth::user()->last_name  ?? 'N/A';
                    $data['email'] = Auth::user()->email;
                    $user_email = Auth::user()->email;
                    $data['phone'] = Auth::user()->phone ?? 'N/A';
                    $data['company_name'] = Auth::user()->company_name ?? 'N/A';
                    $data['country_code'] = Auth::user()->country_code ?? 'N/A';
                    $data['country'] = Auth::user()->country ?? 'N/A';
                    $data['state'] = Auth::user()->state ?? 'N/A';
                    $data['city'] = Auth::user()->city ?? 'N/A';
                    $data['zipcode'] = Auth::user()->zipcode ?? 'N/A';
                }
                $courseTimings = [];

                if($course_timing_ids){
                    

                    $locations = CourseTiming::whereIn('id', $course_timing_ids)->whereDate('date', '>=', date('Y-m-d'))->get();

                    foreach ($locations as $key => $value)
                    {
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
                            'course_name'=>$value->course->name,
                            'course_id'=>$value->course_id,
                            'seats'=>$seats,
                        ];
                    }
                }
                $data['courseTimings'] = $courseTimings;
                User::sendContactMailToAdmin($quotes_email,$data);
                User::sendContactMailToUser($user_email,$data);

                $replyMessage = "Thank you ".$user_name." your request details have been successfully sent.";
                $replyMessage.="\n\n";
                $replyMessage.="Our Agent will contact you shortly.";
                $replyMessage.="\n\n";
                $replyMessage.="Wish you a nice day";

                DB::commit();
                return response()->json(['status'=>true,'message'=>$replyMessage], 200);
            }
            DB::rollback();
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200);
        }
        catch(\Exception $e){
            dd($e);
            DB::rollback();
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200);
        }
    }

    /**
    * get quote manufacturer based on category
    */
    public function getQuoteManufacturers(Request $request){
        $category = $request->input('category');
        if(is_array($category)){
            $manufacturers_ids = ManufacturerCategory::whereIn('category_id', $category)->pluck('manufacturer_id')->toArray();
        }else{
            $manufacturers_ids = ManufacturerCategory::where('category_id', $category)->pluck('manufacturer_id')->toArray();
        }
        
        $manufacturers = Manufacturer::where('status', 1)->whereIn('id', $manufacturers_ids)->select('id','name')->orderBy('name','asc')->get();

        return response()->json(['status'=>true,'manufacturers'=>$manufacturers], 200);
    }

    /**
    * get quote products based on category & manufacturer
    */
    public function getQuoteProducts(Request $request){
        $category = $request->input('category');
        $manufacturer = $request->input('manufacturer');

        $products = Product::where('status', 1);

        if(is_array($category)){
            $products->whereIn('category_id', $category);
        }else{
            $products->where('category_id', $category);
        }

        if(is_array($manufacturer)){
            $products->whereIn('manufacturer_id', $manufacturer);
        }else{
            $products->where('manufacturer_id', $manufacturer);
        }
        $products = $products->select('id','name')->orderBy('name','asc')->get();

        return response()->json(['status'=>true,'products'=>$products], 200);
    }

    /**
    * get quote courses based on category & manufacturer & product
    */
    public function getQuoteCourses(Request $request){
        $category = $request->input('category');
        $manufacturer = $request->input('manufacturer');
        $product = $request->input('product');

        $courses = Course::where('status', 1);

        if(is_array($category)){
            $courses->whereIn('category_id', $category);
        }else{
            $courses->where('category_id', $category);
        }

        if(is_array($manufacturer)){
            $courses->whereIn('manufacturer_id', $manufacturer);
        }else{
            $courses->where('manufacturer_id', $manufacturer);
        }

        if(is_array($product)){
            $courses->whereIn('product_id', $product);
        }else{
            $courses->where('product_id', $product);
        }

        $courses = $courses->select('id','name')->orderBy('name','asc')->get();

        return response()->json(['status'=>true,'courses'=>$courses], 200);
    }

    
    public function generateShortCode($url){
        $input['link'] = $url;
        $input['code'] = str_random(6);
        \App\Models\ShortLink::create($input);
        
        return $input['code'];
    }


    public function shortenLink(Request $request, $slug)
    {
        
        $find = \App\Models\ShortLink::where('code', $slug)->first();
        if(!$find){
            return redirect('/products');
        }
        return redirect('/course/'.$find->link);
    }

    /**
    * share course event
    */
    public function shareCourse(Request $request){
        $request->validate([
            'email'=>'bail|required|email',
            'message'=>'bail|required|max:500',
            'id'=>'bail|required|numeric'
        ]);
        \DB::beginTransaction();
        try{
            $course_name = Course::where('id', $request->id)->select('course_name_slug','name')->first();
            $data['course_name_slug'] = isset($course_name->course_name_slug) ? $course_name->course_name_slug: 'test';
            
            $code = self::generateShortCode($data['course_name_slug']);
            $data['name'] = isset($course_name->name) ? $course_name->name: 'test';
            $data['code'] = $code;
            $data['message'] = $request->message;

            try{
                Mail::to($request->email)->send(new ShareCourseNotification($data));
                \DB::commit();
                return response()->json(['status'=>true,'message'=>'Mail send successfully.'],200);
            }catch(\Exception $e){
                \DB::rollback();
                return response()->json(['status'=>false,'message'=>$e->getMessage()],200);
            }
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['status'=>false,'message'=>$e->getMessage()],200);
        }
    }


    /**
    * advance filter manufacturer change events
    **/
    public function advanceFilterManufactuerData(Request $request){
        $manufacturer_id = $request->input('manufacturer');
        $categories = [];
        $courses = [];
        $temp_cat = [];
        $temp_cou = [];

        if(!$manufacturer_id){
            $temp_cat = Category::where('status', 1)->get();
            $temp_cou = Product::where('status', 1)->get();
        }
        else
        {
            $categories_ids = ManufacturerCategory::whereIn('manufacturer_id', $manufacturer_id)->pluck('category_id')->toArray();
            $temp_cat = Category::where('status', 1)->whereIn('id', $categories_ids)->get();

            $temp_cou = Product::where('status', 1)->whereIn('manufacturer_id', $manufacturer_id)->get();
        }

        foreach ($temp_cat as $key => $value) {
            $categories[] = ['id'=>$value->id,'name'=>ucfirst($value->name),'slug_name'=>str_slug($value->name)];
        }

        foreach ($temp_cou as $key => $value) {
            $courses[] = ['id'=>$value->id,'name'=>ucfirst($value->name),'slug_name'=>str_slug($value->name)];
        }

        return response()->json(['status'=>true,'categories'=>$categories,'courses'=>$courses], 200);
    }

    public function advanceFilterCategoryData(Request $request){
        $temp_cou = Product::where('status', 1);
        $manufacturer_id = $request->input('manufacturer');
        if(!$manufacturer_id){
            $manufacturer_id = [];
        }
        $category_id = $request->input('category');
        if($category_id){
            $temp_cou->whereIn('category_id', $category_id);
        }

        if($manufacturer_id){
            $temp_cou->whereIn('manufacturer_id', $manufacturer_id);
        }

        $temp_cou = $temp_cou->get();

        $courses = [];
        foreach ($temp_cou as $key => $value) {
            $courses[] = ['id'=>$value->id,'name'=>ucfirst($value->name),'slug_name'=>str_slug($value->name)];
        }

        return response()->json(['status'=>true,'courses'=>$courses], 200);
    }

    public function getCountryCode(Request $request){
        $country = Country::where('id', $request->id)->first();
        if(!$country){
            return response()->json(['status'=>false,'data'=>[]], 200);
        }
        return response()->json(['status'=>true,'data'=>$country], 200);
    }

    public function getCourseLocations(Request $request){
        $now = now()->setTimezone(config('constants.TIMEZONE'));
        $date_now = $now->format("Y-m-d");
        $time_now = $now->format("H:i:s");
        $now_time = $now->format('Y-m-d H:i:s');
        $id = $request->id;
        $course = Course::where('id',$id)->first();
        $locations = CourseTiming::where('course_id', $id)->where('dubai_start_date_time', '>=', $now_time)->get();
        // dd($locations[0]->start_time ,date('H:i:s'), $locations[0]->start_time > date('H:i:s'),$locations);
        // foreach($locations as $key=>$location)
        // {
        //     if($location->start_date == $date_now)
        //     {
        //         if($location->start_time < $time_now)
        //         {
        //             unset($locations[$key]);
        //         }
        //     }
        // }
        $data = [];

        if (auth()->check()){
            $courses_data = Cart::where('user_id', Auth::user()->id)->select('course_id','course_timing_id')->get()->toArray();          
        }
        else{
            $courses_data = [];
            if(Session::has('carts'))
            {
                $courses_data = session()->get('carts');
            }
        }
        foreach ($locations as $key => $value)
        {
            $already_added =false;
            $course_ids = array_column($courses_data, 'course_id');
            $course_timing_ids = array_column($courses_data, 'course_timing_id');
            if(in_array($id, $course_ids)){
                if(in_array($value->id, $course_timing_ids)){
                    $already_added =true;
                }
            }
            $address = '';
            if($value->location){
                $address = $value->location;
            }
            if($value->city){
                if($address){
                    $address = $address.','.$value->city;
                }else{
                    $address = $value->city;
                }
            }
            if($value->country){
                if($address){
                    $address = $address.','.$value->country;
                }else{
                    $address = $value->country;
                }
            }
                
            $data[] =
            [
                'start_date'=>\Carbon\Carbon::parse($value->start_date)->format('d/m/Y'),
                'date'=>\Carbon\Carbon::parse($value->date)->format('d/m/Y'),
                'start_time'=>date("h:i A", strtotime($value->start_time)),
                'original_date'=>$value->date,
                'id'=>$value->id,
                'end_time'=>date("h:i A", strtotime($value->end_time)),
                'country'=>$value->country,
                'training_type'=>$value->training_type,
                'timezone'=>$value->timezone,
                'city'=>$value->city,
                'location'=>$value->location,
                'already_added'=>$already_added,
                'address'=>$address
            ];
        }

        return response()->json(['status'=>true,'data'=>$data,'course'=>$course], 200);
    }

    /**
    * show all products based on master search
    */
    public function courseListing(Request $request){
       // dd($request->all());
        //echo "<pre>";
        //print_r($request->all());die();
        $homeFooter = 1;
        //\DB::enableQueryLog();
        $now = now()->setTimezone(config('constants.TIMEZONE'))->format('Y-m-d H:i:s');
        $data = Course::where('status', 1)->whereHas('manufacturer',function($qu)
                    {
                        $qu->where('status',1);
                    })->whereHas('category',function($qu)
                    {
                        $qu->where('status',1);
                    })->whereHas('product',function($qu)
                    {
                        $qu->where('status',1);
                    });
        // $data->whereHas('locations', function($q) use($request,$now){
        //         $q->where("dubai_start_date_time",">=", $now);
        //     });
                    
        if($request->filled('course_name')){
            $data = $data->where('name', 'LIKE', '%' .trim(html_entity_decode($request->input('course_name'))). '%');
        }
        

        // Manufactuers based filters------------------------------
        $urlManufacturers =[];
        $manufacturer_data= [];
        if($request->filled('manufacturers')){
            if(is_array($request->manufacturers)){
                $urlManufacturers = $request->manufacturers;

                $manufacturer_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->manufacturers);
            }

            $data = $data->whereHas('manufacturer', function($q) use($manufacturer_data){
                $q->whereIn('name', $manufacturer_data);
            });

            if($manufacturer_data){
                $temp_manufacturer = [];
                foreach ($manufacturer_data as $key => $value) {
                    $temp_manufacturer[] = strtoupper($value);
                }
                $manufacturer_data = $temp_manufacturer;
            }
        }
        


        // Category based filters------------------------------
        $urlCategories =[];
        $categories_ids = [];
        $category_data =[]; 
        if($request->filled('categories'))
        {
            if(is_array($request->categories))
            {
                $urlCategories = $request->categories;
                $category_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->categories);
            }
            $category_data = array_unique($category_data);
            $categories_ids = Category::whereIn('name', $category_data)->pluck('id')->toArray();

            $data = $data->whereIn('category_id', $categories_ids);

            if($category_data){
                $temp_cat = [];
                foreach ($category_data as $key => $value) {
                    $temp_cat[] = strtoupper($value);
                }
                $category_data = $temp_cat;
            }
        }

        $family = '';

        if($request->filled('family'))
        {
            $categories_ids[] = $request->family;
            $family = $request->family;

        }
        if($categories_ids){
            $data->whereIn('category_id', $categories_ids);
        }
     

        
        // Products based filters------------------------------
        // check if request contain sub-categories.
        $products_id = [];
        $products_data = [];
        if($request->filled('courses')){
            if(is_array($request->courses))
            {
                $urlCourses = $request->courses;
                $products_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->courses);
                // dd($urlCourses,$products_data);
            }
            $products_id = Product::whereIn('name', $products_data)->pluck('id')->toArray();
            $cat_ids = Product::whereIn('name', $products_data)->pluck('category_id')->toArray();
            $getCategories = Category::whereIn('id',$cat_ids)->get();
            foreach($getCategories as $gc)
            {
                array_push($urlCategories,trim(str_replace(' ', '-', str_slug($gc->name))));
            }
            $products_id = array_unique($products_id);

            if($products_data){
                $temp_product = [];
                foreach ($products_data as $key => $value) {
                    $temp_product[] = ['name'=>strtoupper($value),'slug'=>str_slug(strtoupper($value))];
                }
                $products_data = $temp_product;
            }
        }
        

        // special filter
        if($products_id){
            $products_ids_data = Product::whereIn('id', $products_id)->select('id','category_id')->get();
            $data = $data->where(function($q) use($products_ids_data){
                foreach ($products_ids_data as $key => $value) {
                    $q->orWhere(function($qq) use($value){
                        $qq->where('category_id', $value->category_id);
                        $qq->where('product_id', $value->id);
                    });
                }
            });
        }else{
            if($categories_ids)
            {
                $data = $data->whereIn('category_id', $categories_ids);
            }
        }

        // Locations based filters------------------------------
        $location_data=[];
        $locations_id=[];
        if($request->filled('locations')){
            if(is_array($request->locations)){
                $locations_id = $request->locations;
            }
            if($locations_id){
                $location_data = Location::whereIn('id', $locations_id)->pluck('name')->toArray();
                $data->whereHas('locations', function($query) use($location_data){
                    $query->whereIn('country',$location_data);
                    $query->whereDate('dubai_start_date_time', '<', now()->setTimezone(config('constants.TIMEZONE'))->format('Y-m-d'));
                });
                
                 // dd($location_data,$data->get());
            }
        }
         $extra_data =clone $data;
        $data = $data->whereHas('locations', function($q) use($request,$now){
             $q->where("dubai_start_date_time",">=", $now);
        });

        // date based filters------------------------------
        $from_date = '';
        $to_date = '';

        if($request->filled('start_date') && $request->filled('end_date')){
            $from_date = $request->start_date;
            $to_date = $request->end_date;

            $data = $data->whereHas('locations', function($q) use($request,$now){
                $date1 = str_replace('/', '-', $request->start_date);
                $date1 = date('Y-m-d', strtotime($date1));
                $date2 = str_replace('/', '-', $request->end_date);
                $date2 = date('Y-m-d', strtotime($date2));
                
                $q->whereDate('dubai_start_date_time','>=' ,$date1)->whereDate('dubai_start_date_time','<=' ,$date2);
            });
        }
        elseif ($request->filled('start_date')) {
            $from_date = $request->start_date;

            $data = $data->whereHas('locations', function($q) use($request,$now){
                $date1 = str_replace('/', '-', $request->start_date);
                $date1 = date('Y-m-d', strtotime($date1));

                $q->whereDate('dubai_start_date_time','>=' ,$date1);
            });
        }
        elseif($request->filled('end_date')){
            $to_date = $request->end_date;
            
            $data = $data->whereHas('locations', function($q) use($request,$now){
                $date2 = str_replace('/', '-', $request->end_date);
                $date2 = date('Y-m-d', strtotime($date2));
                $to_date = $date2;

                $q->whereDate('date','<=' ,$date2);
            });
        }else{}

        if($request->filled('val')){
            $order = $request->val;
            switch ($order) {
                case 'priceasc':
                    $data->orderBy('offer_price','asc');
                    // $extra_data->orderBy('offer_price','asc');
                    break;
                case 'pricedesc':
                    $data->orderBy('offer_price','desc');
                    // $extra_data->orderBy('offer_price','desc');
                    break;
                default:
                    $data->orderBy('order','asc');
                    // $extra_data->orderBy('order','asc');
                    break;
            }  
        }else{
            $data->orderBy('order','asc');
            // $extra_data->orderBy('order','asc');
        }
        $check_data =clone $data;
        $selected_ids = $check_data->pluck('id')->toArray();
        $data = $data->paginate(10);
        $schedule_data =clone $extra_data;
        $selected_sch_ids = $schedule_data->take(50)->pluck('id')->toArray();
        if(isset($request->start_date) || isset($request->end_date))
        {
            $extra_data = $extra_data->whereNotIn('id',$selected_ids);
        }
        $extra_data = $extra_data
        // ->whereHas('product',function($qu)
        // {
        //     $qu->orderBy('name','asc');
        // })
        ->orderBy('order','asc')
        ->take(50)->get()->sortBy('product_id');
            
        $totalCount = $data->count();
        $dataTotal = $data->total();
        $dataTotal = $dataTotal ?? 0;
        $product_array=[];
        $product_category_array=[];
        if(!empty($products_ids_data))
        {
        foreach($products_ids_data as $pro_id){
            $product_array[]=["pro_id"=>$pro_id->id];
            $product_category_array[]=["pro_cat"=>$pro_id->category_id];
        }
       }
        
        $suggestions = [];
        if(isset($request->manufacturers) || isset($request->courses) || isset($request->locations) || isset($request->start_date) || isset($request->end_date))
        {
            $suggestions = self::getSuggestionCourses($dataTotal, $request,$selected_sch_ids,$product_array,$product_category_array);
        }
        $suggestion_paginate = 0;
        if($suggestions){
            $suggestion_paginate = 1;
        }
        //print_r(\DB::getQueryLog());die;
        // if($request->ajax())
        // {
        //     $html = view('frontend.products.courses', compact('data','suggestions','suggestion_paginate'))->render();
        //     return response()->json([
        //      'status'=>true,
        //      'html'=>$html,
        //      'totalCount'=>$totalCount,
        //      'dataTotal'=>$dataTotal,
        //      'from_date'=>$from_date,
        //      'to_date'=>$to_date,
        //      'suggestion_paginate'=>$suggestion_paginate,
        //     ],200);
        // }
        $manufacturers = Manufacturer::where('status', 1)->orderBy('name','asc')->get();

        $manufacturersData =[];
        foreach ($manufacturers as $key => $value) {
            $manufacturersData[] = $value->id;
        }
        $activeCategories = Course::where('status', 1)->whereIn('manufacturer_id', $manufacturersData)->distinct('category_id')->pluck('category_id')->toArray();
        
        $categories = Category::where('status', 1)->whereIn('id',$activeCategories)->orderBy('name','asc')->get();
        $locations = Location::where('status', 1)->orderBy('name','asc')->get();
        $courses = Product::where('status', 1)->orderBy('name','asc')->get();
       // dd($extra_data);
        $category_banner_image=$extra_data->groupBy('category_id')->first();
        $category_count_banner=$extra_data->groupBy('category_id')->count();
       //$d= $category_banner_image->first();
        // echo "<pre>";
        // print_r($category_banner_image['category_id']);die();
        $count_Course='';
        $show_Course='';
        $count_Course_product='';
        if($category_count_banner==1)
        {
        $liste=[];
        foreach($category_banner_image as $category_banner_images){
            $dd=$category_banner_images->category_id ."<br>";
            array_push($liste,$dd);
        }
        $category_banner_id=array_unique($liste);
        $category_banner_image=Category::whereIn('id',$category_banner_id)->first();
        $count_Course=Course::where('category_id',$category_banner_image->id)->get()->count();
        $show_Course=Product::where('category_id',$category_banner_image->id)->take(5)->get();
        $count_Course_product=Product::where('category_id',$category_banner_image->id)->get();


        }
        $search_flag='p';
       //print_r($products_data);die();
        //dd($extra_data);
        return view('frontend.products.index', compact('search_flag','manufacturers','categories','courses','locations','data','urlCategories','urlManufacturers','totalCount','categories_ids','category_data','products_data','manufacturer_data','dataTotal','products_id','location_data','locations_id','family','suggestions','suggestion_paginate','from_date','to_date','extra_data','category_count_banner','category_banner_image','count_Course','show_Course','count_Course_product'));
    }

    public function courseListingAjax(Request $request){
        $homeFooter = 1;
        //\DB::enableQueryLog();
        $now = now()->setTimezone(config('constants.TIMEZONE'))->format('Y-m-d H:i:s');
        $data = Course::where('status', 1)->whereHas('manufacturer',function($qu)
                    {
                        $qu->where('status',1);
                    })->whereHas('category',function($qu)
                    {
                        $qu->where('status',1);
                    })->whereHas('product',function($qu)
                    {
                        $qu->where('status',1);
                    });
        // $data->whereHas('locations', function($q) use($request,$now){
        //         $q->where("dubai_start_date_time",">=", $now);
        //     });

        if($request->filled('course_name')){
            $data->where('name', 'LIKE', '%' .trim(html_entity_decode($request->input('course_name'))). '%');
        }

        // Manufactuers based filters------------------------------
        $urlManufacturers =[];
        $manufacturer_data= [];
        if($request->filled('manufacturers')){
            if(is_array($request->manufacturers)){
                $urlManufacturers = $request->manufacturers;

                $manufacturer_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->manufacturers);
            }

            $data->whereHas('manufacturer', function($q) use($manufacturer_data){
                $q->whereIn('name', $manufacturer_data);
            });

            if($manufacturer_data){
                $temp_manufacturer = [];
                foreach ($manufacturer_data as $key => $value) {
                    $temp_manufacturer[] = strtoupper($value);
                }
                $manufacturer_data = $temp_manufacturer;
            }
        }
        
        // Category based filters------------------------------
        $urlCategories =[];
        $categories_ids = [];
        $category_data =[]; 
        if($request->filled('categories'))
        {
            if(is_array($request->categories))
            {
                $urlCategories = $request->categories;
                $category_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->categories);
            }
            $category_data = array_unique($category_data);
            $categories_ids = Category::whereIn('name', $category_data)->pluck('id')->toArray();

            $data->whereIn('category_id', $categories_ids);

            if($category_data){
                $temp_cat = [];
                foreach ($category_data as $key => $value) {
                    $temp_cat[] = strtoupper($value);
                }
                $category_data = $temp_cat;
            }
        }

        $family = '';

        if($request->filled('family'))
        {
            $categories_ids[] = $request->family;
            $family = $request->family;

        }
        if($categories_ids){
            $data->whereIn('category_id', $categories_ids);
        }

        
        // Products based filters------------------------------
        // check if request contain sub-categories.
        $products_id = [];
        $products_data = [];
        if($request->filled('courses')){
            if(is_array($request->courses))
            {
                $products_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->courses);
            }
            $products_id = Product::whereIn('name', $products_data)->pluck('id')->toArray();
            $products_id = array_unique($products_id);

            if($products_data){
                $temp_product = [];
                foreach ($products_data as $key => $value) {
                    $temp_product[] = ['name'=>strtoupper($value),'slug'=>str_slug(strtoupper($value))];
                }
                $products_data = $temp_product;
            }
        }
        

        // special filter
        if($products_id){
            $products_ids_data = Product::whereIn('id', $products_id)->select('id','category_id')->get();
            $data->where(function($q) use($products_ids_data){
                foreach ($products_ids_data as $key => $value) {
                    $q->orWhere(function($qq) use($value){
                        $qq->where('category_id', $value->category_id);
                        $qq->where('product_id', $value->id);
                    });
                }
            });
        }else{
            if($categories_ids)
            {
                $data->whereIn('category_id', $categories_ids);
            }
        }

        // Locations based filters------------------------------
        $location_data=[];
        $locations_id=[];
        if($request->filled('locations')){
            if(is_array($request->locations)){
                $locations_id = $request->locations;
            }
            if($locations_id){
                $location_data = Location::whereIn('id', $locations_id)->pluck('name')->toArray();
                $data->whereHas('locations', function($query) use($location_data){
                    $query->whereIn('country',$location_data);
                    $query->whereDate('dubai_start_date_time', '>=', date('Y-m-d'));
                });
                 // dd($location_data,$data->get());
            }
        }
         $extra_data =clone $data;
        $data = $data->whereHas('locations', function($q) use($request,$now){
             $q->where("dubai_start_date_time",">=", $now);
        });

        // date based filters------------------------------
        $from_date = '';
        $to_date = '';

        if($request->filled('start_date') && $request->filled('end_date')){
            $from_date = $request->start_date;
            $to_date = $request->end_date;

            $data->whereHas('locations', function($q) use($request){
                $date1 = str_replace('/', '-', $request->start_date);
                $date1 = date('Y-m-d', strtotime($date1));
                $date2 = str_replace('/', '-', $request->end_date);
                $date2 = date('Y-m-d', strtotime($date2));
                

                $q->whereDate('dubai_start_date_time','>=' ,$date1)->whereDate('dubai_start_date_time','<=' ,$date2);
            });
        }
        elseif ($request->filled('start_date')) {
            $from_date = $request->start_date;

            $data->whereHas('locations', function($q) use($request){
                $date1 = str_replace('/', '-', $request->start_date);
                $date1 = date('Y-m-d', strtotime($date1));

                $q->whereDate('dubai_start_date_time','>=' ,$date1);
            });
        }
        elseif($request->filled('end_date')){
            $to_date = $request->end_date;
            
            $data->whereHas('locations', function($q) use($request){
                $date2 = str_replace('/', '-', $request->end_date);
                $date2 = date('Y-m-d', strtotime($date2));
                $to_date = $date2;

                $q->whereDate('dubai_start_date_time','<=' ,$date2);
            });
        }else{}


        if($request->filled('val')){
            $order = $request->val;
            switch ($order) {
                case 'priceasc':
                    $data->orderBy('offer_price','asc');
                    // $extra_data->orderBy('offer_price','asc');
                    break;
                case 'pricedesc':
                    $data->orderBy('offer_price','desc');
                    // $extra_data->orderBy('offer_price','desc');
                    break;
                default:
                    $data->orderBy('order','asc');
                    // $extra_data->orderBy('order','asc');
                    break;
            }  
        }else{
            $data->orderBy('order','asc');
            $data->orderBy('order','asc');
        }
        $check_data =clone $data;
        $selected_ids = $check_data->pluck('id')->toArray();
        $data = $data->paginate(10);
        $schedule_data =clone $extra_data;
        $selected_sch_ids = $schedule_data->take(50)->pluck('id')->toArray();
        if(isset($request->start_date) || isset($request->end_date))
        {
            $extra_data = $extra_data->whereNotIn('id',$selected_ids);
        }
        $extra_data = $extra_data
        ->orderBy('order','asc')
        // ->whereHas('product',function($qu)
        // {
        //     $qu->orderBy('name','asc');
        // })
        
        // ->orderBy('product_id','asc')
        // ->join('products', 'products.id', '=', 'courses.product_id')
        // ->orderBy('products.name','asc')
        ->take(50)->get()->sortBy('product_id');
        
        $totalCount = $data->count();
        $dataTotal = $data->total();
        $dataTotal = $dataTotal ?? 0;
         $product_array=[];
        $product_category_array=[];
        if(!empty($products_ids_data))
        {
        foreach($products_ids_data as $pro_id){
            $product_array[]=["pro_id"=>$pro_id->id];
            $product_category_array[]=["pro_cat"=>$pro_id->category_id];
        }
       }
        
        
        $suggestions = [];
        
       if(isset($request->manufacturers) || isset($request->courses) || isset($request->locations) || isset($request->start_date) || isset($request->end_date))
        {
            $suggestions = self::getSuggestionCourses($dataTotal, $request,$selected_sch_ids,$product_array,$product_category_array);
        }
        $suggestion_paginate = 0;
        if($suggestions){
            $suggestion_paginate = 1;
        }
        //print_r(\DB::getQueryLog());die;
        if($request->ajax())
        {
            $html = view('frontend.products.courses', compact('data','suggestions','suggestion_paginate','extra_data'))->render();
            return response()->json([
                'status'=>true,
                'html'=>$html,
                'totalCount'=>$totalCount,
                'dataTotal'=>$dataTotal,
                'from_date'=>$from_date,
                'to_date'=>$to_date,
                'suggestion_paginate'=>$suggestion_paginate,
                'extra_data' => $extra_data
            ],200);
        }
        $manufacturers = Manufacturer::where('status', 1)->orderBy('name','asc')->get();

        $manufacturersData =[];
        foreach ($manufacturers as $key => $value) {
            $manufacturersData[] = $value->id;
        }
        $activeCategories = Course::where('status', 1)->whereIn('manufacturer_id', $manufacturersData)->distinct('category_id')->pluck('category_id')->toArray();
        
        $categories = Category::where('status', 1)->whereIn('id',$activeCategories)->orderBy('name','asc')->get();
        $locations = Location::where('status', 1)->orderBy('name','asc')->get();
        $courses = Product::where('status', 1)->orderBy('name','asc')->get();
        
        return view('frontend.products.index', compact('manufacturers','categories','courses','locations','data','extra_data','urlCategories','urlManufacturers','totalCount','categories_ids','category_data','products_data','manufacturer_data','dataTotal','products_id','location_data','locations_id','family','suggestions','suggestion_paginate','from_date','to_date'));
    }

    private function getSuggestionCourses($dataTotal, $request, $selected_sch_ids=[],$product_array=[],$product_category_array=[]){
        $suggestions = [];
        // if($dataTotal==0){
        
            //$suggestions = Course::where('status', 1)->whereNotIn('id',$selected_sch_ids);
          $suggestions = Course::where('status', 1)->whereNotIn('product_id',$product_array)->whereIn('category_id',$product_category_array);
            if($request->filled('val')){
                $order = $request->val;
                switch ($order) {
                    case 'priceasc':
                        $suggestions->orderBy('offer_price','asc');
                        break;
                    case 'pricedesc':
                        $suggestions->orderBy('offer_price','desc');
                        break;
                    default:
                        $suggestions->orderBy('order','asc');
                        break;
                }  
            }else{
                $suggestions->orderBy('order','asc');
            }

            $suggestions = $suggestions->paginate(10);
        // }
        return $suggestions;
    }

     /**
    * show all products based on ajax filter data
    */
    public function courseListingBasedOnFilter(Request $request){
        // dd($request->all());
        $inputs = $request->all();
//return response()->json(['status'=>true,'inputs'=>$inputs],200);

        $now = now()->setTimezone(config('constants.TIMEZONE'))->format('Y-m-d H:i:s');
        $data = Course::where('status', 1)
                    ->whereHas('manufacturer',function($qu)
                    {
                        $qu->where('status',1);
                    })->whereHas('category',function($qu)
                    {
                        $qu->where('status',1);
                    })->whereHas('product',function($qu)
                    {
                        $qu->where('status',1);
                    });

        if($request->filled('course_name')){
            $data->where('name', 'LIKE', '%' .trim(html_entity_decode($request->input('course_name'))). '%');
        }


        // Products based filters------------------------------
        $products_id = [];
        $products_data = [];
        if($request->filled('courses')){
            if(is_array($request->courses))
            {
                $products_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->courses);
            }
            $products_id = Product::whereIn('name', $products_data)->pluck('id')->toArray();
            $products_id = array_unique($products_id);
            //$products_banner = Product::where('name', $products_data)->first('banner');
            //$products_banner=$products_id->banner;
        }
        $url= URL::to('/');
       // $file_path=$url.'/uploads/categories/'.$products_banner->banner;
          $file_path=$url.'/uploads/categories/';

        if($products_data){
            $temp_product = [];
            foreach ($products_data as $key => $value) {
                $products_banner = Product::where('name', $value)->first();
                $count_Course=Course::where('product_id',$products_banner->id)->get()->count();
                $temp_product[] = ['count_Course'=>$count_Course,'product_banner'=>$file_path.$products_banner->banner,'desc'=>strip_tags($products_banner->description),'name'=>strtoupper($value),'slug'=>str_slug(strtoupper($value)),'category_id'=>$products_banner->category_id,'rel_name'=>$products_banner->name];
            }
            $products_data = $temp_product;
        }
        //$get_image=
        // special filter
        $products_ids_data = Product::whereIn('id', $products_id)->select('id','category_id')->get();

        $data = $data->where(function($q) use($products_id, $products_ids_data){
            foreach ($products_ids_data as $key => $value) {
                $q->orWhere(function($qq) use($value){
                    $qq->where('category_id', $value->category_id);
                    $qq->where('product_id', $value->id);
                });
            }
        });
        $extra_data = clone $data;
        $data->whereHas('locations', function($q) use($request,$now){
                $q->where("dubai_start_date_time",">=", $now);
            });

        // Sort by based filters------------------------------
        if($request->filled('val')){
            $order = $request->val;
            switch ($order) {
                case 'priceasc':
                    $data->orderBy('offer_price','asc');
                    // $extra_data->orderBy('offer_price','asc');
                    break;
                case 'pricedesc':
                    $data->orderBy('offer_price','desc');
                    // $extra_data->orderBy('offer_price','desc');
                    break;
                default:
                    $data->orderBy('order','asc');
                    // $extra_data->orderBy('order','asc');
                    break;
            }  
        }else{
            $data->orderBy('order','asc');
            $extra_data->orderBy('order','asc');
        }

        $check_data =clone $data;
        $selected_ids = $check_data->pluck('id')->toArray();
        $data = $data->paginate(10);
        $schedule_data =clone $extra_data;
        $selected_sch_ids = $schedule_data->take(50)->pluck('id')->toArray();
        if(isset($request->start_date) || isset($request->end_date))
        {
            $extra_data = $extra_data->whereNotIn('id',$selected_ids);
        }
        $extra_data = $extra_data
        ->orderBy('order','asc')
        // ->whereHas('product',function($qu)
        // {
        //     $qu->orderBy('name','asc');
        // })
        ->take(50)->get()->sortBy('product_id');
        $totalCount = $data->count();
        $dataTotal = $data->total();
        $dataTotal = $dataTotal ?? 0;

        $from_date =$inputs['start_date'];
        $to_date = $inputs['end_date'];
        $product_array=[];
        $product_category_array=[];
        if(!empty($products_ids_data))
        {
        foreach($products_ids_data as $pro_id){
            $product_array[]=["pro_id"=>$pro_id->id];
            $product_category_array[]=["pro_cat"=>$pro_id->category_id];
        }
       }

        $suggestions = [];
        if(isset($request->manufacturers) || isset($request->courses) || isset($request->locations) || isset($request->start_date) || isset($request->end_date))
        {
            $suggestions = self::getSuggestionCourses($dataTotal, $request,$selected_sch_ids,$product_array,$product_category_array);
        }
        $suggestion_paginate = 0;
        if($suggestions){
            $suggestion_paginate = 1;
        }

        //print_r(\DB::getQueryLog());die;
      //return response()->json(['status'=>true,'suggestions'=>$suggestions,'selected_sch_ids'=>$selected_sch_ids,'check_data'=>$check_data,'products_ids_data'=>$products_ids_data],200);

        if($request->ajax())
        {
            $html = view('frontend.products.courses', compact('extra_data','data','suggestions','suggestion_paginate','inputs','from_date','to_date'))->render();

            return response()->json(['status'=>true,'html'=>$html,'totalCount'=>$totalCount,'products_data'=>$products_data,'dataTotal'=>$dataTotal,'from_date'=>$from_date,'to_date'=>$to_date,'suggestion_paginate'=>$suggestion_paginate,'products_ids_data'=>$products_ids_data,'search_flag'=>$request->search_flag],200);
        }else{
            return redirect('404');
        }
    }

    public function productsFilterCourse(Request $request,$id,$cat_name){

        //echo $cat_name;die();
        $remove_tags=str_replace('-',' ',$cat_name);
        $cr=ucwords($remove_tags);
        $courses=explode(",",$cr);
        $d=['family'=>$id];
        $Pcategories=explode(" ",$id);
        $product_banner_image=Product::where('name',$cr)->where('category_id',$id)->first();

        //echo "<pre>";
        //print_r($d);die();
        $inputs=['courses'=>$courses,'Pcategories'=>$Pcategories,'end_date'=>null,'start_date'=>null,'val'=>null];
        
        $homeFooter = 1;
        //\DB::enableQueryLog();
        $now = now()->setTimezone(config('constants.TIMEZONE'))->format('Y-m-d H:i:s');
        $data = Course::where('status', 1)->where('product_id',$product_banner_image->id)->where('category_id',$id)->whereHas('manufacturer',function($qu)
                    {
                        $qu->where('status',1);
                    })->whereHas('category',function($qu)
                    {
                        $qu->where('status',1);
                    })->whereHas('product',function($qu)
                    {
                        $qu->where('status',1);
                    });
        // $data->whereHas('locations', function($q) use($request,$now){
        //         $q->where("dubai_start_date_time",">=", $now);
        //     });
                    
        if($request->filled('course_name')){
            $data = $data->where('name', 'LIKE', '%' .trim(html_entity_decode($request->input('course_name'))). '%');
        }
        

        // Manufactuers based filters------------------------------
        $urlManufacturers =[];
        $manufacturer_data= [];
        if($request->filled('manufacturers')){
            if(is_array($request->manufacturers)){
                $urlManufacturers = $request->manufacturers;

                $manufacturer_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->manufacturers);
            }

            $data = $data->whereHas('manufacturer', function($q) use($manufacturer_data){
                $q->whereIn('name', $manufacturer_data);
            });

            if($manufacturer_data){
                $temp_manufacturer = [];
                foreach ($manufacturer_data as $key => $value) {
                    $temp_manufacturer[] = strtoupper($value);
                }
                $manufacturer_data = $temp_manufacturer;
            }
        }
        


        // Category based filters------------------------------
        $urlCategories =[];
        $categories_ids = [];
        $category_data =[]; 
        if($request->filled('categories'))
        {
            if(is_array($request->categories))
            {
                $urlCategories = $request->categories;
                $category_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->categories);
            }
            $category_data = array_unique($category_data);
            $categories_ids = Category::whereIn('name', $category_data)->pluck('id')->toArray();

            $data = $data->whereIn('category_id', $categories_ids);

            if($category_data){
                $temp_cat = [];
                foreach ($category_data as $key => $value) {
                    $temp_cat[] = strtoupper($value);
                }
                $category_data = $temp_cat;
            }
        }

        $family = '';
       // $family = 17;


        if($d['family'])
        {
            $categories_ids[] = $d['family'];
            $family = $d['family'];

        }
        if($categories_ids){
            $data->whereIn('category_id', $categories_ids);
        }
     
     //echo "<pre>";print_r($data->count());die();

        
        // Products based filters------------------------------
        // check if request contain sub-categories.
        $products_id = [];
        $products_data = [];
        if($request->filled('courses')){
            if(is_array($request->courses))
            {
                $urlCourses = $request->courses;
                $products_data =array_map(function($val){
                    return trim(str_replace('-', ' ', $val));
                }, $request->courses);
                // dd($urlCourses,$products_data);
            }
            $products_id = Product::whereIn('name', $products_data)->pluck('id')->toArray();
            $cat_ids = Product::whereIn('name', $products_data)->pluck('category_id')->toArray();
            $getCategories = Category::whereIn('id',$cat_ids)->get();
            foreach($getCategories as $gc)
            {
                array_push($urlCategories,trim(str_replace(' ', '-', str_slug($gc->name))));
            }
            $products_id = array_unique($products_id);

            if($products_data){
                $temp_product = [];
                foreach ($products_data as $key => $value) {
                    $temp_product[] = ['name'=>strtoupper($value),'slug'=>str_slug(strtoupper($value))];
                }
                $products_data = $temp_product;
            }
        }
        

        // special filter
        if($products_id){
            $products_ids_data = Product::whereIn('id', $products_id)->select('id','category_id')->get();
            $data = $data->where(function($q) use($products_ids_data){
                foreach ($products_ids_data as $key => $value) {
                    $q->orWhere(function($qq) use($value){
                        $qq->where('category_id', $value->category_id);
                        $qq->where('product_id', $value->id);
                    });
                }
            });
        }else{
            if($categories_ids)
            {
                $data = $data->whereIn('category_id', $categories_ids);
            }
        }

        // Locations based filters------------------------------
        $location_data=[];
        $locations_id=[];
        if($request->filled('locations')){
            if(is_array($request->locations)){
                $locations_id = $request->locations;
            }
            if($locations_id){
                $location_data = Location::whereIn('id', $locations_id)->pluck('name')->toArray();
                $data->whereHas('locations', function($query) use($location_data){
                    $query->whereIn('country',$location_data);
                    $query->whereDate('dubai_start_date_time', '<', now()->setTimezone(config('constants.TIMEZONE'))->format('Y-m-d'));
                });
                
                 // dd($location_data,$data->get());
            }
        }
         $extra_data =clone $data;
        $data = $data->whereHas('locations', function($q) use($request,$now){
             $q->where("dubai_start_date_time",">=", $now);
        });

        // date based filters------------------------------
        $from_date = '';
        $to_date = '';

        if($request->filled('start_date') && $request->filled('end_date')){
            $from_date = $request->start_date;
            $to_date = $request->end_date;

            $data = $data->whereHas('locations', function($q) use($request,$now){
                $date1 = str_replace('/', '-', $request->start_date);
                $date1 = date('Y-m-d', strtotime($date1));
                $date2 = str_replace('/', '-', $request->end_date);
                $date2 = date('Y-m-d', strtotime($date2));
                
                $q->whereDate('dubai_start_date_time','>=' ,$date1)->whereDate('dubai_start_date_time','<=' ,$date2);
            });
        }
        elseif ($request->filled('start_date')) {
            $from_date = $request->start_date;

            $data = $data->whereHas('locations', function($q) use($request,$now){
                $date1 = str_replace('/', '-', $request->start_date);
                $date1 = date('Y-m-d', strtotime($date1));

                $q->whereDate('dubai_start_date_time','>=' ,$date1);
            });
        }
        elseif($request->filled('end_date')){
            $to_date = $request->end_date;
            
            $data = $data->whereHas('locations', function($q) use($request,$now){
                $date2 = str_replace('/', '-', $request->end_date);
                $date2 = date('Y-m-d', strtotime($date2));
                $to_date = $date2;

                $q->whereDate('date','<=' ,$date2);
            });
        }else{}

        if($request->filled('val')){
            $order = $request->val;
            switch ($order) {
                case 'priceasc':
                    $data->orderBy('offer_price','asc');
                    // $extra_data->orderBy('offer_price','asc');
                    break;
                case 'pricedesc':
                    $data->orderBy('offer_price','desc');
                    // $extra_data->orderBy('offer_price','desc');
                    break;
                default:
                    $data->orderBy('order','asc');
                    // $extra_data->orderBy('order','asc');
                    break;
            }  
        }else{
            $data->orderBy('order','asc');
            // $extra_data->orderBy('order','asc');
        }
        $check_data =clone $data;
        $selected_ids = $check_data->pluck('id')->toArray();
        $data = $data->paginate(10);
        $schedule_data =clone $extra_data;
        $selected_sch_ids = $schedule_data->take(50)->pluck('id')->toArray();
        if(isset($request->start_date) || isset($request->end_date))
        {
            $extra_data = $extra_data->whereNotIn('id',$selected_ids);
        }
        $extra_data = $extra_data
        // ->whereHas('product',function($qu)
        // {
        //     $qu->orderBy('name','asc');
        // })
        ->orderBy('order','asc')
        ->take(50)->get()->sortBy('product_id');
            
        $totalCount = $data->count();
        $dataTotal = $data->total();
        $dataTotal = $dataTotal ?? 0;
        $product_array=[];
        $product_category_array=[];
        if(!empty($products_ids_data))
        {
        foreach($products_ids_data as $pro_id){
            $product_array[]=["pro_id"=>$pro_id->id];
            $product_category_array[]=["pro_cat"=>$pro_id->category_id];
        }
        }
        $suggestions = [];
        if(isset($request->manufacturers) || isset($request->courses) || isset($request->locations) || isset($request->start_date) || isset($request->end_date))
        {
            $suggestions = self::getSuggestionCourses($dataTotal, $request,$selected_sch_ids,$product_array,$product_category_array);
        }
        $suggestion_paginate = 0;
        if($suggestions){
            $suggestion_paginate = 1;
        }
        //print_r(\DB::getQueryLog());die;
        // if($request->ajax())
        // {
        //     $html = view('frontend.products.courses', compact('data','suggestions','suggestion_paginate'))->render();
        //     return response()->json([
        //      'status'=>true,
        //      'html'=>$html,
        //      'totalCount'=>$totalCount,
        //      'dataTotal'=>$dataTotal,
        //      'from_date'=>$from_date,
        //      'to_date'=>$to_date,
        //      'suggestion_paginate'=>$suggestion_paginate,
        //     ],200);
        // }
        $manufacturers = Manufacturer::where('status', 1)->orderBy('name','asc')->get();

        $manufacturersData =[];
        foreach ($manufacturers as $key => $value) {
            $manufacturersData[] = $value->id;
        }
        $activeCategories = Course::where('status', 1)->whereIn('manufacturer_id', $manufacturersData)->distinct('category_id')->pluck('category_id')->toArray();
        
        $categories = Category::where('status', 1)->whereIn('id',$activeCategories)->orderBy('name','asc')->get();
        $locations = Location::where('status', 1)->orderBy('name','asc')->get();
        $courses = Product::where('status', 1)->orderBy('name','asc')->get();
       // dd($extra_data);
        $category_banner_image=$extra_data->groupBy('category_id')->first();
        $category_count_banner=$extra_data->groupBy('category_id')->count();
        //echo $category_count_banner;die();
       //$d= $category_banner_image->first();
         //echo "<pre>";
        //print_r($extra_data->count());die();
       // $count_Course='';
        /*if($category_count_banner==1)
        {
        $liste=[];
        foreach($category_banner_image as $category_banner_images){
            $dd=$category_banner_images->category_id ."<br>";
            array_push($liste,$dd);
        }
        $category_banner_id=array_unique($liste); 
       // $category_banner_image=Category::whereIn('id',$category_banner_id)->first();
        $product_banner_image=Product::where('name',$cr)->where('category_id',$id)->first();

       // $count_Course=Course::where('category_id',$category_banner_image->id)->get()->count();
        }*/
       $product_banner_image=Product::where('name',$cr)->where('category_id',$id)->first();
       $count_Course=Course::where('product_id',$product_banner_image->id)->where('category_id',$id)->get()->count();

     // echo "<pre>";print_r($extra_data);die();

        $search_flag='p';
        return view('frontend.products.single-course', compact('search_flag','manufacturers','categories','courses','locations','data','urlCategories','urlManufacturers','totalCount','categories_ids','category_data','products_data','manufacturer_data','dataTotal','products_id','location_data','locations_id','family','suggestions','suggestion_paginate','from_date','to_date','extra_data','category_count_banner','product_banner_image','count_Course'));


    }

    public function productsAppendCourse(Request $request){
            $data=$request->all();
                //return response()->json(['status'=>true,'data'=>$data['cat_id']],200);
               //die();
        //$count_Course=Course::where('category_id',$data['cat_id'])->get()->count();
        $count_Product=Product::where('category_id',$data['cat_id'])->get()->count();
        $take=$count_Product-5;
        $skip=5;
       // $count_Course_all=Course::where('category_id',$data['cat_id'])->skip($skip)->take($take)->get();
        $count_product_all=Product::where('category_id',$data['cat_id'])->skip($skip)->take($take)->get();
        return response()->json(['status'=>true,'data'=>$count_product_all],200);
    }
}


