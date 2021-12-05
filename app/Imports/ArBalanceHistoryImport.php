<?php

namespace App\Imports;

use App\Model\ArBalance\ArBalanceSheet;
use App\Model\ArBalance\SalaryPaymentHistroy;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArBalanceHistoryImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function  __construct($date_from,$date_to)
    {


        $this->date_from = $date_from;
        $this->date_to = $date_to;

    }
    public function model(array $row)
    {

//        try {


//getting date ragnes



        $unix_date = $row['on_board']; //here is that value 41621 or 41631
        $unix_date2 = $row['off_board'];


//dd($unix_date);


//        $unix_date = ($excel_date - 25569) * 86400;
//        $excel_date = 25569 + ($unix_date / 86400);
//        $unix_date = ($excel_date - 25569) * 86400;
//
//        $excel_date2 = $row['off_board'];; //here is that value 41621 or 41631
//        $unix_date2 = ($excel_date2 - 25569) * 86400;
//        $excel_date2 = 25569 + ($unix_date2 / 86400);
//        $unix_date2 = ($excel_date2 - 25569) * 86400;

        $on_board = date("Y-m-d", strtotime($unix_date));
        $off_board = date("Y-m-d", strtotime($unix_date2));
//
//        $on_board=gmdate("Y-m-d", $unix_date);
//        $off_board=gmdate("Y-m-d", $unix_date2);
//        dd($on_board);


        $date_from = $this->date_from;
        $date_to = $this->date_to;
        $platform_id_name=trim($row['platform']);
        $platform_id_array = trim($row['platform_id']);
        $zds_code_array = $row['zds_code'];
        $name_array = trim($row['name']);
        $prebal_value = $row['prebal'];
        $gross_pay_array = $row['gross_pay'];
        $add_array = $row['add'];
        $penalty_return_array = $row['penalty_return'];
        $adjustment_array = $row['adjustment'];
        $bike_rent_array = $row['bike_rent'];
        $sim_charge_array = $row['sim_charge'];
        $salikarray = $row['salik'];
        $fine_array = $row['fine'];
        $tadvance_array = $row['advance'];
        $ifuel_array = $row['fuel'];
        $loss_damaget_array = $row['loss_damage'];
        $cod_penalty_array = $row['cod_penalty'];
        $platform_penalty_array = $row['platform_penalty'];
        $hours_deduction_array = $row['hours_deduction'];
        $loan_deduction_array = $row['loan_deduction'];
        $tsim_excess_array = $row['sim_excess'];
        $others_array = $row['others'];
        $sub_array = $row['sub'];
        $net_payment_array = $row['net_payment'];
        $tamount_paid_array = $row['amount_paid'];
        $tbalance_array = $row['balance'];
        $match_array = $row['match_substract'];

        if ($prebal_value=='0'){
            $prebal_array='0.0';
        }
        else{
            $prebal_array=$prebal_value;
        }


        if ($prebal_array != null) {
            $this->getData_prebal_array($prebal_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }

        if ($gross_pay_array != null) {
            $this->getData_gross_pay_array($gross_pay_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }

        if ($add_array != null) {
            $this->getData_add_array($add_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($penalty_return_array != null) {
            $this->getData_penalty_return_array($penalty_return_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($adjustment_array != null) {
            $this->getData_adjustment_array($adjustment_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }

        if ($bike_rent_array != null) {
            $this->getData_bike_rent_array($bike_rent_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($sim_charge_array != null) {
            $this->getData_sim_charge_array($sim_charge_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($salikarray != null) {
            $this->getData_salikarray($salikarray, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($fine_array != null) {
            $this->getData_fine_array($fine_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($tadvance_array != null) {
            $this->getData_tadvance_array($tadvance_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($ifuel_array != null) {
            $this->getData_ifuel_array($ifuel_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($loss_damaget_array != null) {
            $this->getData_loss_damaget_array($loss_damaget_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($cod_penalty_array != null) {
            $this->getData_cod_penalty_array($cod_penalty_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($platform_penalty_array != null) {
            $this->getData_platform_penalty_array($platform_penalty_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($hours_deduction_array != null) {
            $this->getData_hours_deduction_array($hours_deduction_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($loan_deduction_array != null) {
            $this->getData_loan_deduction_array($loan_deduction_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($tsim_excess_array != null) {
            $this->getData_tsim_excess_array($tsim_excess_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($others_array != null) {
            $this->getData_others_array($others_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($sub_array != null) {
            $this->getData_sub_array($sub_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }
        if ($match_array != null) {
            $this->getData_sub_array($match_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board);
        }

    }




        public function getData_prebal_array($prebal_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($prebal_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '1';
            $gamer->amount = $prebal_array;
            $gamer->status = '0';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_gross_pay_array($gross_pay_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($gross_pay_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '2';
            $gamer->amount = $gross_pay_array;
            $gamer->status = '0';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_add_array($add_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($add_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '3';
            $gamer->amount = $add_array;
            $gamer->status = '0';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_penalty_return_array($penalty_return_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($penalty_return_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '4';
            $gamer->amount = $penalty_return_array;
            $gamer->status = '0';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }
    public function getData_adjustment_array($adjustment_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($adjustment_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '5';
            $gamer->amount = $adjustment_array;
            $gamer->status = '0';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }
    public function getData_bike_rent_array($bike_rent_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($bike_rent_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '6';
            $gamer->amount = $bike_rent_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_salikarray($salikarray, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($salikarray != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '7';
            $gamer->amount = $salikarray;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }    public function getData_sim_charge_array($salikarray, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($salikarray != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '8';
            $gamer->amount = $salikarray;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_fine_array($fine_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($fine_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '9';
            $gamer->amount = $fine_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_tadvance_array($tadvance_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($tadvance_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '10';
            $gamer->amount = $tadvance_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }
    public function getData_ifuel_array($ifuel_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($ifuel_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '11';
            $gamer->amount = $ifuel_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }
    public function getData_loss_damaget_array($loss_damaget_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($loss_damaget_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '12';
            $gamer->amount = $loss_damaget_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_cod_penalty_array($cod_penalty_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($cod_penalty_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '13';
            $gamer->amount = $cod_penalty_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_platform_penalty_array($platform_penalty_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($platform_penalty_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '14';
            $gamer->amount = $platform_penalty_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }
    public function getData_hours_deduction_array($hours_deduction_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($hours_deduction_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '15';
            $gamer->amount = $hours_deduction_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }
    public function getData_loan_deduction_array($loan_deduction_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($loan_deduction_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '16';
            $gamer->amount = $loan_deduction_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_tsim_excess_array($tsim_excess_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($tsim_excess_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '17';
            $gamer->amount = $tsim_excess_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }
    public function getData_others_array($others_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($others_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '18';
            $gamer->amount = $others_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_sub_array($sub_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($sub_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '19';
            $gamer->amount = $sub_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_match_array($match_array, $platform_id_array, $zds_code_array, $name_array, $platform_id_name, $date_from, $date_to,$net_payment_array,$tamount_paid_array,$tbalance_array,$on_board,$off_board)
    {
        if ($match_array != null) {
            $gamer = new SalaryPaymentHistroy();
            $gamer->platform_id = $platform_id_array;
            $gamer->platform_id_name = $platform_id_name;
            $gamer->zds_code = $zds_code_array;
            $gamer->name = $name_array;
            $gamer->on_board = $on_board;
            $gamer->off_board = $off_board;
            $gamer->date_from = $date_from;
            $gamer->date_to = $date_to;
            $gamer->balance_type = '20';
            $gamer->amount = $match_array;
            $gamer->status = '1';
            $gamer->net_payment = $net_payment_array;
            $gamer->amount_paid = $tamount_paid_array;
            $gamer->balance = $tbalance_array;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }








//
//                return new SalaryPaymentHistroy([
//
//                    'platform_id' => $platform_id_array,
//                    'platform_id_name' => $platform_id_name,
//                    'date_from' => $date_from,
//                    'date_to' => $date_to,
//                    'zds_code' => $zds_code_array,
//                    'name' => $name_array,
//                    'prebal' => $prebal_array,
//                    'gross_pay' =>     $gross_pay_array,
//                    'add' => $add_array,
//                    'penalty_return' => $penalty_return_array,
//                    'adjustment' => $adjustment_array,
//                    'bike_rent' => $bike_rent_array,
//                    'sim_charge' => $sim_charge_array,
//                    'salik' => $salikarray,
//                    'fine' => $fine_array,
//                    'advance' => $tadvance_array,
//                    'fuel' => $ifuel_array,
//                    'loss_damage' => $loss_damaget_array,
//                    'cod_penalty' => $cod_penalty_array,
//                    'platform_penalty' => $platform_penalty_array,
//                    'hours_deduction' => $hours_deduction_array,
//                    'loan_deduction' => $loan_deduction_array,
//                    'sim_excess' => $tsim_excess_array,
//                    'others' => $others_array,
//                    'sub' => $sub_array,
//                    'net_payment' => $net_payment_array,
//                    'amount_paid' => $tamount_paid_array,
//                    'balance' => $tbalance_array,
//                ]);

//        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
//            $message = [
//                'error' => $e->getMessage()
//            ];
//            return redirect()->back()->with($message);
//        }





}
