<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Adminlogin;

class adminLoginController extends Controller
{
    public function adminlog(request $request)
    {
        $email = $request->input('email');
        $pass = $request->input('password');
        $adminlogin = Adminlogin::select('email','password')->where([['email',$email],['password',$pass]])->exists();
        if($adminlogin)
        {
            return response()->json(['status'=>true, 'message'=>'Admin login successfully']);
        }else{
            return response()->json(['status'=>false, 'message'=>'Enter email or password not matched']);
        }
    }
}
