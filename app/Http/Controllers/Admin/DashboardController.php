<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Rules\{
    IsCurrentPassword,AdminUserEmail
};
use App\Models\{
    ContactUs, QuoteEnquiry, Manufacturer, Course, Coupon, Order
};
use App\User;
use App\Models\{
    Admin, Role
};
use \Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        
    }

    /**
    * Validate admin login email and password and redirect to dashboard else return back to login screen.
    */
    public function login(Request $request){
        $validatedData = $request->validate([
            'email' => ['bail','required','max:255','email','exists:admins',new AdminUserEmail],
            'password' => ['bail','required','min:8', new IsCurrentPassword($request->email)],
        ]);
        
        $role_id = Admin::where('email', $request->email)->value('role_id');
        $guard = Role::where('id', $role_id)->value('name');

        // attempt to do the login
        $auth = auth('admin')->attempt(
            [
                'email' => strtolower($request->get('email')),
                'password' => $request->get('password')
            ]
        );

        if ($auth) {
            if($guard=='admin')
                return redirect('admin/dashboard');
            elseif ($guard=='sub_admin') {
                return redirect('subadmin/dashboard');
            }else{
                flash('guard not found, Please try again.')->error();
                return redirect()->back();
            }
        }
        else {
            flash('Details are not validated, Please try again.')->error();
            return redirect()->back();
        }
    }


    /**
    * return dashboard view of admin side
    */
    public function index(){
        $active = 'dashboard';
        $subactive = 'dashboard';
        $data = [];
        $data['users'] = User::where('status', 1)->count();
        $data['quotes'] = QuoteEnquiry::where('status',0)->count();
        $data['contactus'] = ContactUs::where('status',0)->count();
        $data['manufacturers'] = Manufacturer::where('status',1)->count();
        $data['courses'] = Course::where('status',1)->count();
        $data['orders'] = Order::count();
        $data['revenue'] = Order::sum('total_amount_paid');
        $data['coupons'] = Coupon::whereDate('expired_at','>=', date('Y-m-d'))->whereRaw('`limit` > `used`')->count();

        return view('admin.dashboard.index',compact('active','subactive','data'));
    }

    public function dashboardGraphs(Request $request){
        $start =  $request->start;
        $end = $request->end;
        $data = [];

        $date1 = str_replace('/', '-', $start);
        $date1 = date('Y-m-d', strtotime($date1));
        $date2 = str_replace('/', '-', $end);
        $date2 = date('Y-m-d', strtotime($date2));

        $dd1 = Carbon::parse($date1);
        $dd2 = Carbon::parse($date2);
        $diff = $dd1->diffInDays($dd2);

        try{
            if($diff < 32){
                $selectRaw = 'DATE_FORMAT(created_at,"%d-%m-%Y") as dateM, COUNT(id) as count';
                $groupBy = 'dateM';
                $orderBy = 'dateM';
                $list1 = 'count';
                $list2 = 'dateM';
                $usersData = User::whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->selectRaw($selectRaw)->groupBy(DB::raw($groupBy))->orderBy(DB::raw($orderBy), 'ASC')->get();
                $ordersData = Order::whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->selectRaw($selectRaw)->groupBy(DB::raw($groupBy))->orderBy(DB::raw($orderBy), 'ASC')->get();
                $revenueData = Order::whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->selectRaw('DATE_FORMAT(created_at,"%d-%m-%Y") as dateM, SUM(total_amount_paid) as count')->groupBy(DB::raw($groupBy))->orderBy(DB::raw($orderBy), 'ASC')->get();
            }else
            {
                $selectRaw = 'DATE_FORMAT(created_at,"%Y-%m") as monthM, COUNT(id) as count';
                $groupBy = 'monthM';
                $orderBy = 'monthM';
                $list1 = 'count';
                $list2 = 'monthM';
                $usersData = User::whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->selectRaw($selectRaw)->groupBy(DB::raw($groupBy))->orderBy(DB::raw($orderBy), 'ASC')->get();
                $ordersData = Order::whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->selectRaw($selectRaw)->groupBy(DB::raw($groupBy))->orderBy(DB::raw($orderBy), 'ASC')->get();
                $revenueData = Order::whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->selectRaw('DATE_FORMAT(created_at,"%Y-%m") as monthM, SUM(total_amount_paid) as count')->groupBy(DB::raw($groupBy))->orderBy(DB::raw($orderBy), 'ASC')->get();
            }

            $userResponse = [];
            $orderResponse = [];
            $revenueResponse = [];
            $compareResponse = [];

            $usersTotal = 0;
            $ordersTotal = 0;
            $revenuesTotal = 0;
            if (count($usersData)) {
                foreach ($usersData as $key => $val) {
                    $usersTotal= $usersTotal+ ($val[$list1] ?? 0);
                    $userResponse[] = ['label'=>$val[$list2],'value'=>$val[$list1] ?? 0];
                }
            }

            if (count($ordersData)) {
                foreach ($ordersData as $key => $val) {
                    $ordersTotal= $ordersTotal+ ($val[$list1] ?? 0);
                    $orderResponse[] = ['label'=>$val[$list2],'value'=>$val[$list1] ?? 0];
                }
            }
            if (count($revenueData)) {

                foreach ($revenueData as $key => $val) {
                    $revenuesTotal= $revenuesTotal+ ($val[$list1] ?? 0);
                    $revenueResponse[] =['label'=>$val[$list2],'value'=>$val[$list1] ?? 0];
                }
            }

            $data['userResponse'] = $userResponse;
            $data['orderResponse'] = $orderResponse;
            $data['revenueResponse'] = $revenueResponse;
            $data['compareResponse'] = $compareResponse;

            $data['users'] = $usersTotal;
            $data['quotes'] = QuoteEnquiry::where('status',0)->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->count();
            $data['contact'] = ContactUs::where('status',0)->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->count();
            $data['orders'] = $ordersTotal;
            $data['revenue'] = $revenuesTotal;
            return response()->json(['status'=>true,'data'=>$data], 200);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 400);
        }
    }

    /**
    * logout admin user if logged in 
    */
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    /**
    * return profile of admin to change password
    */
    public function getProfile(){
        $active = 'dashboard';
        $subactive = 'dashboard';
        return view('admin.auth.profile',compact('active','subactive'));
    }

    /**
    * update admin password after validating current password
    */
    public function postProfile(Request $request){
        $email = isset(Auth::guard('admin')->user()->email) ? Auth::guard('admin')->user()->email: '';

        $validatedData = $request->validate([
            'old_password' => ['bail','required','min:8',new IsCurrentPassword($email)],
            'password' => 'bail|required|min:8|same:password',
            'password_confirmation' => 'bail|required|min:8|same:password',     
        ]);

        $authId = isset(Auth::guard('admin')->user()->id) ? Auth::guard('admin')->user()->id: '';
        Admin::where('id', $authId)->update(['password'=>Hash::make($request->password)]);

        flash('Password updated successfully. Please login with new credentials.')->success()->important();
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
