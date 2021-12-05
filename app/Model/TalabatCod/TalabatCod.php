<?php

namespace App\Model\TalabatCod;

use App\Model\Cities;
use App\Model\RiderZone\Zone;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TalabatCod extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['city_id','zone_id','rider_name','rider_id','platform_code','rider_status','vendor','previous_day_pending','current_day_cash_deposit','previous_day_balance','current_day_adjustment','current_day_cod','tips','current_day_balance','deposit_status','days_delayed','start_date','end_date','upload_by','passport_id'];
    protected $casts = [];

    public function passport()
    {
        return $this->belongsTo(Passport::class, 'passport_id');
    }
    public function zone_detail()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
    public function city_detail()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
    public function follow_ups()
    {
        return $this->hasMany(TalabatCodFollowUp::class, 'talabat_cod_id');
    }
}
