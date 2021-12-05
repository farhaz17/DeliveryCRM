<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CodRiderLog implements FromView
{
    public $view;
    public $array_to_send;
    public $full_name;
    public $prev_amount;
    public $prev_amount_date;
    public $total_credit;
    public $total_debit;
    public $total_balance;
    public function __construct($view,$array_to_send, $full_name, $prev_amount, $prev_amount_date,$total_credit,$total_debit,$total_balance )
    {
        $this->view = $view;
        $this->array_to_send = $array_to_send;
        $this->full_name = $full_name;
        $this->prev_amount = $prev_amount;
        $this->prev_amount_date = $prev_amount_date;
        $this->total_credit = $total_credit;
        $this->total_debit = $total_debit;
        $this->total_balance = $total_balance;


    }

    public function view(): View
    {

        return view($this->view)->with('array_to_send', $this->array_to_send)
                                ->with('full_name',$this->full_name)
                                ->with('prev_amount_date',$this->prev_amount_date)
                                ->with('prev_amount',$this->prev_amount)
                                ->with('total_credit',$this->total_credit)
                                ->with('total_debit',$this->total_debit)
                                ->with('total_balance',$this->total_balance);
    }
}
