<?php

namespace App\Http\Controllers;

use App\Model\InvParts;
use App\Model\Parts;
use App\Model\Manage_bike_purchase;
use App\Model\Manage_parts;
use App\Model\Bike_invoice;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ManagepurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $manage_purchase = Bike_invoice::all()->toArray();
        return view('admin-panel.pages.manage_purchase',compact('manage_purchase'));
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
        //
        //
        try {

            $validator = Validator::make($request->all(), [
//                'chasis_no' => 'unique:bikes'.$id
                'invoice_number' => 'unique:bike_invoices,invoice_number,',

            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => 'Invoice number already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('manage_purchase')->with($message);
            }

            $validator1 = Validator::make($request->all(), [
//                'chasis_no' => 'unique:bikes'.$id

                'image_name' => 'mimes:jpeg,png,pdf',
            ]);

            if ($validator1->fails()) {
                $validate1 = $validator1->errors();
                $message = [
                    'message' => 'Only JPEG,PNG and PDF files allowed',
                    'alert-type' => 'error',
                    'error' => $validate1->first()
                ];
                return redirect()->route('manage_purchase')->with($message);
            }


            $img = null;
            if (!empty($_FILES['image_name']['name'])) {
                if (!file_exists('../public/assets/manage_parts_images/')) {
                    mkdir('../public/assets/manage_parts_images/', 0777, true);
                }
                $ext = pathinfo($_FILES['image_name']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["image_name"]["tmp_name"], '../public/assets/manage_parts_images/' . $file_name);
                $img = file_get_contents(asset('assets/manage_parts_images/' . $file_name));

            }

            $path = 'assets/manage_parts_images/' . $file_name;
            $upload_date = date("Y/m/d");

            //take image path and date

            $obj = new Bike_invoice([
                'image_path' => $path,
                'upload_date' => $upload_date,
                'vendor_name' => $request->get('vendor_name'),
                'invoice_number' => $request->get('invoice_number'),
            ]);
            $obj->save();

            $message = [
                'message' => 'Image Added Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('manage_purchase')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('manage_purchase')->with($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $result = Bike_invoice::where('id',$id)->first();
        $manage_purchase = Bike_invoice::all()->toArray();

        return view('admin-panel.pages.manage_purchase',compact('manage_purchase','result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $edit_invoice_data1=Bike_invoice::find($id);
        $manage_parts=Bike_invoice::all();
        $res=Bike_invoice::where('id',$id)->first();
        $invoice_number=$res->invoice_number;



//     select data from 'manage_bike_invoice'



        $edit_inv_data1=Manage_bike_purchase::find($id);
        $edit_inv1=Manage_bike_purchase::all();
        $invoice = Manage_bike_purchase::where('invoice_number',$invoice_number)->get();
        $parts=Parts::all();
        $parts_inv=InvParts::all();




        return view('admin-panel.pages.bike_invoice',compact('edit_invoice_data1','invoice','manage_parts','parts','parts_inv','edit_inv_data1','edit_inv1'));

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
        $obj = Bike_invoice::find($id);
        $obj->vendor_name = $request->get('vendor_name');
        $obj->invoice_number = $request->get('invoice_number');
        $obj->save();

        $message = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];

        $manage_purchase = Bike_invoice::all()->toArray();
        return redirect()->route('manage_purchase',compact('manage_purchase'))->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

//------------Reducing quantity fron 'inv_parts' table---------------
        $obj = Manage_bike_purchase::find($id);
        $part_number=$obj->part_number;
        $qty=$obj->part_qty;
        $qty_balance=$obj->part_qty_balance;


        $invoice=  DB::table('inv_parts')->where('parts_id', $part_number)->first();
//        $invoice = InvParts::where('parts_id','=',$part_number)->first();

        $id2= $invoice->id;
        $quantity=$invoice->quantity;
        $quanitity_balance=$invoice->quantity_balance;

        $actual_qty= $quantity-$qty;
        $actual_qty_balance=$quanitity_balance-$qty_balance;




        DB::table('inv_parts')->where('id', $id2)->update([
            'quantity' => $actual_qty,
            'quantity_balance'=> $actual_qty_balance]);

//------------****--------------------------------------


        try {
            $obj = Manage_bike_purchase::find($id);
            $obj->delete();
            $message = [
                'message' => 'Deleted Successfully',
                'alert-type' => 'success'
            ];

           //Return Back to previous page-----------------------

                return back()->with($message);



        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }






}
