<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\{
    Manufacturer, Category, ManufacturerCategory, Product
};
use Illuminate\Validation\Rule;
use \Carbon\Carbon;

class ProductController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'products_management_access';
    }

    /**
    * return all products
    */
    public function index(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'products';
        $subactive = 'products';
        $data = Product::with(['manufacturer'=>function($q){
                        $q->select('id','name');
                    },'categories'=>function($q){
                        $q->select('id','name');
                    }]);

        $inputs = $request->all();
        
        if(isset($inputs['name'])){
            $data->where('name', 'like', '%' . $inputs['name'] . '%');
        }
        if(isset($inputs['category_name'])){
            $data->where('category_id', $inputs['category_name']);
        }
        if(isset($inputs['manufacturer_name'])){
            $data->where('manufacturer_id', $inputs['manufacturer_name']);
        }

        if(isset($inputs['status'])){
            $data->where('status', (int)$inputs['status']);
        }

        $data = $data->orderBy('id','DESC')->paginate(10);

        $manufacturers = Manufacturer::where('status',1 )->get();
        $categories = Category::where('status',1 )->get();

        if($request->ajax()){
            return view('admin.products.listing',compact('active','data','subactive','manufacturers','categories'));
        }
        
        return view('admin.products.index',compact('active','subactive','data','manufacturers','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'products';
        $subactive = 'products';
        $manufacturers= Manufacturer::where('status', 1)->get();
        return view('admin.products.create',compact('active','subactive','manufacturers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        return response()->json(['status'=>true, 'message'=>$request->all()],200);
die();

        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate(
            [
                'manufacturer'=>'bail|required|numeric',
                'name' => ['bail','required','max:100','regex:/^[a-zA-Z0-9 ]*$/', Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category)->where('manufacturer_id', $request->manufacturer)->whereNull('deleted_at');
                })],
                'description'=>'bail|required',
                'banner' =>'bail|required|dimensions:min_width=1600,min_height=250|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
                'meta_tags'=>'bail|required|max:250',
                'meta_keywords'=>'bail|required|max:250',
                'meta_description'=>'bail|required|max:500',
                'category'=>'bail|required|numeric'
            ],
            [
                'name.regex'=>'The name may only contain letters and spaces.'
            ]
        );


         $bannername = null;
         $banner = $request->file('banner');
         $bannername = md5($banner->getClientOriginalName() . time()) . "." . $banner->getClientOriginalExtension();
         $destinationPath = public_path('/uploads/categories');
         $banner->move($destinationPath, $bannername);

        $obj = new Product;
        $obj->name = request()->get('name');
        $obj->description = $request->description;
        $obj->manufacturer_id = $request->manufacturer;
        $obj->category_id = $request->category;
        $obj->meta_keywords = $request->meta_keywords;
        $obj->meta_tags = $request->meta_tags;
        $obj->meta_description = $request->meta_description;
        $obj->banner = $bannername;
        $obj->status = 1;
        
        if($obj->save()){
            return response()->json(['status'=>true, 'message'=> 'Record added successfully.','url'=>url('admin/products')],200);
        }else{
            return response()->json(['status'=>false, 'message'=> 'Record not added. Please try again later.'],200);
        } 
    }

    public function edit(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'products';
        $subactive = 'products';
        $data = Product::where('id', $id)->firstOrFail();

        $manufacturers= Manufacturer::where('status', 1)->get();

        $categories = ManufacturerCategory::where('manufacturer_id',$data->manufacturer_id)->pluck('category_id')->toArray();
        $categories = Category::whereIn('id', $categories)->select('id','name')->get();

        return view('admin.products.edit',compact('active','subactive','data','manufacturers','categories'));
    }

    // update product to respective manufacturer
    public function update(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate(
            [
                'id'=>'bail|required|numeric',
                'name'=>['bail','required','max:100','regex:/^[a-zA-Z0-9 ]*$/', Rule::unique('products')->whereNotIn('category_id', [$request->category])->whereNotIn('manufacturer_id', [$request->manufacturer])->whereNotIn('id',[$request->id])->whereNull('deleted_at')],
                'description'=>'bail|required',
                'category'=>'bail|required|numeric',
                'meta_tags'=>'bail|required|max:250',
                'meta_keywords'=>'bail|required|max:250',
                'meta_description'=>'bail|required|max:500',
                'manufacturer'=>'bail|required|numeric',
                'banner' =>'bail|nullable|dimensions:min_width=1600,min_height=250|image|mimes:jpeg,png,jpg,gif,svg|max:4096',

            ],
            [
                'name.regex'=>'The name may only contain letters and spaces.'
            ]
        );
        $record = Product::where('id', $request->id)->first();
        if(!$record){
            return response()->json(['status'=>false,'message'=>'Product not found. Please try again later.'],200);
        }
        else
        {

            /*if($request->file('banner')){
                $bannerName = null;
                $banner = $request->file('banner');
                $bannerName = md5($banner->getClientOriginalName() . time()) . "." . $banner->getClientOriginalExtension();
                $destinationIconPath = public_path('/uploads/categories');
                $banner->move($destinationIconPath, $bannerName);

                $old_path_banner = public_path('uploads/categories/'.$bannerName);
                if(\File::exists($old_path_banner)){
                    \File::delete($old_path_banner);
                }
                $image_banner=$bannerName;
            }*/

         if ($request->hasFile('banner')) {
               $file = request()->file('banner');
                $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $destinationIconPath = public_path('/uploads/categories');
               $file->move($destinationIconPath, $logoName);
               $img= $logoName;
            }else{
               $res=Product::where(['id'=>$request->id])->first();
               $img=$res->banner;
            }
            $record->name = request()->get('name');
            $record->description = $request->description;
            $record->category_id = $request->category;
            $record->manufacturer_id = $request->manufacturer;
            $record->meta_keywords = $request->meta_keywords;
            $record->meta_description = $request->meta_description;
            $record->meta_tags = $request->meta_tags;
            $record->banner = $img;
            $record->manufacturer_id = $request->manufacturer;
            if($record->save()){
                return response()->json(['status'=>true, 'message'=> 'Record updated successfully.','url'=>url('admin/products')],200);
            }else{
                return response()->json(['status'=>false, 'message'=> 'Record not saved. Please try again later.'],200);
            }
        }  
    }

    public function status(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $id = $request->id;
        $status = ($request->status==1) ? 1: 0;
        $data = Product::where('id',$id)->first();
        if($data){
            $data->status = $status;
            $data->save();
            return response()->json(['status'=>true,'message'=>'status updated successfully.'],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }
    }

    public function destroy(Product $product)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);

        if($product->delete()){
            return response()->json(['status'=>true, 'message'=>'Product Family deleted successfully.'],200);
        }
         return response()->json(['status'=>false, 'message'=>'Product Family not deleted, Please try again later.'],200);
    }
}
