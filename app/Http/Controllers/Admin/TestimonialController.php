<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class TestimonialController extends Controller
{
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'cms_management_access';
    }
     /**
    * return dashboard view of admin side
    */
    public function index(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'cms';
        $subactive = 'testimonials';
        $inputs = $request->all();
        $data = Testimonial::orderBy('id','DESC')->get();

        return view('admin.testimonials.index',compact('active','data','subactive'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'cms';
        $subactive = 'testimonials';
        return view('admin.testimonials.create.index',compact('active','subactive'));
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
                'user_name'=>'bail|required|max:20',
                'user_role'=>'bail|required|max:20',
                'comment'=>'bail|required|min:10|max:500',
                'user_image' =>'bail|required|image|mimes:jpeg,png,jpg|max:2048',
            ]
        );


        $name = null;
        $logo = $request->file('user_image');
        $name = md5($logo->getClientOriginalName() . time()) . "." . $logo->getClientOriginalExtension();

        $image_resize = Image::make($logo->getRealPath());              
        $image_resize->resize(50, 50);
        $image_resize->save(public_path('/uploads/testimonials/' .$name));

        $res = Testimonial::create([
            'user_name' => request()->get('user_name'),
            'user_role' => request()->get('user_role'),
            'comment' => request()->get('comment'),
            'user_image' => $name,
            'status' => 1
        ]);
        if($res){
            return response()->json(['status'=>true,'message'=>'Testimonial created successfully.','url'=>url('admin/testimonials')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    /**
    * change status of Category
    */
    public function changeStatus(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $id = $request->id;
        $status = ($request->status==1) ? 1: 0;
        $data = Testimonial::where('id',$id)->first();
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
        $active = 'cms';
        $subactive = 'testimonials';
        $data = Testimonial::where('id', $id)->firstOrFail();

        return view('admin.testimonials.edit.index',compact('active','subactive','data'));
    }

    // update method of category
    public function update(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate(
            [
                'user_name'=>'bail|required|max:20',
                'user_role'=>'bail|required|max:20',
                'comment'=>'bail|required|min:10|max:500',
                'user_image' =>'bail|nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]
        );

        $data = Testimonial::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }

        $data->user_name = $request->user_name;
        $data->user_role = $request->user_role;
        $data->comment = $request->comment;

        if($request->file('user_image')){
            $name = null;
            $logo = $request->file('user_image');
            $name = md5($logo->getClientOriginalName() . time()) . "." . $logo->getClientOriginalExtension();

            $image_resize = Image::make($logo->getRealPath());              
            $image_resize->resize(50, 50);
            $image_resize->save(public_path('/uploads/testimonials/' .$name));

            $old_path = public_path('uploads/testimonials/'.$data->user_image);
            
            if(\File::exists($old_path)){
                \File::delete($old_path);
            }

            $data->user_image = $name;
        }

        $res = $data->save();
        if($res){
            return response()->json(['status'=>true,'message'=>'Testimonial updated successfully.','url'=>url('admin/testimonials')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    public function destroy(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $data = Testimonial::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }else{

            $old_path = public_path('uploads/testimonials/'.$data->user_image);
            if(\File::exists($old_path)){
                \File::delete($old_path);
            }

            $res = $data->delete();
            if($res){
                return response()->json(['status'=>true,'message'=>'Testimonial deleted successfully.','url'=>url('admin/testimonials')],200);
            }else{
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
            }
        }
    }
}
