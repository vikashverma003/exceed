<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\{
    Manufacturer, Category, ManufacturerCategory, Product, Course, CourseOutline, CourseTiming,Cart
};
use Illuminate\Validation\Rule;
use \Carbon\Carbon;

class ManufacturerController extends Controller
{
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'manufactuers_management_access';
    }

    /**
    * return dashboard view of admin side
    */
    public function index(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $active = 'manufacturers';
        $subactive = 'manufacturers';
        $inputs = $request->all();
        $users = Manufacturer::orderBy('id','DESC')->get();

        return view('admin.manufacturers.index',compact('active','users','subactive'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $active = 'manufacturers';
        $subactive = 'manufacturers';
        return view('admin.manufacturers.create',compact('active','subactive'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $request->validate(
            [
                //'name'=>'bail|required|unique:manufacturers|max:50|regex:/^[\pL\s]+$/u',
                'name'=>'bail|required|unique:manufacturers|max:50',
                'logo' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'banner' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'name.regex'=>'The name may only contain letters and spaces.',
                'logo.dimensions'=>'maximum dimenstions are 120*120.'
            ]
        );


        $name = null;
        $logo = $request->file('logo');
        $name = md5($logo->getClientOriginalName() . time()) . "." . $logo->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/manufacturers');
        $logo->move($destinationPath, $name);

        $bannername = null;
        $banner = $request->file('banner');
        $bannername = md5($banner->getClientOriginalName() . time()) . "." . $banner->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/manufacturers');
        $banner->move($destinationPath, $bannername);

        $res = Manufacturer::create([
            'name' => trim(str_replace(' & ', ' and ', request()->get('name'))),
            'logo' => $name,
            'banner' => $bannername,
            'status' => 1
        ]);
        if($res){
            return response()->json(['status'=>true,'message'=>'Manufacturer created successfully.','url'=>url('admin/manufacturers')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    public function show(){
        die('here in show method');
    }

    /**
    * change status of manufacturer
    */
    public function changeStatus(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $id = $request->id;
        $status = ($request->status==1) ? 1: 0;
        $data = Manufacturer::where('id',$id)->first();
        if($data){
            $data->status = $status;
            $data->save();
            return response()->json(['status'=>true,'message'=>'status updated successfully.'],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }
    }

    public function edit(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $data = Manufacturer::where('id', $id)->firstOrFail();
        $active = 'manufacturers';
        $subactive = 'manufacturers';
        return view('admin.manufacturers.edit',compact('active','subactive','data'));
    }

    public function update(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $request->validate(
            [
                'name'=>['bail','required','max:50', Rule::unique('manufacturers')->ignore($id, 'id')],
                'logo' =>'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'banner' =>'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'name.regex'=>'The name may only contain letters and spaces.',
                'logo.dimensions'=>'maximum dimenstions are 120*120.'
            ]
        );
        $data = Manufacturer::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }
        $data->name = trim(str_replace(' & ', ' and ', request()->get('name')));

        if($request->file('logo')){
            $name = null;
            $logo = $request->file('logo');
            $name = md5($logo->getClientOriginalName() . time()) . "." . $logo->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/manufacturers');
            $logo->move($destinationPath, $name);

            $old_path = public_path('uploads/manufacturers/'.$data->logo);
            
            if(\File::exists($old_path)){
                \File::delete($old_path);
            }

            $data->logo = $name;
        }

        if($request->file('banner')){
            $bannername = null;
            $banner = $request->file('banner');
            $bannername = md5($banner->getClientOriginalName() . time()) . "." . $banner->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/manufacturers');
            $banner->move($destinationPath, $bannername);
            $old_path = public_path('uploads/manufacturers/'.$data->banner);
            if(\File::exists($old_path)){
                \File::delete($old_path);
            }
            $data->banner = $bannername;
        }
        
        $res = $data->save();
        if($res){
            return response()->json(['status'=>true,'message'=>'Manufacturer updated successfully.','url'=>url('admin/manufacturers')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    public function assignCategory(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $data = Manufacturer::where('id', $id)->firstOrFail();
        $active = 'manufacturers';
        $subactive = 'manufacturers';
        $categories = Category::where('status', 1)->get();
        $assign = ManufacturerCategory::where('manufacturer_id', $id)->pluck('category_id')->toArray();
        
        return view('admin.manufacturers.categories.index',compact('active','subactive','data','categories','id','assign'));
    }

    public function saveAssignCategories(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $request->validate(
            [
                'manufacturer_id'=>'bail|required|numeric',
                'categories'=>'nullable'
            ]
        );
        $url = url('admin/manufacturers');

        $manufacturer_id = $request->input('manufacturer_id');
        $categories = $request->categories;
        if(!$categories){
            ManufacturerCategory::where('manufacturer_id', $manufacturer_id)->delete();
            return response()->json(['status'=>true,'message'=>'Records updated successfully.','url'=>$url], 200);
        }

        $data = [];
        foreach ($categories as $key => $value) {
            $data[] = [
                'manufacturer_id'=>$manufacturer_id,
                'category_id'=> $value,
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ];
        }
       
        ManufacturerCategory::where('manufacturer_id', $manufacturer_id)->delete();

        $res = ManufacturerCategory::insert($data);
        if($res){
            return response()->json(['status'=>true,'message'=>'Records updated successfully.','url'=>$url], 200);
        }else{
            return response()->json(['status'=>false,'message'=>"Something went wrong. Please try again later."],200);
        }
    }


    /**
    * return all categories for selected manufacturer
    **/
    public function getSelectedManufacturerCategory(Request $request){
        $val = $request->input('val');
        $data = ManufacturerCategory::where('manufacturer_id', $val)->pluck('category_id')->toArray();
        
        $res = Category::whereIn('id', $data)->select('id','name')->get();

        return response()->json(['status'=>true,'message'=>'Records found successfully.','data'=>$res], 200);
    }

    /**
    * return all products for selected manufacturer
    **/
    public function getSelectedManufacturerProducts(Request $request){
        $manufacturer_id = $request->input('manufacturer_id');
        $category_id = $request->input('category_id');

        $data = Product::where('manufacturer_id', $manufacturer_id)->where('category_id', $category_id)->select('id','name')->get();

        return response()->json(['status'=>true,'message'=>'Records found successfully.','data'=>$data], 200);
    }

    public function destroy(Request $request)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $course_ids = Course::where('manufacturer_id',$request->id)->pluck('id')->toArray();
        $timing_delete = CourseTiming::whereIn('course_id',$course_ids)->delete();
        $outline_delete = CourseOutline::whereIn('course_id',$course_ids)->delete();
        $cart_delete = Cart::whereIn('course_id',$course_ids)->delete();
        $product_delete = Product::where('manufacturer_id', $request->id)->delete();
        $category_delete = ManufacturerCategory::where('manufacturer_id', $request->id)->delete();
        $course_delete = Course::where('manufacturer_id',$request->id)->delete();
        $delete = Manufacturer::where('id',$request->id)->delete();
        if($delete){
            return response()->json(['status'=>true, 'message'=>'Manufacturer deleted successfully.'],200);
        }
        return response()->json(['status'=>false, 'message'=>'Manufacturer not deleted, Please try again later.'],200);
    }
}
