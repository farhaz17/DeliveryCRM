<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaSubCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function subcate_two(){
        return $this->hasMany(VisaSubCategory::class,'sub_category');
    }

    public function subcate_one(){
        return $this->belongsTo(VisaSubCategory::class,'sub_category');
    }

    public function main_cat(){
        return $this->belongsTo(VisaCategoryMain::class,'main_category','id');
    }
}
