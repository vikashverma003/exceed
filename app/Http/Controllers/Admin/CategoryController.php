<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\{
    Category, SubCategory, Course, CourseTiming, CourseOutline, Cart, Product, ManufacturerCategory
};
use Illuminate\Validation\Rule;
use DB;

class CategoryController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'categories_management_access';
    }

    /**
    * return dashboard view of admin side
    */
    public function index(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'categories';
        $subactive = 'categories';
        $inputs = $request->all();
        $data = Category::orderBy('id','DESC')->get();

        return view('admin.categories.index',compact('active','data','subactive'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'categories';
        $subactive = 'categories';
        return view('admin.categories.create.index',compact('active','subactive'));
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
                'name'=>'bail|required|unique:categories|max:100',
                'desc'=>'bail|required|min:10',
                'color'=>'bail|required|max:500',
                'logo' =>'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'icon' =>'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'meta_tags'=>'bail|required|max:250',
                'meta_keywords'=>'bail|required|max:250',
                'meta_description'=>'bail|required|max:500',
                'banner' =>'bail|required|dimensions:min_width=1600,min_height=250|image|mimes:jpeg,png,jpg,gif,svg|max:4096',

            ],
            [
                'icon.dimensions'=>'The dimensions should be width max 25 and height max 25.',
                'logo.dimensions'=>'The dimensions should be width max 120 and height max 120.'
            ]
        );
        try{
            DB::beginTransaction();
            $logoname = null;
            $logo = $request->file('logo');
            $logoname = md5($logo->getClientOriginalName() . time()) . "." . $logo->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/categories');
            $logo->move($destinationPath, $logoname);

            $iconName = null;
            $icon = $request->file('icon');
            $iconName = md5($icon->getClientOriginalName() . time()) . "." . $icon->getClientOriginalExtension();
            $destinationIconPath = public_path('/uploads/categories');
            $icon->move($destinationIconPath, $iconName);
            $bannername = null;
            $banner = $request->file('banner');
            $bannername = md5($banner->getClientOriginalName() . time()) . "." . $banner->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/categories');
            $banner->move($destinationPath, $bannername);

            $res = Category::create([
                'name' => str_replace(' & ', ' and ', request()->get('name')),
                'desc' => request()->get('desc'),
                'color' => request()->get('color'),
                'meta_keywords' => request()->get('meta_keywords'),
                'meta_description' => request()->get('meta_description'),
                'meta_tags' => request()->get('meta_tags'),
                'logo' => $logoname,
                'icon' => $iconName,
                'banner' =>$bannername,
                'status' => 1
            ]);
            if($res){
                DB::commit();
                return response()->json(['status'=>true,'message'=>'Category created successfully.','url'=>url('admin/categories')],200);
            }else{
                DB::rollback();
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
            }
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=>$e->getMessage()],400);
        }
    }

    public function show(){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        return redirect('admin/dashboard');
    }

    /**
    * change status of Category
    */
    public function changeStatus(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $id = $request->id;
        $status = ($request->status==1) ? 1: 0;
        $data = Category::where('id',$id)->first();
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
        $active = 'categories';
        $subactive = 'categories';
        $data = Category::where('id', $id)->firstOrFail();

        return view('admin.categories.edit.index',compact('active','subactive','data'));
    }

    // update method of category
    public function update(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate(
            [
                'name'=>['bail','required','max:100', Rule::unique('categories')->ignore($id, 'id')],
                'desc'=>'bail|required|min:10',
                'color'=>'bail|required|max:500',
                'meta_tags'=>'bail|required|max:250',
                'meta_keywords'=>'bail|required|max:250',
                'meta_description'=>'bail|required|max:500',
                'logo' =>'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'icon' =>'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'banner' =>'bail|nullable|dimensions:min_width=1600,min_height=250|image|mimes:jpeg,png,jpg,gif,svg|max:4096',

            ],
            [
                'icon.dimensions'=>'The dimensions should be width max 25 and height max 25.',
                'logo.dimensions'=>'The dimensions should be width max 120 and height max 120.'
            ]
        );
        try{
            $data = Category::where('id', $id)->first();
            if(!$data){
                return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
            }
            DB::beginTransaction();
            $data->name = str_replace(' & ', ' and ', request()->get('name'));
            $data->desc = $request->desc;
            $data->color = $request->color;
            $data->meta_keywords = $request->meta_keywords;
            $data->meta_description = $request->meta_description;
            $data->meta_tags = $request->meta_tags;
            if($request->file('logo')){
                $name = null;
                $logo = $request->file('logo');
                $name = md5($logo->getClientOriginalName() . time()) . "." . $logo->getClientOriginalExtension();
                $destinationLogoPath = public_path('/uploads/categories');
                $logo->move($destinationLogoPath, $name);

                $old_path = public_path('uploads/categories/'.$data->logo);
                
                if(\File::exists($old_path)){
                    \File::delete($old_path);
                }

                $data->logo = $name;
            }

            if($request->file('icon')){
                $iconName = null;
                $icon = $request->file('icon');
                $iconName = md5($icon->getClientOriginalName() . time()) . "." . $icon->getClientOriginalExtension();
                $destinationIconPath = public_path('/uploads/categories');
                $icon->move($destinationIconPath, $iconName);

                $old_path_icon = public_path('uploads/categories/'.$data->icon);
                if(\File::exists($old_path_icon)){
                    \File::delete($old_path_icon);
                }
                $data->icon = $iconName;
            }

           if($request->file('banner')){
                $bannerName = null;
                $banner = $request->file('banner');
                $bannerName = md5($banner->getClientOriginalName() . time()) . "." . $banner->getClientOriginalExtension();
                $destinationIconPath = public_path('/uploads/categories');
                $banner->move($destinationIconPath, $bannerName);

                $old_path_banner = public_path('uploads/categories/'.$data->banner);
                if(\File::exists($old_path_banner)){
                    \File::delete($old_path_banner);
                }
                $data->banner=$bannerName;
            }


            $res = $data->save();
            if($res){
                DB::commit();
                return response()->json(['status'=>true,'message'=>'Category updated successfully.','url'=>url('admin/categories')],200);
            }else{
                DB::rollback();
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
            }
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=>$e->getMessage()],400);
        }
    }

    // list all sub categories of particular category
    public function listSubCategories(Request $request, $category_id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $category = Category::where('id', $category_id)->firstOrFail();
        $active = 'categories';
        $subactive = 'categories';        
        $data = SubCategory::where('category_id', $category_id)->get();
        return view('admin.categories.subcategories.index', compact('category_id','data', 'active','subactive'));
    }

    // add sub category to respective category
    public function addSubCategory(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate(
            [
                'name'=>['bail','required','max:100', Rule::unique('sub_categories')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                })],
                'category_id'=>'bail|required',
            ]
        );
        $category_id = $request->category_id;

        $res = SubCategory::create([
            'name' => str_replace(' & ', ' and ', request()->get('name')),
            'category_id' => request()->get('category_id'),
            'status' => 1
        ]);
        if($res){
            return response()->json(['status'=>true, 'message'=>'Category created successfully.', 'url'=>url('admin/subcategories/'.$category_id)],200);
        }else{
            return response()->json(['status'=>false, 'message'=>'Something went wrong. Please try again'],200);
        }
    }

    public function subCategoryStatus(Request $request){
        
    }
    public function destroy(Request $request)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $course_ids = Course::where('category_id',$request->id)->pluck('id')->toArray();
        $timing_delete = CourseTiming::whereIn('course_id',$course_ids)->delete();
        $outline_delete = CourseOutline::whereIn('course_id',$course_ids)->delete();
        $cart_delete = Cart::whereIn('course_id',$course_ids)->delete();
        $product_delete = Product::where('category_id', $request->id)->delete();
        $category_delete = ManufacturerCategory::where('category_id', $request->id)->delete();
        $course_delete = Course::where('category_id',$request->id)->delete();
        $delete = Category::where('id',$request->id)->delete();
        if($delete){
            return response()->json(['status'=>true, 'message'=>'Category deleted successfully.'],200);
        }
        return response()->json(['status'=>false, 'message'=>'Category not deleted, Please try again later.'],200);
    }
}
