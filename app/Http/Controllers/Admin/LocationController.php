<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'location_management_access';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);

        $active = 'location';
        $subactive = 'location';
        $data = Location::orderBy('id','desc')->get();

        return view('admin.locations.index', compact('active','subactive','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name'=>'bail|required|string|max:50|unique:locations',
        ]);

        $obj = new Location;
        $obj->name = $request->name;
        if($obj->save()){
            return response()->json(['status'=>true, 'message'=>'Record saved successfully.'],200);
        }
         return response()->json(['status'=>false, 'message'=>'Record not saved, Please try again later.'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);

        $request->validate([
            'name'=>['bail','required','max:50', Rule::unique('locations')->ignore($request->id, 'id')],
        ]);

        $obj = Location::where('id', $request->id)->first();
        if(!$obj){
            return response()->json(['status'=>false, 'message'=>'Record not found, Please try again later.'],200);
        }
        
        $obj->name = $request->name;
        if($obj->save()){
            return response()->json(['status'=>true, 'message'=>'Record saved successfully.'],200);
        }
        return response()->json(['status'=>false, 'message'=>'Record not saved, Please try again later.'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);

        if($location->delete()){
            return response()->json(['status'=>true, 'message'=>'Record deleted successfully.'],200);
        }
         return response()->json(['status'=>false, 'message'=>'Record not deleted, Please try again later.'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $obj = Location::where('id', $request->id)->first();
        if(!$obj){
            return response()->json(['status'=>false, 'message'=>'Record not found, Please try again later.'],200);
        }
        $status = ($request->status==0) ? 0 : 1;
        $obj->status = $status;

        if($obj->save()){
            return response()->json(['status'=>true, 'message'=>'Record updated successfully.'],200);
        }
        return response()->json(['status'=>false, 'message'=>'Record not deleted, Please try again later.'],200);
    }
}
