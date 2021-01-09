<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Order;

class OrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'order_management_access';
    }

    /**
    * return all transactions list
    */
    public function index(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        
        $active = 'orders';
        $subactive = 'orders';
        $inputs = $request->all();
        $transactions = Order::where('id','!=',0);

        // filter data based on filter requested 

        if(isset($inputs['email'])){
            $transactions->whereHas('user', function($q) use($inputs){
                $q->where('email', 'like', '%' . $inputs['email'] . '%');
            });
        }
        if($request->filled('amount')){
            $transactions->where('total_amount_paid','LIKE',  '%' .$request->input('amount'). '%');
        }
        if($request->filled('order_id')){
            $transactions->where('id','LIKE',  '%' .$request->input('order_id'). '%');
        }
        if($request->filled('discount')){
            $transactions->where('discount','LIKE',  '%' .$request->input('discount'). '%');
        }

        if($request->filled('from_date') && $request->filled('to_date'))
        {
            $date1 = str_replace('/', '-', $request->from_date);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->to_date);
            $date2 = date('Y-m-d', strtotime($date2));
            
            $transactions->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('from_date')) {
            $date = str_replace('/', '-', $request->from_date);
            $date = date('Y-m-d', strtotime($date));
            $transactions->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('to_date')){
            $date = str_replace('/', '-', $request->to_date);
            $date = date('Y-m-d', strtotime($date));
            $transactions->whereDate('created_at','<=' ,$date);
        }else{}

        $transactions = $transactions->orderBy('id','DESC')->paginate(10);

        if($request->ajax()){
            return view('admin.orders.listing',compact('transactions'));
        }
        return view('admin.orders.index',compact('active','transactions','subactive'));
    }

    /**
    * get details of particular transaction
    */
    public function view(Request $request, $id){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'orders';
        $subactive = 'orders';
        $transaction = Order::where('id', $id)->with(['items','items.course','items.course.locations'])->firstOrFail();
        
        return view('admin.orders.details.index', compact('active','transaction','subactive'));
    }
}
