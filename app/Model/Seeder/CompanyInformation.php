<?php

namespace App\Model\Seeder;

use App\Model\Nationality;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyInformation extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "company_informations";
    protected $fillable=['company_id','trade_license_no','establishment_card','labour_card',
        'salik_acc','traffic_fle_no','etisalat_party_id','du_acc'];


    public function company_detail(){
        return $this->belongsTo(Company::class,'company_id');
    }

}
