<?php

namespace App\Model\Agreement;

use App\Model\Master_steps;
use App\Model\AdminFees\AdminFees;
use App\Model\Agreement\TreeAmount;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\AgreementAmountFees\AgreementAmountFees;

class AgreementAmount extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "agreement_amounts";
    protected $fillable = [
        'agreement_id',
        'tree_amount_id',
        'amount',
    ];

    public  function get_tree_amount(){
        return $this->belongsTo(TreeAmount::class,'tree_amount_id');
    }

    public function get_fees_lebel(){
        return $this->belongsTo(AgreementAmountFees::class,'tree_amount_id');
    }




    public function get_admin_fees(){
        return $this->belongsTo(AdminFees::class,'tree_amount_id');
    }




}
