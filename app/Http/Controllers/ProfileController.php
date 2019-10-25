<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Profile;
use App\Http\Requests\ProfileValidation;

class ProfileController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function submitProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required',
            'phone' => 'required',
            'address' => 'required',
            'zip' => 'required|integer',
            'image' => 'required',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success'=>false,'msg'=>$errors->first()]);
        }else{
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            if(Profile::insertProfile($request,$imageName)){
                return response()->json(['success'=>true,'msg'=>'You have successfully submitted the profile.']);
            }
            return response()->json(['success'=>false,'msg'=>'somthing went wrong...']);
        }
    }
}