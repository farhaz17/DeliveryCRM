<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Parts;
use App\Model\Price\CurrentPrice;
use App\Model\Repair\RepairSale;
use App\Notifications\Notifications\InventoryVerifyNotification;
use App\User;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class InventoryControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $inv_request= RepairSale::all();




        return view('admin-panel.maintenance.inventory_controller.index',compact('inv_request'));
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function get_inv_parts(Request $request){
        $id=$request->id;
        $parts_datas = RepairSale::find($id)->data	;
        $gamer_array =  array();
        $json = json_decode($parts_datas);
        $sn_count = 1;
            foreach($json as $obj){
                $gamer = array(
                    'repair_sale_id' =>$id,
                    'id' =>$obj->id,
                    'part_id' =>$obj->part_id,
                    'sn' =>$sn_count,
                    'part_name' =>$this->getPartName($obj->part_id),
                    'part_no' => $this->getPartNo($obj->part_id),
                    'qty' =>$obj->qty,
                    'qty_verified' =>$obj->qty_verified,
                    'qty_return' =>$obj->qty_return,
                    'compnay_own'=> $obj->company_or_own=='0'?"Own":"Company",
                    'comments'=> $obj->comments,

            );
            $gamer_array[] = $gamer;
            }
            $view = view("admin-panel.maintenance.inventory_controller.ajax_files.get_parts_detail",compact('gamer_array'))->render();
            return response()->json(['html'=>$view]);
    }


    public function get_inv_parts2(Request $request){

        $id=$request->input('repair_id');
        $parts_datas = RepairSale::find($id)->data	;
        $gamer_array =  array();
        $json = json_decode($parts_datas);
        $sn_count = 1;
            foreach($json as $obj){
                $gamer = array(
                    'repair_sale_id' =>$id,
                    'id' =>$obj->id,
                    'part_id' =>$obj->part_id,
                    'sn' =>$sn_count,
                    'part_name' =>$this->getPartName($obj->part_id),
                    'part_no' => $this->getPartNo($obj->part_id),
                    'qty' =>$obj->qty,
                    'qty_verified' =>$obj->qty_verified,
                    'qty_return' =>$obj->qty_return,
                    'compnay_own'=> $obj->company_or_own=='0'?"Own":"Company",
                    'comments'=> $obj->comments,

            );
            $gamer_array[] = $gamer;
            }
            $view = view("admin-panel.maintenance.inventory_controller.ajax_files.get_parts_detail",compact('gamer_array'))->render();
            return response()->json(['html'=>$view]);
    }
    public function create()
    {
        //
    }
    public function get_qty($id){
        $values = RepairSale::find($id)->data;
        $gamer_array =  array();
        $json = json_decode($values);


        foreach($json as $obj){
                $gamer = array(
                    'id' =>$obj->id,
                    'part_id' =>$obj->part_id,
                    'compnay_own'=> $obj->company_or_own,
                    'comments'=> $obj->comments,
                    'qty' =>$obj->qty,
                    'qty_verified' =>$request->qty,
                    'verify_status' =>$obj->verify_status
            );

            $gamer_array[] = $gamer;

    }
        return $gamer_array;
    }


    public function very_inv(Request $request)
    {
        $gamer_input =  array();
        for ($i = 0; $i < count($request->input('part_id')); $i++){
            if( $request->input('qty_verified')[$i]==null){
                $qty_verified="";
                $status_verified="0";
            }
            else{
                $qty_verified=$request->input('qty_verified')[$i];
                $status_verified="1";
            }
            $current_price_table= CurrentPrice::where('part_id',$request->input('part_id')[$i])->first();
                    $current_price=$current_price_table->price;
            $gamer2 = array(
                        'id' =>$request->input('key')[$i],
                        'part_id' =>$request->input('part_id')[$i],
                        'company_or_own'=> $request->input('company_or_own')[$i],
                        'comments'=> $request->input('comments')[$i],
                        'qty' =>$request->input('qty_orignal')[$i],
                        'qty_verified' =>$qty_verified,
                        'qty_return' =>'0',
                        'price' => $current_price,
                        'verify_status' =>$status_verified
        );
        $gamer_input[] = $gamer2;
        }
    $objects= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($gamer_input), JSON_FORCE_OBJECT));
    $json="[".$objects."]";
    $object =RepairSale::find($request->input('repair_sale_id'));
    $object->data = $json;
    $object->inv_status = '1';
    $object->save();
    $users= User::select('*')
    ->where('major_department_ids', 'LIKE', '%1%')
    ->get();
    foreach($users as $user){
        $user->notify(new InventoryVerifyNotification($object));
    }
    $options = array(
        'cluster' => 'ap2',
        'encrypted' => true
    );
    $pusher = new Pusher(
        '794af290dd47b56e7bc9',
        'b4a3ae91a9b3a7a83d06',
        '949714',
        $options
    );


    $message= "New Repair Parts Request Verified";

    $pusher->trigger('notify', 'notify-parts-ver', $message);
    }


    public function get_return_parts(Request $request){


            $id=$request->row_id;
            $key=$request->json_data_id;
            $return_qty=$request->return_qty;


            $values = RepairSale::find($id)->data;


            $gamer_array =  array();
            $json = json_decode($values);


                foreach($json as $obj){
                    $gamer = array(
                        'id' =>$obj->id,
                        'part_id' =>$obj->part_id,
                        'company_or_own'=> $obj->company_or_own,
                        'comments'=> $obj->comments,
                        'qty' =>$obj->qty,
                        'qty_verified' =>$obj->qty_verified,
                        'qty_return' =>$obj->qty_return,
                        'price' =>$obj->price,
                        'verify_status' =>$obj->verify_status,
                );
                $gamer_array[] = $gamer;
                }
                foreach ($gamer_array as $obj){
                    $id=$obj['id'];
                    $part_id=$obj['part_id'];
                    $company_or_own=$obj['company_or_own'];
                    $comments=$obj['comments'];
                    $qty=$obj['qty'];
                    $qty_verified=$obj['qty_verified'];
                    $qty_return=$obj['qty_return'];
                    $price=$obj['price'];
                    $verify_status=$obj['verify_status'];
                    if($return_qty > $qty){
                        return response()->json([
                            'code' => "101"
                        ]);
                    }
                 if($obj['id']==$key){
                    $qty_return=$return_qty;
                }
                $gamer2 = array([
                    'id' =>$id,
                    'part_id' =>$part_id,
                    'company_or_own'=> $company_or_own,
                    'comments'=> $comments,
                    'qty' =>$qty,
                    'qty_verified' =>$qty_verified,
                    'qty_return' =>$qty_return,
                    'price' =>$price,
                    'verify_status' =>$verify_status,
         ]);
         $items[] = $gamer2;
                }
        $objects= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($items), JSON_FORCE_OBJECT));
        $json="[".$objects."]";

        $object =RepairSale::find($request->input('row_id'));
        $object->data = $json;
        $object->save();
            return response()->json([
                'code' => "100"
            ]);
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
