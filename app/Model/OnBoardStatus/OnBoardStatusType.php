<?php

namespace App\Model\OnBoardStatus;

use App\Model\Platform;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OnBoardStatusType extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'passport_id', 'checkout_type', 'expected_date','platform_id','applicant_status','remarks'
    ];

    function getPlatformIdAttribute(){
        return json_decode($this->attributes['platform_id'],true);
    }

    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function  get_the_platfom_names($id_array){
        return Platform::whereIn('id',$id_array)->pluck('name')->toArray();
    }


}
