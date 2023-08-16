<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact\Contactus;

class contactusController extends Controller
{
    public function contact(request $request)
    {
        // return $request->all();
        $data = Contactus::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'address' => $request->input('address'),
        ]);
        return response()->json(['status'=>true, 'message'=>'We will caontact you']);
    }

    public function getcontact()
    {
        $getcontact = Contactus::all();
        
        if ($getcontact->isEmpty()) {
            return response()->json(['status' => false, 'data' => 'No records found']);
        } else {
            return response()->json(['status' => true, 'data' => $getcontact]);
        }
    }
}
