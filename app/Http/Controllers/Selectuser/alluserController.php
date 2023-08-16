<?php

namespace App\Http\Controllers\Selectuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userRegistrtion\Userregistration;
use DB;

class alluserController extends Controller
{
    public function seletDataAll()
    {
        $select_user = Userregistration::all();
        return response()->json(['status'=>true, 'data'=>$select_user]);  
    }
}
