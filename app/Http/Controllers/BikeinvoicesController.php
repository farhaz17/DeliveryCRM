<?php

namespace App\Http\Controllers;

use App\Bike;
use App\Model\Bike_invoice;
use App\Model\Manage_bike_invoice;
use App\Model\Manage_bike_purchase;
use App\Model\Manage_parts;
use App\Model\Repair_category;
use Illuminate\Http\Request;
use App\Model\InvParts;
use App\Model\Parts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BikeinvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $part_no=  $request->get('part_number');
        $in=  $request->get('invoice_number');


//check if invoice no is already inserted then update
        // if invoice number is not exist than insert
        $res = DB::table('manage_bike_purchases')
            ->where('invoice_number',$in)
            ->where('part_number',$part_no)->first();

if ($res==null)
{

    $part_qty_balance= $request->get('part_qty');
    $upload_date=date("Y/m/d");


    $obj = new Manage_bike_purchase([
        'part_number'    =>  $request->get('part_number'),
        'invoice_number'    =>  $request->get('invoice_number'),
        'part_name'     =>  $request->get('part_name'),
        'part_des'    =>  $request->get('part_des'),
        'part_qty'    =>  $request->get('part_qty'),
        'part_qty_balance'    =>  $request->get('part_qty'),
        'amount'     =>  $request->get('amount'),
        'vat'    =>  $request->get('vat'),
        'date_created'    =>  $upload_date
    ]);

    $obj->save();

}
else{
    $cqty=$res->part_qty;
    $partq=$request->get('part_qty')+$cqty;
    DB::table('manage_bike_purchases')
        ->where('invoice_number',$in)
        ->where('part_number',$part_no)->
        update(['part_qty'    =>  $partq,
        'part_qty_balance'=>  $partq,
        'amount'=>  $request->get('amount'),

            ]);
//            $object->save();



}
        //final price calculate
        $vat= $request->get('vat');
        $amount= $request->get('amount');
        $vat_amount=$amount*$vat/100;
        $final_price=$amount+$vat_amount;
        $qty_balance= $request->get('part_qty');




         //if else condition here
       $result = DB::table('inv_parts')->where('parts_id',$part_no)->first();



        if (isset($result)) {
            $current_quantity=$result->quantity;
            $current_quantity_balance=$result->quantity_balance;
            $actual_quantity_balance=$request->get('part_qty')+$current_quantity_balance;
            $actual_quantity=$request->get('part_qty')+$current_quantity;


            DB::table('inv_parts')->where('parts_id', $part_no)->update(['parts_id' => $part_no,

                'quantity' => $actual_quantity,
                'quantity_balance'=> $actual_quantity_balance,
                'price' => $final_price]);
//            $object->save();

        }
        else{

            $object2 = new InvParts([
                'parts_id'    =>  $part_no,
//                'part_add_name'     =>  $request->get('part_name'),
                'quantity'    =>  $request->get('part_qty'),
                'quantity_balance'    =>  $qty_balance,
                'price'    =>  $final_price,
             ]);
            $object2->save();

        }




        // store part name, partnumber and invoice number inside parts

        $message = [
            'message' => 'Added Successfully',
            'alert-type' => 'success',
        ];

//        return redirect()->route('invoice')->with($message);
        return back()->with($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idd)
    {
        //


        $edit_invoice_data=Bike_invoice::find($idd);
        $manage_parts=Bike_invoice::all();

        $edit_inv_data=Manage_bike_purchase::find($idd);

if ($edit_inv_data==null){


    $message = [
        'message' => 'Deleted Successfully',
        'alert-type' => 'success'

    ];



    $manage_purchase = Bike_invoice::all()->toArray();
    return redirect()->route('manage_purchase')->with('manage_purchase',$manage_purchase)->with($message);
}


        $part_number=$edit_inv_data->part_number;
        $invoice_number=$edit_inv_data->invoice_number;
        $edit_inv=Manage_bike_purchase::where('invoice_number','=',$invoice_number)->get();
         //for parts
        $invoice = Manage_bike_purchase::where('invoice_number','=',$invoice_number)->get();

        $inv_parts_data=  DB::table('inv_parts')->where('parts_id', $part_number)->first();

        $parts=Parts::all();
        $parts_inv=InvParts::all();
        return view('admin-panel.pages.bike_invoice',compact('edit_inv_data','edit_inv','parts_inv','parts','invoice','edit_invoice_data','manage_parts','inv_parts_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    //
    try {
//            $current_qty= $request->get('part_qty');
        $qtySet=$this->getQuantityBalance($id);
        $current_qty=0;
        $current_qty_balance=0;
        foreach ($qtySet as $item)
        {
            $current_qty=$item->part_qty;
            $current_qty_balance+=$item->part_qty_balance;
        }

//
//        $actual_qty= ($request->get('part_qty'))-$current_qty+$current_qty_balance;
//            dd($actual_qty);


        $obj = Manage_bike_purchase::find($id);

        //get the value from data table,get quantity
        //add quantity with quantity input


        $res = Manage_bike_purchase ::where('id','=',$id)->first();
        $table_qty=$res->part_qty;
        $table_qty_balance=$res->part_qty_balance;
        $input_qty=$request->get('part_qty');

        $temp_qty_bal=$input_qty-$table_qty;
        $final_qty_balnce=$temp_qty_bal+$table_qty_balance;
//        dd($final_qty_balnce);


    if ($final_qty_balnce<0)
    {

        $message = [
            'message' => 'Qutanity cannot be reduced more',
            'alert-type' => 'error'

        ];

        $manage_purchase = Bike_invoice::all()->toArray();
        return redirect()->route('manage_purchase')->with('manage_purchase',$manage_purchase)->with($message);
    }




//dd($actual_qty);



        $obj->part_number = $request->get('part_number');
        $obj->part_name = $request->get('part_name');
        $obj->part_des = $request->get('part_des');
        $obj->part_qty = $request->get('part_qty');
        $obj->part_qty_balance=$final_qty_balnce;
        $obj->amount = $request->get('amount');
        $obj->vat = $request->get('vat');
            $obj->save();



//----------------------For inv_part table------------------------------------------
       $vat= $request->get('vat');
        $amount= $request->get('amount');
        $final_price=$vat+$amount;
        $p_id= $request->get('part_number');
        $object=  DB::table('inv_parts')->where('parts_id', $p_id)->first();
//        $object = InvParts::where('parts_id','=',$p_id)->first();

        $i_qty=$object->quantity;
        $i_qty_balance=$object->quantity_balance;

        //----------------------- battle field-----

        $new_qty = $input_qty - $table_qty;

        if ($new_qty < 1){
            $actual_qty = $i_qty + $new_qty;


            $actual_qty_balance = $i_qty_balance + $new_qty;

            DB::table('inv_parts')->where('parts_id', $p_id)->update(['quantity' => $actual_qty,
                'quantity_balance' => $actual_qty_balance,
                'price'=>$final_price]);



        }


        else{
            $actual_qty = $i_qty + $new_qty;
            $actual_qty_balance = $i_qty_balance + $new_qty;
            DB::table('inv_parts')->where('parts_id', $p_id)->update(['quantity' => $actual_qty,
                'quantity_balance' => $actual_qty_balance,
                'price'=>$final_price]);

        }

        $message = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success'

        ];



        $manage_purchase = Bike_invoice::all()->toArray();
        return redirect()->route('manage_purchase')->with('manage_purchase',$manage_purchase)->with($message);

//        return view('admin-panel.pages.manage_purchase')->with('manage_purchase',$manage_purchase)->with($message);
//        return back()->with($message);

    }
    catch (\Illuminate\Database\QueryException $e) {
        $message = [
            'message' => 'Error Occured',
            'alert-type' => 'error'
        ];
        return back()->with($message);
    }

}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function getQuantityBalance($id)
    {
        $qty_balance = DB::table('manage_bike_purchases')->where('id', $id)->get(['part_qty','part_qty_balance']);
       return $qty_balance;

    }
}
