<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'customer_management_access';
    }

    /**
    * return dashboard view of admin side
    */
    public function index(Request $request){
    	abort_unless(helperCheckPermission($this->permissionName), 403);

        $active = 'users';
        $subactive = 'users';
        $inputs = $request->all();
        $users = User::UserOnly();

        // filter data based on filter requested 
        $users = self::filters($users, $inputs, $request);
        $users = $users->orderBy('id','DESC')->paginate(10);

        if($request->ajax()){
            return view('admin.users.listing',compact('active','users','subactive'));
        }
        return view('admin.users.index',compact('active','users','subactive'));
    }

    private function filters($users, $inputs, $request){
        if(isset($inputs['name'])){
            $users->where('name', 'like', '%' . $inputs['name'] . '%');
        }
        if(isset($inputs['email'])){
            $users->where('email', 'like', '%' . $inputs['email'] . '%');
        }
        if(isset($inputs['phone'])){
            $users->where('phone', 'like', '%' . $inputs['phone'] . '%');
        }

        if(isset($inputs['status'])){
            $users->where('status', (int)$inputs['status']);
        }

        if(isset($inputs['role'])){
            $users->where('role_id', (int)$inputs['role']);
        }

        if($request->filled('from_date') && $request->filled('to_date'))
        {
            $date1 = str_replace('/', '-', $request->from_date);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->to_date);
            $date2 = date('Y-m-d', strtotime($date2));
            
            $users->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('from_date')) {
            $date = str_replace('/', '-', $request->from_date);
            $date = date('Y-m-d', strtotime($date));
            $users->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('to_date')){
            $date = str_replace('/', '-', $request->to_date);
            $date = date('Y-m-d', strtotime($date));
            $users->whereDate('created_at','<=' ,$date);
        }else{}

        return $users;
    }

    /**
    * get user details of particular user
    */
    public function userDetail(Request $request, $id){
    	abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'users';
        $subactive = 'users';
        $user = User::UserOnly()->where('id', $id)->firstOrFail();
        
        return view('admin.users.details.index', compact('active','user','subactive'));
    }

    /**
    * update user status
    */
    public function userStatusUpdate(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $status = ($request->status==1) ? 1 : 0;
        
        $id  =  $request->id;
        $user = User::UserOnly()->where('id', $id)->first();
        if($user){
            User::where('id', $id)->update(['status'=>$status]);
            // if($status == "0" || $status == 0)
            // {
            //     Auth::logoutUsingId($id);
            // }
            return response()->json(['status'=>true,'message'=>'User status changed sucessfully.'],200);
        }else{
            return response()->json(['status'=>false,'message'=>'User record not found
                . Please try again later.'],200);
        }        
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

            $users = User::UserOnly();

            $inputs = $request->all();
            // filter data based on filter requested 
            $users = self::filters($users, $inputs, $request);
            
            $users = $users->orderBy('id','DESC')->get();

            if(count($users)<1){
                return response()->json(['status'=>false,'message'=>'No Records Found to export.'], 400);
            }
            $columns = array('Name', 'Email', 'Phone', 'Role', 'Created');

            $callback = function() use ($users, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($users as $row) {
                    fputcsv($file, array($row->full_name, $row->email, $row->phone, $row->role_name,date('d/m/Y', strtotime($row->created_at))));
                }
                fclose($file);
            };
            return response()->streamDownload($callback, 'prefix-' . date('d-m-Y-H:i:s').'.csv', $headers);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 400);
        }
    }
}