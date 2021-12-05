<?php

namespace App\Model\Master;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class WorkingStatusSubCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function subcate_two(){
        return $this->hasMany(WorkingStatusSubCategory::class,'sub_category');
    }

    public function subcate_one(){
        return $this->belongsTo(WorkingStatusSubCategory::class,'sub_category');
    }

    public function main_cat(){
        return $this->belongsTo(WorkingStatusCategory::class,'main_category','id');
    }
}
