<?php

namespace App\Model;

use App\SimCardReplace;
use App\Model\Assign\AssignSim;
use Illuminate\Database\Eloquent\Model;
use App\Model\Seeder\CompanyInformation;
use OwenIt\Auditing\Contracts\Auditable;

class Telecome extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "telecomes";
    protected $fillable=['account_number','party_id','product_type','network'];

    public  function get_party_etisalat(){
        return $this->belongsTo('App\Model\Seeder\CompanyInformation','party_id','etisalat_party_id');
//        return $this->hasOne('App\Category','id','category_id');
    }

    public  function get_du(){
        return $this->belongsTo(CompanyInformation::class,'party_id','du_acc');
    }

    public function assign_sim(){
        return $this->hasMany(AssignSim::class,'sim','id');
    }
    public function get_sims(){
        return $this->AssignSim()->where('status','=','1')->first();
    }

    public function replaces_history()
    {
        return $this->hasMany(SimCardReplace::class, 'sim_id');
    }

    public function get_last_record(){

        return $this->replaces_history()->latest()->first();
    }

    public function get_current_sim(){
        return $this->hasOne(AssignSim::class,'sim','id')->where('status','=', 1);
    }

}
