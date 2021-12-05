<?php

namespace App\Http\Controllers\Api\Talabat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TalabatCod\TalabatCod;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Talabat\TalabatCodResource;

class TalabatCodApiController extends Controller
{
    public function talabat_rider_cods(Request $request)
    {
        $start_date = $request->start_date ?? Carbon::today()->format('Y-m-d');
        $passport_id = Auth::user()->profile->passport_id;
        return $talabat_cod = TalabatCod::wherePassportId($passport_id)->whereStartDate($start_date)->latest()->first();
        // return TalabatCodResource::collection($talabat_cod);
    }
}
