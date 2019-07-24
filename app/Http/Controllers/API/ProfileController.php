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
			
			
		  // request()->image->move(public_path('images'), $imageName);

            //delete the previous image.
			if(isset($profile->image))
			{
				$pimage = basename($profile->image);
				Storage::delete("public/images/{$pimage}");
			}
            //Storage::delete("public/images/{$profile->image}");
			//Storage::delete($profile->image);
			
			 //File::delete("{$profile->image}");
            
            //this column has a default value so don't to set it empty.
			//$path = $request->file('image')->store('images');
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
