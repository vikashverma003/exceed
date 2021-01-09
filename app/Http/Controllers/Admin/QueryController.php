<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    ContactUs, QuoteEnquiry
};

class QueryController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'queries_management_access';
    }

    /**
    * return list of all contact us queries from frontend 
    */
    public function listContactQueries(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'queries';
        $subactive = 'contact-us';
        $inputs = $request->all();

        $data = ContactUs::whereIn('status', [0,1]);
        $data = self::filters($data, $inputs, $request);
        $data = $data->orderBy('id','DESC')->paginate(10);

        if($request->ajax()){
            return view('admin.contactUs.listing',compact('active','data','subactive'));
        }

        return view('admin.contactUs.index',compact('active','data','subactive'));
    }

    private function filters($data, $inputs, $request){
        // filter data based on filter requested 
        if(isset($inputs['name'])){
            $data->where(function($q) use($inputs){
                $q->where('first_name', 'like', '%' . $inputs['name'] . '%')
                  ->orWhere('last_name', 'like', '%' . $inputs['name'] . '%');
            });
        }
        if(isset($inputs['company_name'])){
            $data->where('company_name', 'like', '%' . $inputs['company_name'] . '%');
        }
        if(isset($inputs['email'])){
            $data->where('email', 'like', '%' . $inputs['email'] . '%');
        }
        if(isset($inputs['phone'])){
            $data->where('phone', 'like', '%' . $inputs['phone'] . '%');
        }

        if(isset($inputs['status'])){
            $data->where('status', (int)$inputs['status']);
        }

        if(isset($inputs['course'])){
            $data->where('course', 'like', '%' . $inputs['course'] . '%');
        }

        if($request->filled('from_date') && $request->filled('to_date'))
        {
            $date1 = str_replace('/', '-', $request->from_date);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->to_date);
            $date2 = date('Y-m-d', strtotime($date2));
            $data->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('from_date')) {
            $date = str_replace('/', '-', $request->from_date);
            $date = date('Y-m-d', strtotime($date));
            $data->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('to_date')){
            $date = str_replace('/', '-', $request->to_date);
            $date = date('Y-m-d', strtotime($date));
            $data->whereDate('created_at','<=' ,$date);
        }else{}
        return $data;
    }

    public function exportContacts(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        try{
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=file.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );
            $inputs = $request->all();
            $data = ContactUs::whereIn('status', [0,1]);
            $data = self::filters($data, $inputs, $request);
            $data = $data->orderBy('id','DESC')->get();

            if(count($data)<1){
                return response()->json(['status'=>false,'message'=>'No Records Found to export.'], 400);
            }
            $columns = array('Name', 'Email', 'Phone', 'Company Name', 'Address','Created');

            $callback = function() use ($data, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($data as $row) {
                    fputcsv($file, array($row->first_name.' '.$row->last_name, $row->email, $row->phone, $row->company_name,$row->city.','.$row->state.','.$row->country.','.$row->zipcode, date('d/m/Y', strtotime($row->created_at))));
                }
                fclose($file);
            };
            return response()->streamDownload($callback, 'prefix-' . date('d-m-Y-H:i:s').'.csv', $headers);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 400);
        }
    }

    /**
    * return list of all quotes queries from frontend 
    */
    public function listQuotesQueries(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $active = 'queries';
        $subactive = 'quotes';

        $inputs = $request->all();
        $data = QuoteEnquiry::whereIn('status', [0,1]);
        $data = self::filters($data, $inputs, $request);
        $data = $data->orderBy('id','DESC')->paginate(10);
        if($request->ajax()){
            return view('admin.quotes.listing',compact('data'));
        }
        return view('admin.quotes.index',compact('active','data','subactive'));
    }

     public function exportQuotes(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        try{
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=file.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );
            $inputs = $request->all();
            $data = QuoteEnquiry::whereIn('status', [0,1]);
            $data = self::filters($data, $inputs, $request);
            $data = $data->orderBy('id','DESC')->get();

            if(count($data)<1){
                return response()->json(['status'=>false,'message'=>'No Records Found to export.'], 400);
            }
            $columns = array('Name', 'Email', 'Phone', 'Company Name', 'Address','Course','Created');

            $callback = function() use ($data, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($data as $row) {
                    fputcsv($file, array($row->first_name.' '.$row->last_name, $row->email, $row->phone, $row->company_name,$row->city.','.$row->state.','.$row->country.','.$row->zipcode,$row->course, date('d/m/Y', strtotime($row->created_at))));
                }
                fclose($file);
            };
            return response()->streamDownload($callback, 'prefix-' . date('d-m-Y-H:i:s').'.csv', $headers);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 400);
        }
    }
}
