<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Seeder\CompanyInformation;
use OwenIt\Auditing\Contracts\Auditable;

class SimImports extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "sim_imports";
    protected $fillable=['account_number','party_id','product_type','network'];
    public  function get_get_party_etisalat(){
        return $this->belongsTo('App\Model\Seeder\CompanyInformation','party_id','etisalat_party_id');
        //return $this->hasOne('App\Category','id','category_id');
    }

    public  function get_du(){
        return $this->belongsTo(CompanyInformation::class,'party_id','du_acc');
    }

}
