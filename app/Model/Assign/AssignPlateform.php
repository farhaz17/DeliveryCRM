<?php

namespace App\Model\Assign;

use Carbon\Carbon;
use App\Model\Careem;
use App\Model\Cities;
use App\Model\Platform;
use App\Model\CareemCod;
use App\Model\Cods\Cods;
use App\Model\Cods\CloseMonth;
use App\Model\CareemCloseMonth;
use App\Model\Passport\Passport;
use App\Model\CodUpload\CodUpload;
use App\Model\UserCodes\UserCodes;
use App\Model\TalabatCod\TalabatCod;
use App\Model\Carrefour\CarrefourCod;
use Illuminate\Database\Eloquent\Model;
use App\Model\PlatformCode\PlatformCode;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Carrefour\CarrefourUploads;
use App\Model\RiderReport\RiderFollowUps;
use App\Model\Carrefour\CarreforCloseMonth;
use App\Model\TalabatCod\TalabatCodInternal;
use App\Model\CodAdjustRequest\CodAdjustRequest;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\Riders\RiderPerformance\TalabatRiderPerformance;

class AssignPlateform extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function plateformdetail()
    {
        return $this->belongsTo(Platform::class,'plateform');
    }
    public function city()
    {
        return $this->belongsTo(Cities::class,'city_id');
    }
    public function platform_codes(){
        return $this->belongsTo(PlatformCode::class, 'passport_id');
    }

    public function rider_passport()
    {
        return $this->belongsTo(Passport::class,'passport_id')->select(['passport_id', 'full_name']);
    }

    public function cod_upload(){

        return $this->hasOne(CodUpload::class,'passport_id','passport_id')->selectRaw('passport_id, sum(amount) as total')->groupBy('passport_id');
    }
    public function close_month(){

        return $this->hasOne(CloseMonth::class,'passport_id','passport_id')->selectRaw('passport_id, sum(close_month_amount) as close_total')->groupBy('passport_id');
    }
    public function cods(){

        return $this->hasOne(Cods::class,'passport_id','passport_id')->selectRaw('passport_id, sum(amount) as cod_total')->where('status','1')->groupBy('passport_id');
    }
    public function codadjust(){

        return $this->hasOne(CodAdjustRequest::class,'passport_id','passport_id')->selectRaw('passport_id, sum(amount) as adj_req_total')->where('status','=','2')->groupBy('passport_id');
    }
    public function talabat_cod(){

        return $this->hasOne(TalabatCod::class,'passport_id','passport_id')->select(['id','passport_id', 'current_day_balance'])->latest('start_date');
    }
    public function carrefour_upload(){

        return $this->hasOne(CarrefourUploads::class,'passport_id','passport_id')->selectRaw('passport_id, sum(amount) as total')->groupBy('passport_id');
    }
    public function carrefour_cod(){

        return $this->hasOne(CarrefourCod::class,'passport_id','passport_id')->selectRaw('passport_id, sum(amount) as cod_total')->groupBy('passport_id');
    }
    public function carrefour_close(){

        return $this->hasOne(CarreforCloseMonth::class,'passport_id','passport_id')->selectRaw('passport_id, sum(close_month_amount) as close_total')->groupBy('passport_id');
    }
    public function careem_upload(){

        return $this->hasOne(Careem::class,'passport_id','passport_id')->selectRaw('passport_id, sum(total_driver_other_cost) as total')->groupBy('passport_id');
    }
    public function careem_cod(){

        return $this->hasOne(CareemCod::class,'passport_id','passport_id')->selectRaw('passport_id, sum(amount) as cod_total')->groupBy('passport_id');
    }
    public function careem_close(){

        return $this->hasOne(CareemCloseMonth::class,'passport_id','passport_id')->selectRaw('passport_id, sum(close_month_amount) as close_total')->groupBy('passport_id');
    }
    public function follow_ups()
    {
        return $this->hasMany(RiderFollowUps::class, 'passport_id','passport_id');
    }
    public function careem_cod_filter(){

        return $this->hasMany(CareemCod::class,'passport_id','passport_id')->whereBetween('date',[Carbon::now()->subDays(2)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->groupBy('passport_id');
    }
    public function carrefour_cod_filter(){

        return $this->hasMany(CarrefourCod::class,'passport_id','passport_id')->whereBetween('date',[Carbon::now()->subDays(2)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->groupBy('passport_id');
    }
    public function deliveroo_cods(){

        return $this->hasMany(Cods::class,'passport_id','passport_id')->whereBetween('date',[Carbon::now()->subDays(2)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->where('status','1')->groupBy('passport_id');
    }
    public function deliveroo_codadjust(){

        return $this->hasMany(CodAdjustRequest::class,'passport_id','passport_id')->whereBetween('order_date',[Carbon::now()->subDays(2)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->where('status','=','2')->groupBy('passport_id');
    }
    public function talabat_cods(){

        return $this->hasMany(TalabatCodInternal::class,'passport_id','passport_id')->whereBetween('start_date',[Carbon::now()->subDays(2)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->groupBy('passport_id');
    }
    public function careem_cod_filter_week(){

        return $this->hasMany(CareemCod::class,'passport_id','passport_id')->whereBetween('date',[Carbon::now()->subDays(7)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->groupBy('passport_id');
    }
    public function carrefour_cod_filter_week(){

        return $this->hasMany(CarrefourCod::class,'passport_id','passport_id')->whereBetween('date',[Carbon::now()->subDays(7)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->groupBy('passport_id');
    }
    public function deliveroo_cods_week(){

        return $this->hasMany(Cods::class,'passport_id','passport_id')->whereBetween('date',[Carbon::now()->subDays(7)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->where('status','1')->groupBy('passport_id');
    }
    public function deliveroo_codadjust_week(){

        return $this->hasMany(CodAdjustRequest::class,'passport_id','passport_id')->whereBetween('order_date',[Carbon::now()->subDays(7)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->where('status','=','2')->groupBy('passport_id');
    }
    public function talabat_cods_week(){

        return $this->hasMany(TalabatCodInternal::class,'passport_id','passport_id')->whereBetween('start_date',[Carbon::now()->subDays(7)->format('Y-m-d'),Carbon::now()->format('Y-m-d')])->groupBy('passport_id');
    }
    public function talabat_orders(){

        return $this->hasOne(TalabatRiderPerformance::class,'passport_id','passport_id')->select(['id','passport_id', 'completed_orders','total_working_hours','start_date'])->latest('start_date');
    }
}
