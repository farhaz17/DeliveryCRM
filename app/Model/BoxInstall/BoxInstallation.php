<?php

namespace App\Model\BoxInstall;

use App\User;
use App\Model\Platform;
use App\Model\BikeDetail;
use App\Model\BoxInstall\BoxBatch;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BoxInstallation extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function bikes()
    {
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }
    public function platformdetail()
    {
        return $this->belongsTo(Platform::class,'platform');
    }
    public function  users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function  batch(){
        return $this->belongsTo(BoxBatch::class,'batch_id');
    }
    public function  removed_user(){
        return $this->belongsTo(User::class,'removed_by');
    }
}
