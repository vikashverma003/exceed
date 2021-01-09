<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth, DateTime, DateTimeZone,Session;
use App\Models\{
    Course, Manufacturer, Category, Product, CourseOutline, CourseTiming, Location, ManufacturerCategory, TrainingType, Timezone
};
use Illuminate\Validation\Rule;
use \Carbon\Carbon;

class CourseController extends Controller
{
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'courses_management_access';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'courses';
        $subactive = 'courses';
        $data = Course::orderBy('id','DESC')->with(['manufacturer','category','product']);

        $inputs = $request->all();
        // dd($inputs);
        if(isset($inputs['reset']))
        {
            Session::forget('course_filter_data');
        }
        if(empty($inputs))
        {
            $inputs = Session::get('course_filter_data',[]);
        }

        Session::put('course_filter_data',$inputs);
        $data = self::filter($data, $inputs, $request);
        $data = $data->paginate(10);
        $manufacturers = Manufacturer::where('status',1 )->get();
        if(isset($inputs['manufacturer_name']))
        {
            $manufacturer_categories = ManufacturerCategory::where('manufacturer_id',$inputs['manufacturer_name'])->pluck('category_id')->toArray();
            $categories = Category::where('status',1 )->whereIn('id',$manufacturer_categories)->get();
        }
        else
        {
            $categories = Category::where('status',1 )->get();
        }
        $products = Product::where('status',1 )->get();
        // dd($categories);
        if($request->ajax()){
            return view('admin.courses.listing',compact('active','data','subactive','manufacturers','categories','products','inputs'));
        }

        return view('admin.courses.index',compact('active','data','subactive','manufacturers','categories','products','inputs'));
    }

    private function filter($data, $inputs, $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        if(isset($inputs['name'])){
            $data->where('name', 'like', '%' . $inputs['name'] . '%');
        }
        if(isset($inputs['category_name'])){
            $data->where('category_id', $inputs['category_name']);
        }
        if(isset($inputs['manufacturer_name'])){
            $data->where('manufacturer_id', $inputs['manufacturer_name']);
        }
        if(isset($inputs['product_name'])){
            $data->where('product_id', $inputs['product_name']);
        }

        if(isset($inputs['status'])){
            $data->where('status', (int)$inputs['status']);
        }

        if($request->filled('from_date') && $request->filled('to_date')){
            $date1 = str_replace('/', '-', $request->from_date);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->to_date);
            $date2 = date('Y-m-d', strtotime($date2));
            $data->whereHas('locations', function($q) use($date1,$date2){
                $q->whereDate('date','>=' ,$date1)->whereDate('date','<=' ,$date2);
            });
        }
        elseif ($request->filled('from_date')) {
            $data->whereHas('locations', function($q) use($request){
                $date1 = str_replace('/', '-', $request->from_date);
                $date1 = date('Y-m-d', strtotime($date1));
                $q->whereDate('date','>=' ,date('Y-m-d'))->whereDate('date','>=' ,$date1);
            });
        }
        elseif($request->filled('to_date')){            
            $data->whereHas('locations', function($q) use($request){
                $date2 = str_replace('/', '-', $request->to_date);
                $date2 = date('Y-m-d', strtotime($date2));
                $q->whereDate('date','>=' ,date('Y-m-d'))->whereDate('date','>=' ,$date1);
            });
        }else{}

        if($request->filled('start') && $request->filled('end'))
        {
            $start = str_replace('/', '-', $request->start);
            $start = date('Y-m-d', strtotime($start));
            $end = str_replace('/', '-', $request->end);
            $end = date('Y-m-d', strtotime($end));
            
            $data->whereDate('created_at','>=' ,$start)->whereDate('created_at','<=' ,$end);
        }

        return $data;
    }

    public function export(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        try{
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=file.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            $data = Course::orderBy('id','DESC')->with(['manufacturer','category','product']);
            $inputs = $request->all();
            $data = self::filter($data, $inputs, $request);
            $data = $data->get();

            if(count($data)<1){
                return response()->json(['status'=>false,'message'=>'No Records Found to export.'], 400);
            }
            $columns = array('Course Name', 'Manufacturer', 'Category', 'Product Family', 'Created');

            $callback = function() use ($data, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($data as $row) {
                    fputcsv($file, array($row->name, $row->manufacturer->name, $row->category->name, $row->product->name,date('d/m/Y', strtotime($row->created_at))));
                }
                fclose($file);
            };
            return response()->streamDownload($callback, 'prefix-' . date('d-m-Y-H:i:s').'.csv', $headers);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 400);
        }
    }

    public function schedule(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $course_id = $request->input('course_id');
        $timings = CourseTiming::where('course_id', $course_id)->whereDate('date', '>=', date('Y-m-d'))->get();

        $data = [];
        foreach ($timings as $key => $value) {
            $data[] =
                    [
                        'start_date'=>\Carbon\Carbon::parse($value->start_date)->format('d/m/Y'),
                        'end_date'=>\Carbon\Carbon::parse($value->date)->format('d/m/Y'),
                        'start_time'=>date("h:i A", strtotime($value->start_time)),
                        'end_time'=>date("h:i A", strtotime($value->end_time)),
                        'country'=>$value->country,
                        'training_type'=>$value->training_type,
                        'city'=>$value->city,
                        'location'=>$value->location,
                    ];
        }
        return response()->json(['status'=>true,'message'=>'Timings found successfully.', 'data'=>$data], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'courses';
        $subactive = 'courses';
        $manufacturers = Manufacturer::where('status', 1)->select('id','name')->get();
        $order = Course::orderBy('id','desc')->value('id');

        return view('admin.courses.create', compact('active','subactive','manufacturers','order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'courses';
        $subactive = 'courses';
        $course = Course::where('id', $id)->firstOrFail();

        $manufacturer = Manufacturer::where('id', $course->manufacturer_id)->select('id','name')->first();
        $category = Category::where('id', $course->category_id)->select('id','name')->first();
        $product = Product::where('id', $course->product_id)->select('id','name')->first();
        $manufacturers = Manufacturer::where('status', 1)->select('id','name')->get();

        $manu_category = ManufacturerCategory::where('manufacturer_id',  $course->manufacturer_id)->pluck('category_id')->toArray();
        $categories = Category::whereIn('id', $manu_category)->select('id','name')->get();
        $productFamilies = Product::where('manufacturer_id', $course->manufacturer_id)->where('category_id', $category->id)->select('id','name')->get();
        return view('admin.courses.edit', compact('active','subactive','manufacturer','category','course','product','manufacturers','categories','productFamilies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'name'=>['bail','required','string','max:200'],

            'short_note'=>'bail|max:150',
            'meta_keywords'=>'bail|max:250',
            'meta_description'=>'bail|max:500',
            'description'=>'bail',
            'price'=>'bail|min:0|max:2147483647',
            'offer_price'=>'bail|min:0|lte:price',
            'duration_type'=>'bail',
            'duration'=>'bail|min:0|max:2147483647',

            'product'=>'bail|required|numeric',
            'category'=>'bail|required|numeric',
            'manufacturer'=>'bail|required|numeric',
            'image' =>'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' =>'bail|required|dimensions:min_width=1600,min_height=250|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'inner_image' =>'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sample_video' =>'bail|nullable',
            'order' =>'bail|required|integer',
        ]);

        $product = Product::where('id', $request->product)->first();
        if(!$product){
            return response()->json(['status'=>false, 'message'=>'Product not found. Please try again later.'],200);
        }

        // image
        $name = null;
        $image = $request->file('image');
        $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/courses');
        $image->move($destinationPath, $name);

        $bannername = null;
        $banner = $request->file('banner');
        $bannername = md5($banner->getClientOriginalName() . time()) . "." . $banner->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/courses');
        $banner->move($destinationPath, $bannername);

        $innerimagename = null;
        $innerimage = $request->file('inner_image');
        $innerimagename = md5($innerimage->getClientOriginalName() . time()) . "." . $innerimage->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/courses');
        $innerimage->move($destinationPath, $innerimagename);


        // video sample
        $video_name = null;
        // $sample_video = $request->file('sample_video');
        // $video_name = md5($sample_video->getClientOriginalName() . time()) . "." . $sample_video->getClientOriginalExtension();
        // $destinationPath = public_path('/uploads/courses');
        // $sample_video->move($destinationPath, $video_name);

        $obj = new Course;
        $obj->name = request()->get('name');
        $obj->course_name_slug = str_replace(' ', '-', request()->get('name'));
        $obj->description = $request->description;

        $obj->price = $request->price??null;
        $obj->offer_price = $request->offer_price??null;

        $obj->category_id = $request->category;
        $obj->manufacturer_id = $request->manufacturer;
        $obj->product_id = $product->id;

        $obj->duration = $request->duration??null;
        $obj->duration_type = $request->duration_type;
        $obj->meta_keywords = $request->meta_keywords;
        $obj->short_note = $request->short_note;
        $obj->meta_description = $request->meta_description;
        $obj->image = $name;
        $obj->banner = $bannername;
        $obj->inner_image = $innerimagename;
        $obj->sample_video = $request->sample_video;
        $obj->order = $request->order;
        $obj->status = 1;
        $obj->short_code = md5(uniqid());

        if($obj->save()){
            return response()->json(['status'=>true, 'message'=>'Course created successfully.','url'=>url('admin/courses')],200);
        }else{
            return response()->json(['status'=>false, 'message'=>'Something went wrong. Please try again later.'],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'product'=>'bail|required|numeric',
            'category'=>'bail|required|numeric',
            'manufacturer'=>'bail|required|numeric',
            'name'=>['bail','required','max:200'],

            'description'=>'bail',
            'short_note'=>'bail|max:50',
            'price'=>'bail|min:0|max:2147483647',
            'offer_price'=>'bail|min:0|lte:price',
            'meta_keywords'=>'bail|max:250',
            'meta_description'=>'bail|max:500',
            'duration'=>'bail|min:0|max:2147483647',
            'duration_type'=>'bail',

            'id'=>'bail|required|numeric',
            'image' =>'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' =>'bail|nullable|dimensions:min_width=1600,min_height=250|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'inner_image' =>'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sample_video' =>'nullable',
            'order' =>'bail|required|integer',
        ]);

        $course = Course::where('id', $request->id)->first();
        if(!$course){
            return response()->json(['status'=>false, 'message'=>'Course not found. Please try again later.'],200);
        }

        $course->course_name_slug = str_replace(' ', '-', request()->get('name'));
        $course->name = request()->get('name');
        $course->description = $request->description;
        $course->price = $request->price;
        $course->offer_price = $request->offer_price;
        $course->duration = $request->duration;
        $course->duration_type = $request->duration_type;
        $course->meta_keywords = $request->meta_keywords;
        $course->meta_description = $request->meta_description;
        $course->short_note = $request->short_note;

        $course->category_id = $request->category;
        $course->manufacturer_id = $request->manufacturer;
        $course->product_id = $request->product;
        $course->order = $request->order;

        if($request->has('image')){
            $name = null;
            $image = $request->file('image');
            $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/courses');
            $image->move($destinationPath, $name);
            
            $course->image = $name;
        }

        if($request->has('banner')){
            $bannername = null;
            $banner = $request->file('banner');
            $bannername = md5($banner->getClientOriginalName() . time()) . "." . $banner->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/courses');
            $banner->move($destinationPath, $bannername);
            $course->banner = $bannername;
        }

        if($request->has('inner_image')){
            $innerimagename = null;
            $innerimage = $request->file('inner_image');
            $innerimagename = md5($innerimage->getClientOriginalName() . time()) . "." . $innerimage->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/courses');
            $innerimage->move($destinationPath, $innerimagename);
            
            $course->inner_image = $innerimagename;
        }

        $course->sample_video = $request->sample_video;

        if($course->save()){
            return response()->json(['status'=>true, 'message'=>'Course updated successfully.','url'=>url('admin/courses')],200);
        }else{
            return response()->json(['status'=>false, 'message'=>'Something went wrong. Please try again later.'],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);

        if($course->delete()){
            return response()->json(['status'=>true, 'message'=>'Course deleted successfully.'],200);
        }
         return response()->json(['status'=>false, 'message'=>'Course not deleted, Please try again later.'],200);
    }


    /**
    * change status of course
    */
    public function status(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $id = $request->id;
        $status = ($request->status==1) ? 1: 0;
        $data = Course::where('id',$id)->first();
        if($data){
            $data->status = $status;
            $data->save();
            return response()->json(['status'=>true,'message'=>'status updated successfully.'],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }
    }


    /**
    * get all outlines of particular course
    **/
    public function outlines(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'courses';
        $subactive = 'courses';
        $course = Course::where('id', $id)->firstOrFail();
        $data = CourseOutline::where('course_id', $id)->get();

        return view('admin.courses.outlines.index', compact('active','subactive','course','data'));
    }

    public function createOutline(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'courses';
        $subactive = 'courses';
        $course = Course::where('id', $id)->firstOrFail();

        return view('admin.courses.outlines.add', compact('active','subactive','course'));
    }

    public function storeOutline(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'title'=>'bail|required|string|max:200',
            // 'day'=>'bail|required|numeric',
            'description'=>'bail|required',
            'course_id'=>'bail|required|numeric',
        ]);

        $course = Course::where('id', $request->course_id)->first();
        if(!$course){
            return response()->json(['status'=>false, 'message'=>'Course not found. Please try again later.'],200);
        }

        $obj = new CourseOutline;
        $obj->title = $request->title;
        $obj->day = 1;
        $obj->course_id = $request->course_id;
        $obj->description = $request->description;
        $obj->status = 1;

        if($obj->save()){
            return response()->json(['status'=>true, 'message'=>'Course Outline created successfully.','url'=>url('admin/outlines/'.$course->id)],200);
        }else{
            return response()->json(['status'=>false, 'message'=>'Something went wrong. Please try again later.'],200);
        }
    }

    public function editOutline(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'courses';
        $subactive = 'courses';
        $data = CourseOutline::where('id', $id)->firstOrFail();
        $course = Course::where('id', $data->course_id)->first();

        return view('admin.courses.outlines.edit', compact('active','subactive','data','course'));
    }

    public function updateOutline(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'title'=>'bail|required|string|max:200',
            // 'day'=>'bail|required|numeric',
            'description'=>'bail|required',
            'id'=>'bail|required|numeric',
        ]);

        $outline = CourseOutline::where('id', $request->id)->first();
        if(!$outline){
            return response()->json(['status'=>false, 'message'=>'Course Outline not found. Please try again later.'],200);
        }

        $outline->title = $request->title;
        // $outline->day = $request->day;
        $outline->description = $request->description;

        if($outline->save()){
            return response()->json(['status'=>true, 'message'=>'Course Outline updated successfully.','url'=>url('admin/outlines/'.$outline->course_id)],200);
        }else{
            return response()->json(['status'=>false, 'message'=>'Something went wrong. Please try again later.'],200);
        }
    }


    public function updateOutlineStatus(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $id = $request->id;
        $status = ($request->status==1) ? 1: 0;
        $data = CourseOutline::where('id',$id)->first();
        if($data){
            $data->status = $status;
            $data->save();
            return response()->json(['status'=>true,'message'=>'status updated successfully.'],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }
    }

    public function deleteOutline(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $id = $request->id;
        $status = ($request->status==1) ? 1: 0;
        $data = CourseOutline::where('id',$id)->first();
        if($data->delete()){
            return response()->json(['status'=>true,'message'=>'status deleted successfully.'],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }
    }


    public function getTimelist(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'courses';
        $subactive = 'courses';
        $course = Course::where('id', $id)->firstOrFail();
        $data = CourseTiming::where('course_id', $id)->get();
        $locations = Location::where('status', 1)->get();
        $training_types = TrainingType::where('status', 1)->get();
        $timezones = Timezone::orderBy('timezone','asc')->get();
        return view('admin.courses.timings.index', compact('active','subactive','course','data','locations','training_types','timezones'));
    }

    public function saveTimelist(Request $request){

        abort_unless(helperCheckPermission($this->permissionName), 403);
        $date = str_replace('/', '-', $request->expiry_date);
        $request['expiry_date'] = date('Y-m-d', strtotime($date));

        $start_date = str_replace('/', '-', $request->start_date);
        $request['start_date'] = date('Y-m-d', strtotime($start_date));

        $dubai_start_date_time = $this->converToTz($request['start_date'].''.$request['start_time'],config('constants.TIMEZONE'),$request['timezone']);

        $request->validate([
            'country'=>'bail|required|string|max:100',
            'location'=>'bail|required|string|max:100',
            'training_type'=>'bail|required|string|max:100',
            'city'=>'bail|required|string|max:100',
            'start_date'=>'bail|required',
            'expiry_date'=>'bail|required|after_or_equal:start_date',
            'course_id'=>'bail|required|numeric',
            'start_time'=>'bail|required|date_format:H:i:s',
            'end_time'=>'bail|required|date_format:H:i:s|after:start_time',
            'timezone'=>'bail|required|string|max:100',
        ]);

        $course = Course::where('id', $request->course_id)->first();
        if(!$course){
            return response()->json(['status'=>false, 'message'=>'Course not found. Please try again later.'],200);
        }

        $obj = new CourseTiming;
        $obj->course_id = $request->course_id;
        $obj->location = $request->location;
        $obj->country = $request->country;
        $obj->training_type = $request->training_type;
        $obj->city = $request->city;
        $obj->timezone = $request->timezone;
        $obj->dubai_start_date_time    = $dubai_start_date_time;

        $obj->start_date = $request->start_date;
        $obj->date = $request->expiry_date;

        $obj->start_time = $request->start_time;
        $obj->end_time = $request->end_time;

        if($obj->save()){
            return response()->json(['status'=>true, 'message'=>'Course Timing updated successfully.'],200);
        }else{
            return response()->json(['status'=>false, 'message'=>'Something went wrong. Please try again later.'],200);
        }
    }

    public function updateTimelist(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
         $date = str_replace('/', '-', $request->expiry_date);
        $request['expiry_date'] = date('Y-m-d', strtotime($date));

        $start_date = str_replace('/', '-', $request->start_date);
        $request['start_date'] = date('Y-m-d', strtotime($start_date));

        $dubai_start_date_time = $this->converToTz($request['start_date'].''.$request['start_time'],config('constants.TIMEZONE'),$request['timezone']);

        $request->validate([
            'location'=>'bail|required|string|max:100',
            'city'=>'bail|required|string|max:100',
            'country'=>'bail|required|string|max:100',
            'training_type'=>'bail|required|string|max:100',
            'start_date'=>'bail|required|date',
            'expiry_date'=>'bail|required|date|after_or_equal:start_date',
            'id'=>'bail|required|numeric',
            'start_time'=>'bail|required|date_format:H:i:s',
            'end_time'=>'bail|required|date_format:H:i:s|after:start_time',
            'timezone'=>'bail|required|string|max:100',
        ]);

        $timeing = CourseTiming::where('id', $request->id)->first();
        if(!$timeing){
            return response()->json(['status'=>false, 'message'=>'Timing not found. Please try again later.'],200);
        }

        $timeing->country = $request->country;
        $timeing->location = $request->location;
        $timeing->city = $request->city;
        $timeing->training_type = $request->training_type;
        $timeing->timezone = $request->timezone;
        $timeing->dubai_start_date_time   = $dubai_start_date_time;

        $timeing->start_date = $request->start_date;
        $timeing->date = $request->expiry_date;

        $timeing->start_time = $request->start_time;
        $timeing->end_time = $request->end_time;

        if($timeing->save()){
            return response()->json(['status'=>true, 'message'=>'Course Timing updated successfully.'],200);
        }else{
            return response()->json(['status'=>false, 'message'=>'Something went wrong. Please try again later.'],200);
        }
    }
    function converToTz($time="",$toTz='',$fromTz='')
    {   
        // timezone by php friendly values
        $date = new DateTime($time, new DateTimeZone($fromTz));
        $date->setTimezone(new DateTimeZone($toTz));
        $time= $date->format('Y-m-d H:i:s');
        return $time;
    }
}
