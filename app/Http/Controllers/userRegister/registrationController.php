<?php

namespace App\Http\Controllers\userRegister;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userRegistrtion\Userregistration;
use Mail;
use DB;

class registrationController extends Controller
{
    public function storeUser(Request $request)
    {
        // return $request->all();
        $otp = rand(1231,7879);
        $userid = uniqid(true);
        $email = $request->input('email');

        $check_exist_email = DB::table('userregistration')->where('email',$email)->exists();
        if($check_exist_email)
        {
            $check_password = Userregistration::select('password')->where('email',$email)->first();
            if (empty($check_password) || empty($check_password->password)) 
            {
                $data =  Userregistration::where('email',$email)->update(['otp'=>$otp, 'userid'=>$userid]);
                $data = ['otp' => $otp];
                $toEmail = $email;
    
                Mail::send('userRegister.userotp',$data,function($messages) use ($toEmail)
                {
                    $messages->to($toEmail);
                    $messages->subject('What India Think Confirmation Otp');
                });
                return response()->json(['status'=>'true','message' => 'Otp has been send register email','userid'=>$userid]);
            }
            else{
                return response()->json(['status'=>false, 'message'=>'You have already register']);
            } 
        }
        else{
            $newregister = Userregistration::create([
                'name'=> $request->input('name'),
                'userid'=> $userid,
                'email'=> $request->input('email'),
                'mobile'=> $request->input('mobile'),
                'address'=> $request->input('address'),
                'otp' => $otp
            ]); 

            $data = ['otp' => $otp];
            $toEmail = $email;

            Mail::send('userRegister.userotp',$data,function($messages) use ($toEmail)
            {
                $messages->to($toEmail);
                $messages->subject('Confirmation Otp What India Thinks');
            });
            return response()->json(['staus'=>'true','message' => 'Otp has been send register email','userid'=>$userid]);
        }
    }
    
    public function otpVerify(Request $request)
    {
        $userid = $request->input('userid');
        $otp = $request->input('otp');

        $emailverification_otp = DB::table('userregistration')->where([['userid', $userid], ['otp', $otp]])->first();

        if ($emailverification_otp) {
            return response()->json(['success' => true, 'msg' => 'OTP verified successfully'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid OTP', 'otp' => $otp], 400);
        }
    }

    public function setPassword(Request $request)
    {
        $userid = $request->input('userid');
        $password = $request->input('password');
        $isuserid = DB::table('userregistration')->where('userid', $userid)->exists();
        if($isuserid)
        {
            $setpassword =  Userregistration::where('userid',$userid)->update(['password'=>$password]);
            return response()->json(['status'=>true, 'message'=>'You have to register successfully']);
        }
    }
}
