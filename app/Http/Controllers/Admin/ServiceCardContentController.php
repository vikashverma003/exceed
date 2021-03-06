<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    ServiceCardContent, Cms
};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceCardContentController extends Controller
{
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'cms_management_access';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'cms';
        $subactive = 'servicecards';
        $data = ServiceCardContent::orderBy('id','DESC')->get();
        $cmsContent = Cms::first();
        return view('admin.servicecards.index',compact('active','data','subactive','cmsContent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'cms';
        $subactive = 'servicecards';
        $cms = Cms::select('service_card_1_title','service_card_2_title','service_card_3_title')->first();

        return view('admin.servicecards.create.index',compact('active','subactive','cms'));
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
        $request->validate(
            [
                'card_number'=>'bail|required|numeric',
                'title'=>'bail|required|unique:service_card_contents|max:50',
                'content'=>'bail|required|min:10|max:5000',
            ]
        );
        $check = ServiceCardContent::where('card_number', request()->get('card_number'))->count();
        if($check==5){
        	return response()->json(['status'=>false,'message'=>'You can add maximum 5 contents per card.'],200);
        }
        $res = ServiceCardContent::create([
            'card_number' => request()->get('card_number'),
            'title' => request()->get('title'),
            'content' => request()->get('content'),
        ]);

        if($res){
            return response()->json(['status'=>true,'message'=>'Content saved successfully.','url'=>url('admin/servicecards')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceCardContent  $serviceCardContent
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceCardContent $serviceCardContent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceCardContent  $serviceCardContent
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'cms';
        $subactive = 'servicecards';
        $data = ServiceCardContent::where('id', $id)->firstOrFail();
        $cms = Cms::select('service_card_1_title','service_card_2_title','service_card_3_title')->first();

        return view('admin.servicecards.edit.index',compact('active','subactive','data','cms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceCardContent  $serviceCardContent
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
         $request->validate(
            [
                'title'=>['bail','required','max:50', Rule::unique('service_card_contents')->ignore($id, 'id')],
                'content'=>'bail|required|min:10|max:5000',
            ]
        );

        $data = ServiceCardContent::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }

        $data->title = $request->title;
        $data->content = $request->content;

        if($data->save()){
            return response()->json(['status'=>true,'message'=>'Record updated successfully.','url'=>url('admin/servicecards')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceCardContent  $serviceCardContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $data = ServiceCardContent::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }else{
            $res = $data->delete();
            if($res){
                return response()->json(['status'=>true,'message'=>'Record deleted successfully.','url'=>url('admin/servicecards')],200);
            }else{
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
            }
        }
    }
}
