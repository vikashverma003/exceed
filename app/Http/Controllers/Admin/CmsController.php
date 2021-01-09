<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Cms;

class CmsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $subactive = 'cms';
        $cmsContent = Cms::first();
        return view('admin.cms.index',compact('active','subactive','cmsContent'));
    }


    public function update(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate(
            [
                'page_heading'=>'bail|required|max:100',
                'search_placeholder'=>'bail|required|max:50',
                'search_button_title'=>'bail|required|max:20',
                'advance_search_heading'=>'bail|required|max:100',
                'advance_search_title'=>'bail|required|max:100',
                'services_title'=>'bail|required|max:100',
                'services_sub_title'=>'bail|required|max:100',
                'category_title'=>'bail|required|max:100',
                'category_sub_title'=>'bail|required|max:100',
                'manufacturer_title'=>'bail|required|max:100',
                'manufacturer_sub_title'=>'bail|required|max:100',
                'testimonial_title'=>'bail|required|max:100',
                'testimonial_sub_title'=>'bail|required|max:100',
                'background_video' =>'bail|nullable|string|max:255',
            ]
        );
        $obj = Cms::first();
        if($obj){
            $obj->page_heading = request()->get('page_heading');
            $obj->background_video = request()->get('background_video') ?? null;
            $obj->search_placeholder =  request()->get('search_placeholder');
            $obj->search_button_title =  request()->get('search_button_title');
            $obj->advance_search_heading =  request()->get('advance_search_heading');
            $obj->advance_search_title =  request()->get('advance_search_title');
            $obj->services_title =  request()->get('services_title');
            $obj->services_sub_title =  request()->get('services_sub_title');
            $obj->category_title =  request()->get('category_title');
            $obj->category_sub_title =  request()->get('category_sub_title');
            $obj->manufacturer_title =  request()->get('manufacturer_title');
            $obj->manufacturer_sub_title =  request()->get('manufacturer_sub_title');
            $obj->testimonial_title =  request()->get('testimonial_title');
            $obj->testimonial_sub_title =  request()->get('testimonial_sub_title');
            $res = $obj->save();
        }else{
            $res = Cms::Create([
                'page_heading' => request()->get('page_heading'),
                'background_video' => request()->get('background_video'),
                'search_placeholder' => request()->get('search_placeholder'),
                'search_button_title' => request()->get('search_button_title'),
                'advance_search_heading' => request()->get('advance_search_heading'),
                'advance_search_title' => request()->get('advance_search_title'),
                'services_title' => request()->get('services_title'),
                'services_sub_title' => request()->get('services_sub_title'),
                'category_title' => request()->get('category_title'),
                'category_sub_title' => request()->get('category_sub_title'),
                'manufacturer_title' => request()->get('manufacturer_title'),
                'manufacturer_sub_title' => request()->get('manufacturer_sub_title'),
                'testimonial_title' => request()->get('testimonial_title'),
                'testimonial_sub_title' => request()->get('testimonial_sub_title'),
                'service_card_2' => 0,
                'service_card_3' => 0,
                'service_card_1_title' => 'Training',
            	'service_card_2_title' =>  'Productions',
            	'service_card_3_title' =>  'Consulting',
            ]);
        }

        if($res){
            return response()->json(['status'=>true,'message'=>'Records updated successfully.','url'=>url('admin/cms')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    public function updateServiceContent(Request $request){
        abort_unless(helperCheckPermission($this->permissionName), 403);
        $request->validate(
            [
                'service_card_2'=>'bail|nullable',
                'service_card_3'=>'bail|nullable',
                'service_card_1_title'=>'bail|required|max:100',
                'service_card_2_title'=>'bail|required|max:100',
                'service_card_3_title'=>'bail|required|max:100',
            ]
        );
        $obj = Cms::first();
        if($obj){
            $obj->service_card_1_title =  request()->get('service_card_1_title');
            $obj->service_card_2_title =  request()->get('service_card_2_title');
            $obj->service_card_3_title =  request()->get('service_card_3_title');
            $obj->service_card_2 =  request()->get('service_card_2') ? 1 : 0;
            $obj->service_card_3 =  request()->get('service_card_3') ? 1 : 0;
            $res = $obj->save();
            if($res){
                return response()->json(['status'=>true,'message'=>'Records updated successfully.','url'=>url('admin/cms')],200);
            }else{
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
            }
        }
        else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Record not found'],200);
        }
    }
}
