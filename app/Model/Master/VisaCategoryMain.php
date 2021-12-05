<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaCategoryMain extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function visa_subcategories(){
        return $this->hasMany(VisaSubCategory::class,'main_category');
    }
}
