<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lead;
use App\Contact;
use App\User;
use Auth;
use Validator;
class LeadController extends Controller
{
	 public function details(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'start_date' => 'required|date_format:"Y-m-d"',
            'end_date' => 'required|date_format:"Y-m-d"',
           
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		
		 //get the authentication user.
		$user = Auth::user();
		$id = $user->id;
		$leads = User::find($id)->leads()
								->whereBetween('lead_date',[$start_date,$end_date])
								->get();
		/* $leads = Lead::where('user_id', $id)
						->whereBetween('lead_date',[$start_date,$end_date])
						->get();*/
        $data = $leads->toArray();
	    $response = [
            'success' => true,
            'data' => $data
			
        ];
        return response()->json($response, 200);
 
       
    }
	
	public function clist(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'id' => 'required',   
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }
		$lid = $request->id;
		
		$contacts = Contact::where('lid', $lid)->get();
        $data = $contacts->toArray();
	    $response = [
            'success' => true,
            'data' => $data
			
        ];
        return response()->json($response, 200);
	}
    
}
