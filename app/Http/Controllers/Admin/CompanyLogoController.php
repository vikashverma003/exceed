<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyLogo;
use Illuminate\Http\Request;

class CompanyLogoController extends Controller
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
        $subactive = 'companylogo';
        $inputs = $request->all();
        $data = CompanyLogo::orderBy('id','DESC')->get();

        return view('admin.companylogo.index',compact('active','data','subactive'));
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
        $subactive = 'companylogo';
        return view('admin.companylogo.create.index',compact('active','subactive'));
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
                'title'=>'bail|required|max:50',
                'logo' =>'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]
        );


        $name = null;
        $logo = $request->file('logo');
        $name = md5($logo->getClientOriginalName() . time()) . "." . $logo->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/companieslogo');
        $logo->move($destinationPath, $name);

        $res = CompanyLogo::create([
            'title' => request()->get('title'),
            'logo' => $name,
            'status' => 1
        ]);
        if($res){
            return response()->json(['status'=>true,'message'=>'Record created successfully.','url'=>url('admin/companylogos')],200);
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
        $data = CompanyLogo::where('id',$id)->first();
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
        $subactive = 'companylogo';
        $data = CompanyLogo::where('id', $id)->firstOrFail();

        return view('admin.companylogo.edit.index',compact('active','subactive','data'));
    }

    // update method of category
    public function update(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate(
            [
                'title'=>'bail|required|max:50',
                'logo' =>'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]
        );

        $data = CompanyLogo::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }

        $data->title = $request->title;

        if($request->file('logo')){
            $name = null;
            $logo = $request->file('logo');
            $name = md5($logo->getClientOriginalName() . time()) . "." . $logo->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/companieslogo');
            $logo->move($destinationPath, $name);

            $old_path = public_path('upload/companieslogo/'.$data->logo);
            
            if(\File::exists($old_path)){
                \File::delete($old_path);
            }

            $data->logo = $name;
        }

        $res = $data->save();
        if($res){
            return response()->json(['status'=>true,'message'=>'Record updated successfully.','url'=>url('admin/companylogos')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    public function destroy(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);

        $data = CompanyLogo::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }else{

            $old_path = public_path('upload/companieslogo').'/'.$data->logo;
            if(\File::exists($old_path)){
                \File::delete($old_path);
            }

            $res = $data->delete();
            if($res){
                return response()->json(['status'=>true,'message'=>'Record deleted successfully.','url'=>url('admin/companylogos')],200);
            }else{
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
            }
        }
    }
}
