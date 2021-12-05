<?php

namespace App\Http\Controllers;

use App\Model\Bike_invoice;
use App\Model\InvParts;
use App\Model\Manage_bike_purchase;
use App\Model\Parts;
use App\Model\ReturnPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    
    {
         $invoice=$request->get('invoice');


        $res=DB::table('manage_bike_purchases')->where('invoice_number', $invoice)->first();
        if ($res==null)
        {
            $message = [
                'message' => 'No data for the invoice',
                'alert-type' => 'error'
            ];
//            $manage_purchase = Bike_invoice::all()->toArray();
//            return view('admin-panel.pages.manage_purchase',compact('manage_purchase'))->with($message);
           return redirect()->back()->with($message);
        }
        //

//        $inv=DB::table('return_purchases')->where('invoice_no',$invoice)->get();

//        $invoice = Manage_bike_purchase::where('invoice_number',$invoice_number)->get();
        $inv=ReturnPurchase::where('invoice_no',$invoice)->get();

        $parts=Parts::all();
        $parts_inv=InvParts::all();
        return view('admin-panel.pages.return_purchase',compact('parts_inv','parts','invoice','inv'));


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
//updaeting here

        $part_no = $request->get('part_number');
        $insert_qty = $request->get('part_qty');
        $id = $request->get('qty_id');
        $invoice = $request->get('invoice_no');



        $result = DB::table('return_purchases')->where('id', $id)->first();
        $return_qty = $result->qty;

        $res1 = DB::table('inv_parts')->where('parts_id', $part_no)->first();
        $inv_qty = $res1->quantity;
        $inv_qty_balance = $res1->quantity_balance;




        $res = DB::table('manage_bike_purchases')->where('part_number', $part_no)->where('invoice_number',$invoice)->first();


        $qty = $res->part_qty;
        $qty_balance = $res->part_qty_balance;



        //battle field :)

        $new_qty = $insert_qty - $return_qty;
        $new_qty1 = $insert_qty - $inv_qty_balance;

//        $purchase_new_qty = $insert_qty - $return_qty;
//        $purchase_new_qty1 = $insert_qty - $inv_qty_balance;


        if ($new_qty > $qty_balance) {
            $message = [
                'message' => 'Quntity is not sufficient',
                'alert-type' => 'error'
            ];

            return redirect()->route('manage_purchase')->with($message);

        }

        if ($new_qty < 1){

            $actual_qty = $inv_qty - $new_qty;
          $actual_qty2=$inv_qty_balance-$new_qty;

          $actual_qty_purchase = $qty - $new_qty;
          $actual_qty2_purchase=$qty_balance-$new_qty;



//
//dd($actual_qty);

//updating "inv_parts" table with return purchase
            DB::table('inv_parts')->where('parts_id', $part_no)
                ->update(['quantity' => $actual_qty,
                    'quantity_balance' => $actual_qty2,

                    ]);

 //updating "manage_bike_purchases" table with return purchase
            DB::table('manage_bike_purchases')
                ->where('part_number', $part_no)
                ->where('invoice_number', $invoice)
                ->update(['part_qty' => $actual_qty_purchase,
            'part_qty_balance' => $actual_qty2_purchase,
                ]);

         DB::table('return_purchases')->where('id', $id)->update(['qty' => $insert_qty]);



            $message = [
                'message' => 'Quntity Updated Successfully',
                'alert-type' => 'success'
            ];




//            $inv=DB::table('return_purchases')->where('invoice_no',$invoice)->get();
            $inv=ReturnPurchase::where('invoice_no',$invoice)->get();
            $parts=Parts::all();
            $parts_inv=InvParts::all();
            return view('admin-panel.pages.return_purchase',compact('parts_inv','parts','invoice','inv'));


    }

        else{
            $actual_qty = $inv_qty - $new_qty;
            $actual_qty2=$inv_qty_balance-$new_qty;


            $actual_qty_purchase = $qty - $new_qty;
            $actual_qty2_purchase=$qty_balance-$new_qty;



            DB::table('inv_parts')->where('parts_id', $part_no)
                ->update(['quantity' => $actual_qty,
                    'quantity_balance' => $actual_qty2

                    ]);
            DB::table('return_purchases')->where('id', $id)->update(['qty' => $insert_qty]);

            DB::table('manage_bike_purchases')->where('part_number', $part_no)
                ->where('invoice_number', $invoice)
                ->update([
                    'part_qty_balance' => $actual_qty2_purchase,
                    'part_qty' => $actual_qty_purchase,
                ]);

            $message = [
                'message' => 'Quntity Updated Successfully',
                'alert-type' => 'success'
            ];
        }
        $inv=ReturnPurchase::where('invoice_no',$invoice)->get();

        $parts=Parts::all();
        $parts_inv=InvParts::all();
        return view('admin-panel.pages.return_purchase',compact('parts_inv','parts','invoice','inv'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //

        $insert_qty = $request->get('insert_qty');
        $id = $request->get('id');
        $part_number = $request->get('part_number');




        $parts=Parts::all();
        $parts_inv=InvParts::all();
        $edit_inv_data=ReturnPurchase::find($id);

        $inv_parts_data = InvParts ::where('parts_id','=',$part_number)->first();


        return view('admin-panel.pages.return_purchase',compact('edit_inv_data','parts','parts_inv','inv_parts_data','insert_qty'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $part_no = $request->get('part_number');
        $insert_qty = $request->get('part_qty');
        $invoice = $request->get('invoice_no');

//store into return purchase table
//        $result = InvParts::where('parts_id', $part_no)->first();
        $result = DB::table('manage_bike_purchases')->where('part_number', $part_no)->where('invoice_number',$invoice)->first();

        if ($result == null) {
            $message = [
                'message' => 'Part is not available in Invoice',
                'alert-type' => 'error'
            ];

            return redirect()->route('manage_purchase')->with($message);
        }
        $current_qty = $result->part_qty;
        $current_qty_balance=$result->part_qty_balance;
        $return_qty = $current_qty - $insert_qty;
        $return_qty_balance=$current_qty_balance-$insert_qty;


        $actual_qty2=$current_qty-$insert_qty;
        $actual_qty_balance2=$current_qty_balance-$insert_qty;



//dd($insert_qty);

        if ( $insert_qty > $current_qty_balance ) {
            $message = [
                'message' => 'Quntity is not sufficient',
                'alert-type' => 'error'
            ];

            return redirect()->route('manage_purchase')->with($message);

        }

//       dd($return_qty);
        if ($return_qty < 0) {
            $message = [
                'message' => 'Quntity is not sufficient',
                'alert-type' => 'error'
            ];

            return redirect()->route('manage_purchase')->with($message);

        }




        else {

//            update new inv_parts table here
            $res = DB::table('inv_parts')->where('parts_id',$part_no)->first();

            $c_qty= $res->quantity;
            $c_qty_balance=$res->quantity_balance;

            $actual_qty=$c_qty-$insert_qty;
            $actual_qty_balance=$c_qty_balance-$insert_qty;
//            dd($actual_qty);

               //Updates the quantity inside inv_parts
           DB::table('inv_parts')->where('parts_id', $part_no)->update(['quantity' =>$actual_qty,
               'quantity_balance' =>$actual_qty_balance]);
//update purchases table also
            DB::table('manage_bike_purchases')->where('part_number', $part_no)->where('invoice_number',$invoice)
                ->update([
                    'part_qty_balance' =>$actual_qty_balance2,
                     'part_qty' =>$actual_qty2]);


            $message = [
                'message' => 'Quntity Reduced Successfully',
                'alert-type' => 'success'

            ];

            $return_data = new ReturnPurchase([
                'part_number'    =>  $request->get('part_number'),
                'qty'     =>  $request->get('part_qty'),
                'invoice_no' => $request->get('invoice_no'),
            ]);
            $return_data->save();
//            $parts=Parts::all();
//            $parts_inv=InvParts::all();
//             $inv=DB::table('return_purchases')->where('invoice_no',$invoice)->get();

//            return redirect()->route('return_purchase',compact('inv','parts','parts_inv','insert_qty'));

//           return view('admin-panel.pages.return_purchase',compact('inv','parts','parts_inv','insert_qty'));

//            $parts=Parts::all();
//            $parts_inv=InvParts::all();

            $inv=ReturnPurchase::where('invoice_no',$invoice)->get();

            $parts=Parts::all();
            $parts_inv=InvParts::all();
            return view('admin-panel.pages.return_purchase',compact('parts_inv','parts','invoice','inv'));


//            return redirect()->route('manage_purchase')->with($message);
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


        //
        //if delete, Add deleted quantity back
        //tak
//       $part_id=$request->get('part_id');
//       $qty_input=$request->get('insert_qty');
//       $part_no=$request->get('part_number');

        $result=DB::table('return_purchases')->where('id', $id)->first();
        $part_id=$result->id;
        $qty_input=$result->qty;
        $part_no=$result->part_number;
        $invoice=$result->invoice_no;

//        dd($part_no);
       //------Delete Return Purchase-------------------------
        $obj = ReturnPurchase::find($id);
        $obj->delete();
        //-------------------------------------------------------

        $res=DB::table('inv_parts')->where('parts_id', $part_no)->first();

        $qty=$res->quantity;
        $qty_balance=$res->quantity_balance;
        $final_qty=$qty+$qty_input;
        $final_qty_balance=$qty_balance+$qty_input;
//--------------------------------------------------------------------------------------------------

        $obj=DB::table('manage_bike_purchases')->where('part_number', $part_no)->where('invoice_number', $invoice)->first();

        $purhcase_qty=$obj->part_qty;
        $purchase_qty_balance=$obj->part_qty_balance;
        $purhcase_final_qty_balance=$purchase_qty_balance+$qty_input;
        $purhcase_final_qty = $purhcase_qty + $qty_input;



        DB::table('inv_parts')->where('parts_id', $part_no)->update(['quantity' =>$final_qty,
        'quantity_balance' =>$final_qty_balance]);

        DB::table('manage_bike_purchases')->where('part_number', $part_no)->where('invoice_number', $invoice)
            ->update([
                'part_qty_balance' =>$purhcase_final_qty_balance,
                'part_qty' =>$purhcase_final_qty
            ]);

        $message = [
            'message' => 'Return Purchase Deleted Successfully',
            'alert-type' => 'success'
        ];


        $inv=ReturnPurchase::where('invoice_no',$invoice)->get();

        $parts=Parts::all();
        $parts_inv=InvParts::all();
        return view('admin-panel.pages.return_purchase',compact('parts_inv','parts','invoice','inv'));



//        $manage_purchase = Bike_invoice::all()->toArray();
//           return view('admin-panel.pages.manage_purchase',compact('manage_purchase'))->with($message);
//        return back()->with($message);
//        $parts=Parts::all();
//        $parts_inv=InvParts::all();
//      return view('admin-panel.pages.return_purchase',compact('parts_inv','parts','invoice_no','inv'));
//        return redirect()->back()->with($message);


    }
}
