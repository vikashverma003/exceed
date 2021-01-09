<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{
    Faq
};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FaqController extends Controller
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
        $subactive = 'faqs';
        $data = Faq::orderBy('id','DESC')->get();

        return view('admin.faqs.index',compact('active','data','subactive'));
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
        $subactive = 'faqs';

        return view('admin.faqs.create.index',compact('active','subactive'));
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
                'title'=>'bail|required|max:100',
                'content'=>'bail|required|min:10|max:5000',
            ]
        );

        $res = Faq::create([
            'title' => request()->get('title'),
            'content' => request()->get('content'),
        ]);

        if($res){
            return response()->json(['status'=>true,'message'=>'Content saved successfully.','url'=>url('admin/faqs')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $active = 'cms';
        $subactive = 'faqs';
        $data = Faq::where('id', $id)->firstOrFail();
        
        return view('admin.faqs.edit.index',compact('active','subactive','data'));
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
                'title'=>['bail','required','max:100'],
                'content'=>'bail|required|min:10|max:5000',
            ]
        );

        $data = Faq::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }

        $data->title = $request->title;
        $data->content = $request->content;

        if($data->save()){
            return response()->json(['status'=>true,'message'=>'Record updated successfully.','url'=>url('admin/faqs')],200);
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
        
        $data = Faq::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }else{
            $res = $data->delete();
            if($res){
                return response()->json(['status'=>true,'message'=>'Record deleted successfully.','url'=>url('admin/faqs')],200);
            }else{
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
            }
        }
    }
}
