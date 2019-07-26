<?php

namespace App\Http\Controllers\API;

use Hash;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User; 
use App\Profile; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class ProfileController extends Controller
{
     public function profile(){
		$user = Auth::user();
		$id = $user->id;
		$profile = User::find($id)->profile;
		$data = $profile;
		$data['name'] = $user->name;
		$data['email'] = $user->email;
		$response = [
            'success' => true,
            'data' => $data
			
        ];
        return response()->json($response, 200);
	}
	
	 public function dashboard(){
		$user = Auth::user();
		$id = $user->id;
		$total_leads = User::find($id)->leads()->count();
		$today = date("Y-m-d");
		$pday = date("Y-m-d",strtotime("-1 days"));
		$today_leads = User::find($id)->leads()->where('lead_date',$pday)->count();
		$day = date('l');
		if($day == 'Monday')
			$monday = date("Y-m-d");
		else
		{
			$d=strtotime("previous monday");
			$monday = date("Y-m-d",$d);
		}
		$week_leads = User::find($id)->leads()->whereBetween('lead_date',[$monday,$today])->count();
		$msd = date("Y-m-d",strtotime("first day of this month"));
		$month_leads = User::find($id)->leads()->whereBetween('lead_date',[$msd,$today])->count();
		$current_month = date('F');
		
		$one_month_ago = date('F',strtotime('-1 month'));
		$omasd = date('Y-m-d', strtotime('first day of last month'));
		$omald = date('Y-m-d', strtotime('last day of last month'));
		$one_month_ago_leads = User::find($id)->leads()->whereBetween('lead_date',[$omasd,$omald])->count();
		
		$two_month_ago = date('F',strtotime('-2 month'));
		$tmasd = date('Y-m-d', strtotime('first day of -2 month'));
		$tmald = date('Y-m-d', strtotime('last day of -2 month'));
		$two_month_ago_leads = User::find($id)->leads()->whereBetween('lead_date',[$tmasd,$tmald])->count();
		
		$three_month_ago = date('F',strtotime('-3 month'));
		$thmasd = date('Y-m-d', strtotime('first day of -3 month'));
		$thmald = date('Y-m-d', strtotime('last day of -3 month'));
		$three_month_ago_leads = User::find($id)->leads()->whereBetween('lead_date',[$thmasd,$thmald])->count();
		
		$four_month_ago = date('F',strtotime('-4 month'));
		$fmasd = date('Y-m-d', strtotime('first day of -4 month'));
		$fmald = date('Y-m-d', strtotime('last day of -4 month'));
		$four_month_ago_leads = User::find($id)->leads()->whereBetween('lead_date',[$fmasd,$fmald])->count();
		
		$five_month_ago = date('F',strtotime('-5 month'));
		$fimasd = date('Y-m-d', strtotime('first day of -5 month'));
		$fimald = date('Y-m-d', strtotime('last day of -5 month'));
		$five_month_ago_leads = User::find($id)->leads()->whereBetween('lead_date',[$fimasd,$fimald])->count();
		
		$direct = User::find($id)->leads()->where('source','Direct')->count();
		$google_organic = User::find($id)->leads()->where('source','google / organic')->count();
        $google_cpc = User::find($id)->leads()->where('source','google / cpc')->count();
		$referral = User::find($id)->leads()->where('source','like','%referral')->count();
		
		$data['total_leads'] = $total_leads;
		$data['today_leads'] = $today_leads;
		$data['week_leads'] = $week_leads;
		$data['month_leads'] = $month_leads;
		$data['current_month'] = $current_month;
		$data['one_month_ago'] = $one_month_ago;
		$data['one_month_ago_leads'] = $one_month_ago_leads;
		$data['two_month_ago'] = $two_month_ago;
		$data['two_month_ago_leads'] = $two_month_ago_leads;
		$data['three_month_ago'] = $three_month_ago;
		$data['three_month_ago_leads'] = $three_month_ago_leads;
		$data['four_month_ago'] = $four_month_ago;
		$data['four_month_ago_leads'] = $four_month_ago_leads;
		$data['five_month_ago'] = $five_month_ago;
		$data['five_month_ago_leads'] = $five_month_ago_leads;
		$data['direct'] = $direct;
		$data['google_organic'] = $google_organic;
		$data['google_cpc'] = $google_cpc;
		$data['referral'] = $referral;
		
		$response = [
            'success' => true,
            'data' => $data
			
        ];
        return response()->json($response, 200);
	}
	
	
	 public function update(Request $request){
		 //validation
        $rules = [
			'id' => 'required',
			'image'    => 'nullable|image|max:2048',
            
        ];
        $request->validate($rules);
		$id = $request->id;
		
		$profile = Profile::findOrFail($id);
		
		$profile->street = $request->street;
        $profile->city = $request->city;
		$profile->province = $request->province;
		$profile->postal_code = $request->postal_code;
		$profile->phone = $request->phone;
		
		//check for file.
        if($request->hasFile('image')){
            //get image file.
           $image = $request->image;
            
            //get just extension.
            $ext = $image->getClientOriginalExtension();
            
            //make a unique name
            $filename = uniqid().'.'.$ext;
            
            //upload the image
            $image->storeAs('public/images',$filename);
			$path = asset('public/storage/images/'.$filename);
			

            //delete the previous image.
			if(isset($profile->image))
			{
				$pimage = basename($profile->image);
				Storage::delete("public/images/{$pimage}");
			}
           
            $profile->image = $path;
        }
        
        
        $profile->save();
		
		  $response = [
            'success' => true,
            'message' => 'Your profile has been updated!'
        ];
        return response()->json($response, 200);
	 }

}
