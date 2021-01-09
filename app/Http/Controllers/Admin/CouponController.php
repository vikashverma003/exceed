<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\User;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'coupon_management_access';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'coupons';
        $subactive = 'coupons';
        $data = Coupon::with('user')->orderBy('id','desc')->get();

        return view('admin.coupons.index', compact('active','subactive','data'));
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
            'code'=>'bail|required|string|max:50|unique:coupons',
            'user'=>'bail|required',
            'user_type'=>'bail|required',
            'limit'=>'bail|required|numeric|min:1',
            'discount'=>'bail|required|numeric|min:0|max:100',
            'expiry_date'=>'bail|required',
        ]);

        try{
            \DB::beginTransaction();
            
            $obj = new Coupon;
            $obj->code = $request->code;
            $obj->user_id = $request->user;
            $obj->limit = $request->limit;
            $obj->discount = $request->discount;
            $obj->status = 1;

            $date = str_replace('/', '-', $request->expiry_date);
            $date = date('Y-m-d', strtotime($date));

            $obj->expired_at = $date;
            
            if($obj->save()){
                $data = [];
                $data['limit'] = $request->limit;
                $data['discount'] = $request->discount;
                $data['code'] = $request->code;
                $data['expired_at'] = $request->expiry_date;

                $email = User::where('id',$request->user)->value('email');
                User::sendCouponToUser($email,$data);
                \DB::commit();
                return response()->json(['status'=>true, 'message'=>'Record saved successfully.'],200);
            }

            return response()->json(['status'=>false, 'message'=>'Record not saved, Please try again later.'],200);
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['status'=>false, 'message'=>$e->getMessage()],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'limit'=>'bail|required|numeric|min:1',
            'discount'=>'bail|required|numeric|min:0|max:100',
            'expiry_date'=>'bail|required',
        ]);

        $obj = Coupon::where('id', $request->id)->first();
        if(!$obj){
            return response()->json(['status'=>false, 'message'=>'Record not found, Please try again later.'],200);
        }
        
        $obj->limit = $request->limit;
        $obj->discount = $request->discount;

        $date = str_replace('/', '-', $request->expiry_date);
        $date = date('Y-m-d', strtotime($date));

        $obj->expired_at = $date;
        if($obj->save()){
            return response()->json(['status'=>true, 'message'=>'Record saved successfully.'],200);
        }
        return response()->json(['status'=>false, 'message'=>'Record not saved, Please try again later.'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        abort_unless(helperCheckPermission($this->permissionName), 403);
        if($coupon->delete()){
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
        $obj = Coupon::where('id', $request->id)->first();
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

    public function getUsers(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        if($request->val=='indivisual'){
            $users = User::where('status', 1)->where('role_id', 1)->select('id','email','role_id')->get();
        }else{
            $users = User::where('status', 1)->where('role_id', 2)->select('id','email','role_id')->get();
        }

        return response()->json(['status'=>true, 'message'=>'Record updated successfully.','data'=>$users],200);
    }
}
