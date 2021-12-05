<?php

namespace App\Model\Master;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaCategoryAssign extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function main_cate()
    {
        return $this->belongsTo(VisaCategoryMain::class,'main_category');
    }


    public function sub_cate1()
    {
        return $this->belongsTo(VisaSubCategory::class,'sub_category1');
    }

    public function sub_cate2()
    {
        return $this->belongsTo(VisaSubCategory::class,'sub_category2');
    }



}
