<?php

namespace App\Model\TalabatCod;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TalabatCodDeduction extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $dates = ['start_date', 'end_date'];

    protected $fillable = ['city_id','zone_id','rider_name','rider_id','platform_code','rider_status','vendor','deduction','deposit_status','days_delayed','start_date','end_date','upload_by','passport_id'];
}
