<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\{Admin, Role, Permission, AdminPermission};
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Mail\NewAdminAccountNotification;
use Mail;

class SubAdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'subadmin_management_access';
    }

    /**
    * return dashboard view of admin side
    */
    public function index(Request $request){
        if(!Auth::guard('admin')->user()->isAdmin()){
            flash("You don'\t have permission to access.")->error()->important();
                return redirect('admin/dashboard');
        }
        $subactive = $active = 'sub-admin';
        $inputs = $request->all();
        $users = Admin::SubAdminOnly();
        $users = self::filters($users, $inputs, $request);
        
        $users = $users->orderBy('id','DESC')->paginate(10);

        if($request->ajax()){
            return view('admin.sub-admin.listing',compact('users'));
        }
        return view('admin.sub-admin.index',compact('active','users','subactive'));
    }

    private function filters($users, $inputs, $request){
    
        if(isset($inputs['name'])){
            $users->where('name', 'like', '%' . $inputs['name'] . '%');
        }
        if(isset($inputs['email'])){
            $users->where('email', 'like', '%' . $inputs['email'] . '%');
        }
        if(isset($inputs['status'])){
            $users->where('status', (int)$inputs['status']);
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

   
    public function create(Request $request){
        if(!Auth::guard('admin')->user()->isAdmin()){
            flash("You don'\t have permission to access.")->error()->important();
                return redirect('admin/dashboard');
        }
        $subactive = $active = 'sub-admin';
        $all_permissions= [];
        $all_permissions = Permission::select('id','title')->get();

        return view('admin.sub-admin.create', compact('active','subactive','all_permissions'));
    }

    /**
    * get user details of particular user
    */
    public function show(Request $request, $id){
        if(!Auth::guard('admin')->user()->isAdmin()){
            flash("You don'\t have permission to access.")->error()->important();
                return redirect('admin/dashboard');
        }
        $subactive = $active = 'sub-admin';
        $user = Admin::SubAdminOnly()->where('id', $id)->firstOrFail();
        
        return view('admin.sub-admin.details.index', compact('active','user','subactive'));
    }

     public function edit(Request $request, $id){
        if(!Auth::guard('admin')->user()->isAdmin()){
            flash("You don'\t have permission to access.")->error()->important();
                return redirect('admin/dashboard');
        }
        $subactive = $active = 'sub-admin';
        $user = Admin::SubAdminOnly()->where('id', $id)->firstOrFail();
        $all_permissions= [];
        $all_permissions = Permission::select('id','title')->get();
        $permissions_id = [];
        $permissions_id = $user->permissions()->pluck('permission_id')->toArray();

        return view('admin.sub-admin.edit',compact('active','subactive','user','all_permissions','permissions_id'));
    }

    public function store(Request $request){
        if(!Auth::guard('admin')->user()->isAdmin()){
            return response()->json(['status'=>false,'message'=>'you dont have permission to access this feature'],200);
        }
        $request->validate(
            [
                'name'=>'bail|required|string|min:2|max:25',
                'password'=>'bail|required|string|min:2|max:20',
                'email'=>'bail|required|string|min:2|max:50|unique:admins|email',
                'permissions'=>'bail|required|array',
            ]);
        $data = $request->all();

        $object = new Admin;
        $object->name = $request->name;
        $object->password = Hash::make($request->password);
        $object->status = 1;
        $object->is_super = 0;
        $object->role_id = Role::where('name', 'admin')->value('id');
        $object->email = strtolower($request->email);
        if($object->save()){
            $user_id = $object->id;
            $permissions_data = [];
            foreach ($request->permissions as $key => $value) {
                $permissions_data[] = ['admin_id'=>$user_id,'permission_id'=>$value];
            }
            if($permissions_data){
                AdminPermission::insert($permissions_data);
            }
            // send email to sub admin after registration.
            Mail::to($request->email)->send(new NewAdminAccountNotification($data));

            return response()->json(['status'=>true,'message'=>'User created successfully.','url'=>url('admin/sub-admin')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }
    // update method of category
    public function update(Request $request, $id){
        if(!Auth::guard('admin')->user()->isAdmin()){
            return response()->json(['status'=>false,'message'=>'you dont have permission to access this feature'],200);
        }

        $request->validate(
            [
                'name'=>'bail|required|string|min:2|max:25',
                'password'=>'bail|nullable|string|min:2|max:20',
                'permissions'=>'bail|required|array',
                'email'=>['bail','required','string','max:50','email', Rule::unique('admins')->ignore($id, 'id')],
            ]
        );
        $object = Admin::where('id', $id)->first();
        if(!$object){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }
        $object->name = $request->name;
        if($request->filled('password')){
            $object->password = Hash::make($request->password);
        }
        $object->email = strtolower($request->email);

        if($object->save()){
            $permissions_id = $object->permissions()->pluck('permission_id')->toArray();
            $permissions = $request->permissions;
            sort($permissions_id);
            sort($permissions);

            // check if any change in permission then update permission
            if ($permissions_id!=$permissions) 
            {
                AdminPermission::where('admin_id', $id)->delete();
                $permissions_data = [];
                foreach ($request->permissions as $key => $value) {
                    $permissions_data[] = ['admin_id'=>$id,'permission_id'=>$value];
                }
                AdminPermission::insert($permissions_data);
            }

            return response()->json(['status'=>true,'message'=>'User updated successfully.','url'=>url('admin/sub-admin')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    /**
    * update user status
    */
    public function status(Request $request){
        if(!Auth::guard('admin')->user()->isAdmin()){
            return response()->json(['status'=>false,'message'=>'you dont have permission to access this feature'],200);
        }
        $status = ($request->status==1) ? 1 : 0;
        
        $id  =  $request->id;
        $user = Admin::SubAdminOnly()->where('id', $id)->first();
        if($user){
            $user->status = $status;
            $user->save();
            return response()->json(['status'=>true,'message'=>'User status changed sucessfully.'],200);
        }else{
            return response()->json(['status'=>false,'message'=>'User record not found. Please try again later.'],200);
        }
    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::guard('admin')->user()->isAdmin()){
            return response()->json(['status'=>false,'message'=>'you dont have permission to access this feature'],200);
        }

        if(Admin::where('id', $id)->SubAdminOnly()->delete()){
            return response()->json(['status'=>true, 'message'=>'User deleted successfully.'],200);
        }
         return response()->json(['status'=>false, 'message'=>'User not deleted, Please try again later.'],200);
    }
}