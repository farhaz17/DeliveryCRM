<?php

namespace App\Http\Controllers;

use App\Bike;
use App\Model\Assign\AssignBike;
use App\Model\BikeDetail;
use App\Model\ManageRepair;
use App\Model\Parts;
use App\Model\Passport\Passport;
use App\Model\Price\CurrentPrice;
use App\Model\Repair\RepairCheckups;
use App\Model\Repair\RepairPayments;
use App\Model\Repair\RepairSale;
use App\Model\RepairUsedParts;
use App\Model\RiderProfile;
use App\Notifications\Notifications\InventoryControllerNotifications;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class ManageRepairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manage_repairs=ManageRepair::all();
        $bikes=BikeDetail::all();
        $parts=Parts::all();
        $price=CurrentPrice::where('status','0')->pluck('part_id')->toArray();


        $entry_no = IdGenerator::generate(['table' => 'manage_repairs', 'field' => 'repair_no',  'length' => 6, 'prefix' => 'EN']);
        return view('admin-panel.maintenance.repair.index',compact('manage_repairs','bikes','parts','entry_no','price'));
    }

    public function rapair_view()
    {
        //
        $manage_repairs=ManageRepair::all();
        $bikes=BikeDetail::all();




        $view = view("admin-panel.maintenance.repair.repair_ajax_files.repairs_table",compact('manage_repairs','bikes'))->render();
        return response()->json(['html' => $view]);


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

    public function get_rider_repair_detail(Request $request){
        $plate_id=$request->plate_id;
        $bike_assign=AssignBike::where('bike',$plate_id)->where('status','1')->first();
       if($bike_assign!=null){
        $passport_id=$bike_assign->passport_id;
        $rider_data=Passport::where('id',$passport_id)->first();
       }
       else{
           $rider_data='1';
       }


        // dd($rider_data->personal_info->full_name);
        $view = view("admin-panel.maintenance.repair.repair_ajax_files.rider_detail_ajax",compact('rider_data'))->render();
            return response()->json(['html' => $view]);


    }



    public function repair_pos(){

        $manage_repair=ManageRepair::all();
        $parts=Parts::all();


        return view('admin-panel.maintenance.repair.repair_pos',compact('manage_repair','parts'));
    }




    public function get_pos_product(Request $request){
        $id=$request->id;
        $qty=$request->qty;

        $parts=Parts::where('id',$id)->first();

        $view = view('admin-panel.maintenance.repair.repair_ajax_files.get_pos_parts',compact('parts','qty'))->render();
        return response()->json(['html' => $view]);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


            // if($request->name==null){
            //     $name_status='0';
            // }
            // else{
            //     $name_status='1';
            // }



            // $repair_no = IdGenerator::generate(['table' => 'manage_repairs', 'field' => 'repair_no', 'length' => 7, 'prefix' => 'RE-1']);




            $obj=new ManageRepair();
            $obj->bike_id=$request->input('bike_id');
            $obj->repair_no=$request->input('repair_no');
            $obj->rider_passport_id=$request->input('passport_id');
            $obj->type=$request->input('type');
            $obj->priorty=$request->input('priorty');
            $obj->priorty=$request->input('priorty');
            $obj->duration=$request->input('duration');
            $obj->status='0';
            $obj->save();

            // $message = [
            //     'message' => 'Repair mode is on',
            //     'alert-type' => 'success'

            // ];
            // return redirect()->route('manage_repair')->with($message);

            $manage_repairs=ManageRepair::all();
            $bikes=BikeDetail::all();
            return response()->json([
                'code' => "100"
            ]);


            // $view = view("admin-panel.maintenance.repair.repair_ajax_files.repairs_table",compact('manage_repairs','bikes'))->render();
            // return response()->json(['html' => $view]);



    }

    public function storeParts(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manage_repair_data=ManageRepair::find($id);
        $manage_repairs=ManageRepair::all();
        $bikes=Bike::all();

        return view('admin-panel.pages.manage_repair',compact('manage_repair_data','manage_repairs','bikes'));
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

            $obj = ManageRepair::find($id);
            $obj->chassis_no=$request->input('chassis_no_id');
            $obj->zds_code=$request->input('zds_code');
            $obj->name=$request->input('name');
            $obj->ckm=$request->input('ckm');
            $obj->nkm=$request->input('nkm');
            $obj->discount=$request->input('discount');
            $obj->company=$request->input('company')=="on"?1:0;
            $obj->save();

            $message = [
                'message' => 'Repair mode Updated',
                'alert-type' => 'success'

            ];
            return redirect()->route('manage_repair')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('manage_repair')->with($message);
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
            $obj = ManageRepair::find($id);
            $obj->delete();
            $message = [
                'message' => 'Repair job Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('manage_repair')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('manage_repair')->with($message);
        }
    }



    public function pdfInvoice($id){

                $repair_sale = RepairSale::where('manage_repair_id',$id)->first();
                $values = RepairSale::find($id)->data;
                $bike_no=$repair_sale->manage_repair->bike->plate_no;
                $chassis_no=$repair_sale->manage_repair->bike->chassis_no;
                $json = json_decode($values);
                $sn_count=1;
                $total=0;


                foreach($json as $obj){
                $final_qty= $obj->qty_verified-$obj->qty_return;
                $gamer = array(
                    'sn' =>$sn_count,
                    'part_name' =>$this->getPartName($obj->part_id),
                    'part_no' => $this->getPartNo($obj->part_id),
                    'qty' => $final_qty,
                    'price' => $obj->price,
                    'total'=>$final_qty*$obj->price,


            );
            $subtotal=$final_qty*$obj->price;
            $total=$total+$subtotal;
            $gamer_array[] = $gamer;
            $sn_count++;
        }

     
        $pdf = PDF::loadView('admin-panel.pdf.invoice_pdf', compact('gamer_array','total','grand_total','bike_no','chassis_no'))
        ->setPaper('a4', 'portrait');
    $pdf->getDomPDF()->set_option("enable_php", true);
    return $pdf->stream('invoice.pdf');
    }

    public function parts_request($id){
        $manage_repair=ManageRepair::all();
        $parts=Parts::all();
        $manageRepair=ManageRepair::find($id);
        $bike_detail=BikeDetail::where('id', $manageRepair->bike_id)->first();

        $bike_no=$bike_detail->plate_no;
        $chassis_no=$bike_detail->chassis_no;
        $repair_id=$id;

        return view('admin-panel.maintenance.repair.repair_pos',compact('manage_repair','parts','chassis_no','bike_no','repair_id'));

    }

    public function repair_sale_save(Request $request){

        $manage_repair_id = $request->input('repair_id_manage_repair');
        $repair_sale_table= RepairSale::where('manage_repair_id',$manage_repair_id)->first();
        $manage_repair_table= ManageRepair::where('id',$manage_repair_id)->first();
        $entry_no = $manage_repair_table->repair_no;
        $current_price= CurrentPrice::where('part_id',$manage_repair_id)->first();

        if($repair_sale_table != null){
            $id=$repair_sale_table->id;
            $values = RepairSale::find($id)->data;
            $json_arr = json_decode($values, true);



            foreach ($json_arr as $obj){
                $last_id=$obj['id'];
            }


            for ($i = 0; $i < count($request->input('parts_id')); $i++){
                $current_price_table= CurrentPrice::where('part_id',$request->input('parts_id')[$i])->first();
                $current_price=$current_price_table->price;

                $gamer = array(
                    'id' => $last_id+1,
                    'part_id' => $request->input('parts_id')[$i],
                    'company_or_own' => $request->input('radio')[$i],
                    'comments' => $request->input('comments')[$i],
                    'qty' => $request->input('qty')[$i],
                    'qty_verified' => '',
                    'qty_return' => '0',
                    'price' => $current_price,
                    'verify_status' => '0',
            );
            $json_arr[] = $gamer;
            }
            $json_str = json_encode($json_arr);
                $object =RepairSale::find($id);
                $object->data = $json_str;


                $object->save();

                $users= User::select('*')
                ->where('major_department_ids', 'LIKE', '%1%')
                ->get();

                foreach($users as $user){
                    $user->notify(new InventoryControllerNotifications($object));
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

            $message= "this is the notification";

                $pusher->trigger('notify', 'notify-event', $message);

                return response()->json([
                    'code' => "100"
                ]);
        }

        else{
                $items = array();
                for ($i = 0; $i < count($request->input('parts_id')); $i++){
                    $current_price_table= CurrentPrice::where('part_id',$request->input('parts_id')[$i])->first();
                    $current_price=$current_price_table->price;

                    // echo"2nd";
                // dd($current_price);
                    $gamer = array([
                        'id' => $i+1,
                        'part_id' => $request->input('parts_id')[$i],
                        'company_or_own' => $request->input('radio')[$i],
                        'comments' => $request->input('comments')[$i],
                        'qty' => $request->input('qty')[$i],
                        'qty_verified' => '',
                        'qty_return' => '0',
                        'price' => $current_price,
                        'verify_status' => '0',
                ]);
                $items[] = $gamer;
                }
                $objects= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($items), JSON_FORCE_OBJECT));
                $json="[".$objects."]";

                // dd($json);


                $obj = new RepairSale();
                $obj->manage_repair_id = $request->input('repair_id_manage_repair');
                $obj->data =$json;
                $obj->status = '0';
                $obj->entry_no = $entry_no;
                $obj->save();
                $users= User::select('*')
                ->where('major_department_ids', 'LIKE', '%1%')
                ->get();

                foreach($users as $user){
                    $user->notify(new InventoryControllerNotifications($obj));
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

            $message= "this is the notification";

                $pusher->trigger('notify', 'notify-event', $message);

                    return response()->json([
                        'code' => "100"
                    ]);

                    } //else ends here
    }



    public function repair_sale_payment(Request $request){

        $obj = new RepairPayments();

        $obj->repair_id = $request->repair_id;
        $obj->total_item = $request->total_items;
        $obj->total_amount = $request->total_amount;
        $obj->discount = $request->discount;
        $obj->paid_by = $request->paid_by;
        $obj->note = $request->note;
        $obj->added_by = $request->added_by;
        $obj->added_by = '0';
        $obj->status = '0';
        $obj->save();


        $repair_sale = RepairSale::find($obj->repair_id);
        $repair_payment = RepairPayments::where('id',$obj->id)->first();
        $reppair_sale_detail = RepairSale::where('id',$obj->repair_id)->first();
        $repair_sale_data = RepairSale::find($obj->repair_id)->data;


        $json = json_decode($repair_sale_data);

        $gamer_array =  array();
        $total=0;
        foreach($json as $obj)
        {
            $gamer=array(
                'part_name' =>$this->getPartName($obj->part_id),
                'qty' =>$obj->qty,
                'price' =>$obj->price,
                'sub_total'=>$obj->qty*$obj->price,
            );
            $subtotal=$obj->qty*$obj->price;
            $total=$total+$subtotal;
            $gamer_array[] = $gamer;

        }


        $discount=$repair_payment->discount;
        $grand_total=$total-$discount;
        $bike_no=$reppair_sale_detail->manage_repair->bike->plate_no;





        return view('admin-panel.maintenance.repair.repair_payment',compact('gamer_array','total','grand_total','discount','bike_no'));


        }


        public function getPartName($job_id){
            $part_name = Parts::select('part_name')
                ->where('id', $job_id)
                ->first();
            return $part_name->part_name;
        }

        public function show_repairs(){

            $repair_sales= RepairSale::all();


            return view('admin-panel.maintenance.repair.show_repairs_parts',compact('repair_sale'));

        }

        public function get_repair_sale_detail(Request $request){


            $id=$request->id;
            $repair_sale = RepairSale::where('manage_repair_id',$id)->first();
            $repair_payment = RepairPayments::where('repair_id',$repair_sale->id)->first();
            $reppair_sale_detail = RepairSale::where('manage_repair_id',$id)->first();

            $repair_sale_data = RepairSale::find($reppair_sale_detail->id)->data;

            $json = json_decode($repair_sale_data);

            $gamer_array =  array();
            $total=0;
            foreach($json as $obj)
            {
                $gamer=array(
                    'part_name' =>$this->getPartName($obj->part_id),
                    'qty' =>$obj->qty,
                    'price' =>$obj->price,
                    'sub_total'=>$obj->qty*$obj->price,
                );
                $subtotal=$obj->qty*$obj->price;
                $total=$total+$subtotal;
                $gamer_array[] = $gamer;

            }


            $discount=$repair_payment->discount;
            $grand_total=$total-$discount;
            $bike_no=$reppair_sale_detail->manage_repair->bike->plate_no;






            $view = view("admin-panel.maintenance.repair.repair_ajax_files.ajax_manage_repairs_parts_detail"
            ,compact('gamer_array','total','grand_total','discount','bike_no'))->render();
            return response()->json(['html' => $view]);
        }

        public function get_add_form(Request $request){

            $bike_id=$request->bike_id;
            $personal_detail=AssignBike::where('bike',$bike_id)->where('status','1')->first();
            if($personal_detail==null){
                $null_val='0';

                $view = view("admin-panel.maintenance.repair.repair_ajax_files.get_add",compact('null_val'))->render();
                return response()->json(['html' => $view]);
            }else{
                $null_val='1';
                $checkin=$personal_detail->checkin;
                $passport=Passport::where('id',$personal_detail->passport_id)->first();
                $RiderProfile=RiderProfile::where('passport_id',$personal_detail->passport_id)->first();
                $image=$RiderProfile->image;
                $bike_info= BikeDetail::where('id',$bike_id)->first();
                $view = view("admin-panel.maintenance.repair.repair_ajax_files.get_add",compact('bike_info','passport','checkin','image','null_val'))->render();
                return response()->json(['html' => $view]);
            }

        }

        public function save_repair_checkup(Request $request){

            $manage_repair_id = $request->input('repair_id_checkup');
            $repair_sale_table= RepairCheckups::where('manage_repair_id',$manage_repair_id)->first();


            if(!empty($repair_sale_table)){
                $id=$repair_sale_table->id;
                $values = RepairCheckups::find($id)->checkup_points;
                $json_arr = json_decode($values, true);

                foreach ($json_arr as $obj){
                    $last_id=$obj['no'];
                }


                for ($i = 0; $i < count($request->input('checkup_points')); $i++){
                    $gamer = array(
                        'no' => $last_id+1,
                        'checkup_points' => $request->input('checkup_points')[$i],
                );
                $json_arr[] = $gamer;

                    }

                    $json_str = json_encode($json_arr);
                    $obj = RepairCheckups::find($id);
                    $obj->checkup_points = $json_str;
                    $obj->save();
                    return response()->json([
                        'code' => "102"
                    ]);
            }
            else{


                $items = array();
                $count=1;
                for ($i = 0; $i < count($request->input('checkup_points')); $i++){
                    $gamer = array([
                        'no' => $count,
                        'checkup_points' => $request->input('checkup_points')[$i],
                ]);
                $items[] = $gamer;
                $count++;
                }
                $objects= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($items), JSON_FORCE_OBJECT));
                $json="[".$objects."]";
                $obj = new RepairCheckups();

                $obj->manage_repair_id =$request->repair_id_checkup;
                $obj->checkup_points = $json;
                $obj->remarks =$request->remarks;
                $obj->days_hours =$request->days_hours;
                $obj->status ='0';
                $obj->save();
                return response()->json([
                    'code' => "100"
                ]);

            }//else ends here
        }

        public function get_repair_checkup_detail(){
            $checkup_detail=RepairCheckups::all();
        $view = view("admin-panel.maintenance.repair.repair_ajax_files.get_checkup_detail",compact('checkup_detail'))->render();
        return response()->json(['html' => $view]);


        }


        public function get_repair_manage_detail(){
            $manage_parts=RepairSale::get();
        $view = view("admin-panel.maintenance.repair.repair_ajax_files.get_manage_parts_detail",compact('manage_parts'))->render();
        return response()->json(['html' => $view]);


        }


         public function get_checkup_points(Request $request){
            $id=$request->id;
            $checkup_datas = RepairCheckups::find($id)->checkup_points;
            $gamer_array =  array();
            $json = json_decode($checkup_datas);
                foreach($json as $obj){
                    $gamer = array(
                        'id' =>$id,
                        'sn' =>$obj->no,
                        'point'=> $obj->checkup_points,
                );
                $gamer_array[] = $gamer;
                }

                $view = view("admin-panel.maintenance.repair.repair_ajax_files.checkup_points",compact('gamer_array'))->render();
                return response()->json(['html'=>$view]);
         }


         public function get_manage_parts(Request $request){
            $id=$request->id;
            $parts_datas = RepairSale::find($id)->data	;
            $gamer_array =  array();
            $json = json_decode($parts_datas);
            $sn_count = 1;

                foreach($json as $obj){
                    $gamer = array(
                        'sn' =>$sn_count,
                        'part_name' =>$this->getPartName($obj->part_id),
                        'part_no' => $this->getPartNo($obj->part_id),
                        'qty' => $obj->qty,
                        'price' => $obj->price,
                        'qty_verified' => $obj->qty_verified==''?"N/A":$obj->qty_verified,
                        'qty_return' => $obj->qty_return==''?"N/A":$obj->qty_return,
                        'compnay_own'=> $obj->company_or_own=='0'?"Own":"Company",
                        'comments'=> $obj->comments,
                        'verify_status'=> $obj->verify_status,
                        'id'=> $obj->id,
                        'repair_sale_id'=> $id,
                );
                $gamer_array[] = $gamer;
                $sn_count++;
                }


                $view = view("admin-panel.maintenance.repair.repair_ajax_files.get_parts_json_data",compact('gamer_array'))->render();
                return response()->json(['html'=>$view]);
         }



        public function getPartNo($job_id){
            $part_name = Parts::select('part_number')
                ->where('id', $job_id)
                ->first();
            return $part_name->part_number;
        }

        public function get_repair_id(Request $request){

            $obj = RepairCheckups::where('manage_repair_id',$request->repair_id)->first();

            if($obj==null){
                return response()->json([
                    'code' => "100"
                ]);
            }
            elseif($obj->status==1 || $obj->status==0){
                return response()->json([
                    'code' => "102"
                ]);

            }
            else{
                return response()->json([
                    'code' => "101"
                ]);
            }


        }


        public function get_manage_repar_id(Request $request){

            $obj = RepairSale::where('manage_repair_id',$request->repair_id)->first();

            if($obj==null){
                return response()->json([
                    'code' => "100"
                ]);
            }
             elseif($obj->status==1 || $obj->status==0){
                return response()->json([
                    'code' => "102"
                ]);
            }
            else{
                return response()->json([
                    'code' => "101"
                ]);
            }


        }


        public function checkup_points_update(Request $request){
            $id=$request->checkup_id;
            $new_point=$request->new_point;
            $key=$request->key;
            $values = RepairCheckups::find($id)->checkup_points	;
            $gamer_array =  array();
            $json = json_decode($values);
                foreach($json as $obj){
                    $gamer = array(
                        'sn' =>$obj->no,
                        'checkup_points'=> $obj->checkup_points,
                );
                $gamer_array[] = $gamer;
                }
                foreach ($gamer_array as $obj){
                    $no=$obj['sn'];
                 $check_point= $obj['checkup_points'];
                 if($obj['sn']==$key){
                    $check_point=$new_point;
                }
                $gamer2 = array([
                 'no' => $no,
                 'checkup_points' => $check_point,
         ]);
         $items[] = $gamer2;
                }
        $objects= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($items), JSON_FORCE_OBJECT));
        $json="[".$objects."]";
        $object =RepairCheckups::find($id);
        $object->checkup_points = $json;
        $object->save();

        }

  public function start_manage_repair(Request $request){
      $id= $request->repair_id;



    //   $object =RepairSale::find($id);
      $object =RepairSale::where('manage_repair_id',$id)->first();
      $object2 =RepairCheckups::where('manage_repair_id',$id)->first();

      if($object==null){
        return response()->json([
            'code' => "102"
        ]);
      }
        $status=$object->status;


        if($status=='1'){
            return response()->json([
                'code' => "101"
            ]);

        }
        else{
            $object->status = '1';
            $object->save();


            return response()->json([
                'code' => "100"
            ]);
        }
  }
  public function complete_manage_repair(Request $request){
    $id= $request->repair_id;


    $object =RepairSale::where('manage_repair_id',$id)->first();
    $object2 =RepairCheckups::where('manage_repair_id',$id)->first();

      if($object==null){
        return response()->json([
            'code' => "102"
        ]);
      }

      $status=$object->status;
      if($status=='2'){
          return response()->json([
              'code' => "101"
          ]);

      }
      elseif($status=='0'){
        return response()->json([
            'code' => "103"
        ]);

    }
      else{
          $object->status = '2';
          $object->save();

          $object2->status = '2';
          $object2->save();
          return response()->json([
              'code' => "100"
          ]);
      }
}



            public function rapair_invoice_view(){

                //get the all repair sale data and show to view

                    $manage_parts = RepairSale::where('status','2')->get();
                    $view = view("admin-panel.maintenance.repair.invoice_ajax.get_all_repairs",compact('manage_parts'))->render();
                    return response()->json(['html'=>$view]);

            }








}
