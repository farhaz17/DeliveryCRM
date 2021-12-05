<?php

namespace App\Model\AgreementAmendment;

use App\Model\AdminFees\AdminFees;
use App\Model\Agreement\TreeAmount;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\AgreementAmountFees\AgreementAmountFees;

class AgreementAmendmentAmounts extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "agreement_amendment_amounts";

    protected $guarded = [];

    protected $fillable = [ 'agreement_amendment_id',
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
