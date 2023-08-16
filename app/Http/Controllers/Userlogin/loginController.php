<?php

namespace App\Http\Controllers\Userlogin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userRegistrtion\Userregistration;
use DB;

class loginController extends Controller
{
    public function loginUser(Request $request)
    {
        // return "login";
        $email = $request->input('email');
        $password = $request->input('password');

        $admin_exist = Userregistration::select('email','password')->where([['email', $email],['password',$password]])->exists();
        if($admin_exist)
        {
            $selectuserlogin= Userregistration::select('userid','name','email','mobile','password')->where('email',$email)->orwhere('password',$password)->first();
            return response()->json(['success'=>true, 'message'=>'login successfully', 'data'=>$selectuserlogin]);
        }
        else{
            return response()->json(['success'=>false, 'message'=>'Email or Password not match']);
        }
    }
}
