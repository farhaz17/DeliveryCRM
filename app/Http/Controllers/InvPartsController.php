<?php

namespace App\Http\Controllers;

use App\Model\InvParts;
use App\Model\Maintenance\PartsHistory;
use App\Model\Parts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InvPartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parts=Parts::all();
        $parts_inv=InvParts::all();
        return view('admin-panel.pages.inv_parts',compact('parts','parts_inv'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try{

            $data_partnumber=$this->checkExistData($request->input('part_id'));

            if($data_partnumber == ""){

                $obj=new InvParts();
                $obj->parts_id=$request->input('part_id');
                $obj->quantity=$request->input('quantity');
                $obj->quantity_balance=$request->input('quantity');
                $obj->price=$request->input('price');
                $obj->save();

                $object=new PartsHistory();
                $object->part_id=$request->input('part_id');
                $object->qty=$request->input('quantity');
                $object->price=$request->input('price');
                $object->status='0';
                $object->save();
                $message = [
                    'message' => 'Inventory Parts Added Successfully',
                    'alert-type' => 'success'

                ];
                return redirect()->route('inv_parts')->with($message);
            }
            else{

                $partDataId = $this->getInventoryDataId($request->input('part_id'));
                $quantitySet=$this->getQuantityBalance($partDataId);
                $current_quantity=0;
                $current_quantity_balance=0;

                foreach ($quantitySet as $item) {
                    $current_quantity+=$item->quantity;
                    $current_quantity_balance+=$item->quantity_balance ;
                }
                $actual_quantity_balance = ($request->input('quantity')) + $current_quantity_balance;
                $actual_quantity = ($request->input('quantity'))+ $current_quantity ;

                $obj = InvParts::find($partDataId);
                $obj->parts_id=$request->input('part_id');
//            $obj->part_add_name=$request->input('part_add_name');
                $obj->quantity=$actual_quantity;
                $obj->quantity_balance=$actual_quantity_balance;
                $obj->price=$request->input('price');
                $obj->save();




                $object=new PartsHistory();
                $object->part_id=$request->input('part_id');
                $object->qty=$actual_quantity;
                $object->price=$request->input('price');
                $object->status='1';
                $object->save();



                $message = [
                    'message' => 'Inventory Parts Updated Successfully',
                    'alert-type' => 'success'

                ];
                return redirect()->route('inv_parts')->with($message);



            }

        }
        // catch (\Illuminate\Database\QueryException $e){
        //     $message = [
        //         'message' => 'Error Occured',
        //         'alert-type' => 'error'
        //     ];
        //     return redirect()->route('inv_parts')->with($message);
        // }
    // }

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
    public function edit($id)
    {
        $inv_parts_data=InvParts::find($id);
        $parts=Parts::all();
        $parts_inv=InvParts::all();
        return view('admin-panel.pages.inv_parts',compact('inv_parts_data','parts','parts_inv'));
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
        try {
            $quantitySet=$this->getQuantityBalance($id);
            $current_quantity=0;
            $current_quantity_balance=0;


            foreach ($quantitySet as $item) {
                $current_quantity+=$item->quantity ;
                $current_quantity_balance+=$item->quantity_balance ;
            }



                $actual_quantity_balance = ($request->input('quantity'))- $current_quantity + $current_quantity_balance;
            if($actual_quantity_balance >=0){
//            dd($current_quantity_balance);

                $obj = InvParts::find($id);
                $obj->parts_id=$request->input('part_id');
//            $obj->part_add_name=$request->input('part_add_name');
                $obj->quantity=$request->input('quantity');
                $obj->quantity_balance=$actual_quantity_balance;
                $obj->price=$request->input('price');
                $obj->save();




                if($actual_quantity_balance>$current_quantity_balance){
                    $status='1';
                }
                else{
                    $status='2';
                }

            $object=new PartsHistory();
            $object->part_id=$request->input('part_id');
            $object->qty=$request->input('quantity');
            $object->price=$request->input('price');
            $object->status=$status;
            $object->save();


                $message = [
                    'message' => 'Inventory Parts Updated Successfully',
                    'alert-type' => 'success'

                ];
            }
            else{
                $message = [
                    'message' => 'Parts are not sufficient enough',
                    'alert-type' => 'warning'

                ];
            }
            return redirect()->route('inv_parts')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('inv_parts')->with($message);
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
        try {
            $obj = InvParts::find($id);
            $obj->delete();
            $message = [
                'message' => 'Inventory Parts Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('inv_parts')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('inv_parts')->with($message);
        }
    }


    public function getQuantityBalance($id){
        $quantity_bal = DB::table('inv_parts')->where('id', $id)->get(['quantity','quantity_balance']);
        return $quantity_bal;
    }

    public function checkExistData($part_id)
    {
        $query=InvParts::where('parts_id', $part_id)->get()->first();
        $part_id= isset($query->id)?$query->id:"";
        return $part_id;
    }
    public function getInventoryDataId($part_id){

        $query=InvParts::where('parts_id', $part_id)->get()->first();

        $part_id= isset($query->id)?$query->id:"";
        return $part_id;


    }

//    public function getQuantityForSinglePart($part_number_id){
//        $quantity_bal_for_single_part = DB::table('inv_parts')->where('parts_id', $part_number_id)->get(['quantity_balance'])->sum('quantity_balance');
//        return $quantity_bal_for_single_part;
//    }
}
