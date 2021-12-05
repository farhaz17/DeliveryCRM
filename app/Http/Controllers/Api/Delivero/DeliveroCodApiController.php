<?php

namespace App\Http\Controllers\Api\Delivero;

use App\Model\Cods\Cods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DeliveroCodResource;
use App\Model\CodAdjustRequest\CodAdjustRequest;

class DeliveroCodApiController extends Controller
{
    public function delivero_rider_cods(Request $request)
    {
        $passport_id = Auth::user()->profile->passport_id;
        $data = collect();
        $data['Cods'] = Cods::wherePassportId($passport_id)->where('platform_id','4')->get();
        $data['CodAdjustRequest'] = CodAdjustRequest::where('passport_id',$passport_id)->where('platform_id','4')->get();
        return DeliveroCodResource::collection($data);
    }
}
