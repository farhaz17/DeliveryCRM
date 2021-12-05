<?php

namespace App\Model\BoxInstall;

use App\User;
use App\Model\Cities;
use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\BoxInstall\BoxInstallation;

class FoodPermit extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public function bikes()
    {
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }
    public function current_box()
    {
        return $this->hasOne(BoxInstallation::class,'bike_id','bike_id')->where('status',6)->select(['id','bike_id','status','platform']);
    }
    public function  users(){
        return $this->belongsTo(User::class,'requested_by');
    }
    public function city(){
        return $this->belongsTo(Cities::class,'citie_id');
    }
}
