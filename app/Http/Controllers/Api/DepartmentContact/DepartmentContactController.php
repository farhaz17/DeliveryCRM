<?php

namespace App\Http\Controllers\Api\DepartmentContact;

use App\Model\DepartmentContact\DepartmentContact;
use App\Model\VerificationForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepartmentContactController extends Controller
{

     public function contact_list(){



         $list = DepartmentContact::all();

         return response()->json(['data'=>$list], 200, [], JSON_NUMERIC_CHECK);

     }


}
