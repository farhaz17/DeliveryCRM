<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Maintenance\Purchase;
use App\Model\Master\CustomerSupplier\CustomerSupplier;
use App\Model\Parts;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Model\InvParts;
use App\Model\Maintenance\PartsHistory;
use App\Model\ReturnPurchase;

class PurhcaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $supplier=CustomerSupplier::get();
        $parts=Parts::get();
        return view('admin-panel.maintenance.purchase.index',compact('supplier','parts'));

    }

    public function purchase_view()
    {
        //
        $purchase=Purchase::get();
        return view('admin-panel.maintenance.purchase.purchase_view',compact('purchase'));

    }

    public function get_purchase_view_table(){

        $purchase=Purchase::get();
        $view = view("admin-panel.maintenance.purchase.purchase_ajax.purchase_view_ajax",compact('purchase'))->render();
        return response()->json(['html' => $view]);
        }

    public function purchase_pdf($id)
    {


        $purchase_detail = Purchase::find($id);
        $purchase_datas = Purchase::find($id)->data;
        $gamer_array =  array();
        $json = json_decode($purchase_datas);
        $sn_count = 1;
        $grand_total = 0;
            foreach($json as $obj){

                $gamer = array(
                    'sn' =>$sn_count,
                    'part_name' =>$this->getPartName($obj->parts),
                    'part_no' => $this->getPartNo($obj->parts),
                    'qty'=> $obj->qty,
                    'price'=> $obj->price,
                    'total'=> $obj->price* $obj->qty,
            );
            $gamer_array[] = $gamer;
            $sn_count++;
            $grand_total=$grand_total+$obj->price* $obj->qty;


            }








        $pdf = PDF::loadView('admin-panel.pdf.maintenance.purchase_pdf',
         compact('purchase_detail','gamer_array','grand_total'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');


    }

    public function getPartName($job_id){
        $part_name = Parts::select('part_name')
            ->where('id', $job_id)
            ->first();
        return $part_name->part_name;
    }

    public function getPartNo($job_id){
        $part_name = Parts::select('part_number')
            ->where('id', $job_id)
            ->first();
        return $part_name->part_number;
    }


    public function verify_purchase(Request $request){

        $id=$request->id;
        $purchase_detail = Purchase::find($id);
        $purchase_datas = Purchase::find($id)->data;
        $gamer_array =  array();
        $json = json_decode($purchase_datas);
        $sn_count = 1;
        $grand_total = 0;
            foreach($json as $obj){

                $gamer = array(
                    'id' =>$obj->parts,
                    'purchase_id' =>$id,
                    'sn' =>$sn_count,
                    'part_name' =>$this->getPartName($obj->parts),
                    'part_no' => $this->getPartNo($obj->parts),
                    'qty'=> $obj->qty,
                    'price'=> $obj->price,
                    'total'=> $obj->price* $obj->qty,
            );
            $gamer_array[] = $gamer;
            $sn_count++;
            $grand_total=$grand_total+$obj->price* $obj->qty;


            }

            $view = view("admin-panel.maintenance.purchase.purchase_ajax.verify_purchase",compact('purchase_detail','gamer_array','grand_total'))->render();
            return response()->json(['html'=>$view]);
    }
    public function very_purchase(Request $request){
        $items = array();


        for ($i = 0; $i < count($request->input('part_id')); $i++){
            $quantitySet=$this->getQuantityBalance($request->input('part_id')[$i]);
            $current_quantity=0;
            $current_quantity_balance=0;
            foreach ($quantitySet as $item) {
                $current_quantity+=$item->quantity ;
                $current_quantity_balance+=$item->quantity_balance ;
            }


            if($current_quantity=='0'){
                $obj=new InvParts();
                $obj->parts_id=$request->input('part_id')[$i];
                $obj->quantity=$request->input('qty')[$i];
                $obj->quantity_balance=$request->input('qty')[$i];
                $obj->price=$request->input('price')[$i];
                $obj->save();


//add purchase history

                $object= new PartsHistory();
                $object->part_id=$request->input('part_id')[$i];
                $object->qty=$request->input('qty')[$i];
                $object->price=$request->input('price')[$i];
                $object->status='0';
                $object->save();


            }
            else{
                $actual_quantity_balance = ($request->input('qty')[$i])+ $current_quantity_balance;
                if($actual_quantity_balance >=0){
                        DB::table('inv_parts')->where('parts_id', $request->input('part_id')[$i])->update([
                            'parts_id' => $request->input('part_id')[$i],
                            'quantity_balance'=> $actual_quantity_balance,
                        ]);
                    }

                    //add purchase history

                $object= new PartsHistory();
                $object->part_id=$request->input('part_id')[$i];
                $object->qty=$request->input('qty')[$i];
                $object->price=$request->input('price')[$i];
                $object->status='0';
                $object->save();
            }
        }

        //change the status to 1 for verified

        DB::table('purchases')->where('id', $request->input('purchase_id'))->update(['status' => '1']);






        $purchase=Purchase::get();
        $view = view("admin-panel.maintenance.purchase.purchase_ajax.purchase_view_ajax",compact('purchase'))->render();
        return response()->json(['html' => $view]);


    }

    public function getQuantityBalance($id){
        $quantity_bal = DB::table('inv_parts')->where('parts_id', $id)->get(['quantity','quantity_balance']);
        return $quantity_bal;
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


    public function return_purchase(Request $request){

//add to return purhase table
            $obj= new ReturnPurchase();
            $obj->invoice_no=$request->input('id');
            $obj->save();
            $return_id=$request->input('id');
            // substract from invventory


            $purchase=Purchase::where('id',$request->id)->first();
            $verify_status=$purchase->status;

            if($verify_status=='1'){
                $parts_history=PartsHistory::where('purhcase_id',$return_id)->get();



                foreach($parts_history as $row){
                    $quantitySet=$this->getQuantityBalance($row->part_id);
                    $current_quantity=0;
                    $current_quantity_balance=0;
                    foreach ($quantitySet as $item) {
                        $current_quantity+=$item->quantity ;
                        $current_quantity_balance+=$item->quantity_balance ;
                    }

                    $new_qty=$current_quantity_balance-$row->qty;

                    //substract from the the inventory
                      DB::table('inv_parts')->where('parts_id', $row->part_id)
                      ->update(['quantity_balance' => $new_qty]);

//updates parts history status to 3 means this part was returned
                      DB::table('parts_histories')->where('id', $row->id)->update(['status' => '3']);


                    //end parts foreach history
                }

    // //add return status to purchases


            }
            DB::table('purchases')->where('id', $request->input('id'))->update(['return_status' => '1']);






            $purchase=Purchase::get();
            $view = view("admin-panel.maintenance.purchase.purchase_ajax.purchase_view_ajax",compact('purchase'))->render();
            return response()->json(['html' => $view]);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//     public function insertData (Request $request) {
//         foreach($request->detailedHistory as $data)
//          {
//            $row = new YourModel();
//            $row ->column_name1 = $data['DetailedHistoryItem']['date'];
//            $row ->column_name2 = $data['DetailedHistoryItem']['source'];
//            // and so on for your all columns
//            $row->save();   //at last save into db
//          }

//    }

    public function store(Request $request)
    {


        $purchase_no = IdGenerator::generate(['table' => 'purchases', 'field' => 'purchase_no', 'length' => 7, 'prefix' => 'PR-1']);
        $supplier=$request->input('supplier');

        $items = array();
        for ($i = 0; $i < count($request->input('parts')); $i++){
            $gamer = array([
                'parts' => $request->input('parts')[$i],
                'qty' => $request->input('qty')[$i],
                'price' => $request->input('price')[$i]
        ]);
        $items[] = $gamer;

        }

        $objects= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($items), JSON_FORCE_OBJECT));
        $json="[".$objects."]";


            $obj = new Purchase();
            $obj->purchase_no = $purchase_no;
            $obj->supplier = $supplier;
            $obj->data =$json;
            $obj->save();

            $message = [
                'message' => 'Purhcase Added Successfully',
                'alert-type' => 'success',

            ];
            return redirect()->back()->with($message);
        }


    //


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

    public function return_purchase_view(){

        $purchase=Purchase::where('return_status','1')->get();

        return view('admin-panel.maintenance.purchase.return_purchase_view',compact('purchase'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }
}
