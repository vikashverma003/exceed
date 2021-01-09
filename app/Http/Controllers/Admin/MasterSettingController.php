<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Setting, Location
};
use Illuminate\Validation\Rule;

class MasterSettingController extends Controller
{
    
    /**
    * get contact us and qoutes emails 
    */
    public function getContactMails(Request $request){
        $active='mastersettings';
        $subactive='contactemails';
        $contact_email = Setting::where('type','contactemails')->where('key','contact_email')->value('value');
        $quotes_email = Setting::where('type','contactemails')->where('key','quotes_email')->value('value');
        $new_account_email = Setting::where('type','contactemails')->where('key','new_account_email')->value('value');

        return view('admin.settings.contactus.index', compact('active','subactive','contact_email','quotes_email','new_account_email'));
    }

     /**
    * udate quotes and contact us emails
    */
    public function updateContactMails(Request $request){
        $request->validate([
            'contact_email'=>'bail|required|string|max:50|email',
            'quotes_email'=>'bail|required|string|max:50|email',
            'new_account_email'=>'bail|required|string|max:50|email',
        ]);

        Setting::where('type','contactemails')->where('key','contact_email')->update(['value'=>$request->contact_email]);
        Setting::where('type','contactemails')->where('key','quotes_email')->update(['value'=>$request->quotes_email]);
        
        Setting::updateOrCreate(
            [
                'key'=>'new_account_email',
                'type'=>'contactemails'
            ],
            [
                'value'=>$request->new_account_email,
            ]);

        return response()->json(['status'=>true,'message'=>'Records updated successfully.'], 200);
    }

     /**
    * get term page content
    */
    public function getTermContent(Request $request){
        $active='mastersettings';
        $subactive='termspage';
        $content = Setting::where('type','content')->where('key','termcontent')->value('value');

        return view('admin.settings.terms.index', compact('active','subactive','content'));
    }

     /**
    * udate term page content
    */
    public function updateTermContent(Request $request){
        $request->validate([
            'content'=>'bail|required|string|max:50000',
        ]);

        Setting::where('type','content')->where('key','termcontent')->update(['value'=>$request->content]);

        return response()->json(['status'=>true,'message'=>'Records updated successfully.'], 200);
    }


     /**
    * get privacy page content
    */
    public function getPrivacyContent(Request $request){
        $active='mastersettings';
        $subactive='privacypage';
        $content = Setting::where('type','content')->where('key','privacycontent')->value('value');

        return view('admin.settings.privacy.index', compact('active','subactive','content'));
    }

     /**
    *  udate privacy page content
    */
    public function updatePrivacyContent(Request $request){
        $request->validate([
            'content'=>'bail|required|string|max:50000',
        ]);

        Setting::where('type','content')->where('key','privacycontent')->update(['value'=>$request->content]);

        return response()->json(['status'=>true,'message'=>'Records updated successfully.'], 200);
    }

    public function getCookieContent(Request $request){
        $active='mastersettings';
        $subactive='cookiepage';
        $content = Setting::where('type','content')->where('key','cookiecontent')->value('value');

        return view('admin.settings.cookiecontent.index', compact('active','subactive','content'));
    }

     /**
    *  udate privacy page content
    */
    public function updateCookieContent(Request $request){
        $request->validate([
            'content'=>'bail|required|string|max:50000',
        ]);

        Setting::where('type','content')->where('key','cookiecontent')->update(['value'=>$request->content]);

        return response()->json(['status'=>true,'message'=>'Records updated successfully.'], 200);
    }

    public function getAllTrainingSitesContent(Request $request){
        $active='mastersettings';
        $subactive='training-site';
        $data = Setting::where('type','training-sites')->get();

        return view('admin.settings.training-sites.index', compact('active','subactive','data'));
    }

    public function createTrainingSiteContent(Request $request){
        $active='mastersettings';
        $subactive='training-site';
        $data = Location::where('status',1)->get();

        return view('admin.settings.training-sites.create', compact('active','subactive','data'));
    }

    public function saveTrainingSiteContent(Request $request){
        $request->validate([
            'type'=>'bail|required|string|max:50',
            'content'=>'bail|required|string|max:50000',
        ]);

        $check = Setting::where('type','training-sites')->where('key',$request->type)->count();

        if($check > 0){
            return response()->json(['status'=>false,'message'=>'Content already exist for this location. Please select another location.'], 200);
        }
        $response = Setting::where('type','training-sites')->where('key',$request->type)->updateOrCreate(['key'=>$request->type,'value'=>$request->content,'type'=>'training-sites']);

        if($response)
            return response()->json(['status'=>true,'message'=>'Records updated successfully.','url'=>url('admin/settings/training-sites')], 200);
        else
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later'], 200);
    }

    public function editTrainingSiteContent(Request $request, $id){
        $active='mastersettings';
        $subactive='training-site';
        $locations = Location::where('status',1)->get();
        $content = Setting::where('type','training-sites')->where('id',$id)->firstOrFail();

        return view('admin.settings.training-sites.edit', compact('active','subactive','locations','content'));
    }

    public function updateTrainingSiteContent(Request $request){
        $request->validate([
            'type'=>'bail|required|string|max:50|unique:settings',
            'content'=>'bail|required|string|max:50000',
            'id'=>'bail|required',
        ]);

        $content = Setting::where('type','training-sites')->where('id',$request->id)->first();
        $content->key = $request->type;
        $content->value = $request->content;
        
        if($content->save())
            return response()->json(['status'=>true,'message'=>'Records updated successfully.','url'=>url('admin/settings/training-sites')], 200);
        else
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later'], 200);
    }

    public function statusTrainingSiteContent(Request $request){
        $obj = Setting::where('id', $request->id)->first();
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
