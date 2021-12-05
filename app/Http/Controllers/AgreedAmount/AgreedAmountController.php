<?php

namespace App\Http\Controllers\AgreedAmount;

use App\Model\AgreedAmount;
use App\Model\DiscountName\DiscountName;
use App\Model\LogAfterPpuid\LogAfterPpuid;
use App\Model\Master_steps;
use App\Model\VisaProcess\AssigningAmount;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\VisaProcess\RenewAgreedAmount;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Image;

class AgreedAmountController extends Controller
{
    function __construct()
    {

        $this->middleware('role_or_permission:Admin|Missing_attachment_agreement', ['only' => ['missing_agreed_amount']]);
        $this->middleware('role_or_permission:Admin|AgreedAmount', ['only' => ['index']]);



    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $agreed_amounts = AgreedAmount::whereNotNull('attachment')->where('taken_status','=','0')->get();

        $total_agreed_amount = AgreedAmount::whereNotNull('attachment')->sum('agreed_amount');
        $total_advance_amount = AgreedAmount::whereNotNull('attachment')->sum('advance_amount');
        $total_final_amount = AgreedAmount::whereNotNull('attachment')->sum('final_amount');

//        dd($total_agreed_amount);

        $user = Auth::user();

        $hide_class = "";

        if($user->hasRole(['Admin', 'Accountant'])){
            $hide_class = "";
        }else{
            $hide_class = "hide_cls";
        }

      return  view('admin-panel.agreed_amount.index',compact('hide_class','agreed_amounts','total_agreed_amount','total_advance_amount','total_final_amount'));
    }
    public function renew_agreed_amount(){

        $agreed_amounts = RenewAgreedAmount::where('taken_status','=','0')->get();

        $total_agreed_amount = RenewAgreedAmount::sum('agreed_amount');
        $total_advance_amount = RenewAgreedAmount::sum('advance_amount');
        $total_final_amount = RenewAgreedAmount::sum('final_amount');

//        dd($total_agreed_amount);

        $user = Auth::user();

        $hide_class = "";

        if($user->hasRole(['Admin', 'Accountant'])){
            $hide_class = "";
        }else{
            $hide_class = "hide_cls";
        }

      return  view('admin-panel.agreed_amount.renew_agreed_amount',compact('hide_class','agreed_amounts','total_agreed_amount','total_advance_amount','total_final_amount'));
    }
    public function missing_agreed_amount(){

        $agreed_amounts = AgreedAmount::whereNull('attachment')->orderby('id','desc')->get();



        return  view('admin-panel.agreed_amount.missing_agreed_amount',compact('agreed_amounts'));

    }
    public function render_view_agreement_table(Request  $request){

        if(isset($request->from_date)){
            if($request->request_type=="0"){
                $agreed_amounts = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->get();
                $status = $request->request_type;
            }else{
                $agreed_amounts = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->get();
                $status = $request->request_type;
            }

        }else{

            $agreed_amounts = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->get();
            $status = $request->request_type;
        }


        $view =  view('admin-panel.agreed_amount.render_view_agreement_table',compact('agreed_amounts','status'))->render();
        return response()->json(['html'=>$view]);

    }

    public function render_view_agreement_count_block(Request  $request){

        $total_agreed_amount = 0;
        $total_advance_amount  = 0;
        $total_final_amount = 0;
        $total_discount_amount = 0;
        if(isset($request->from_date)){
            if($request->request_type=="0"){
                $total_agreed_amount = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->sum('agreed_amount');
                $total_advance_amount = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->sum('advance_amount');
                $total_final_amount = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->sum('final_amount');

                $discount_objects = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->get();

                foreach ($discount_objects as $gamer){
                    if($gamer->discount_details!= null){
                        $array_discounts = json_decode($gamer->discount_details,true);
                        $iterate = 0;
                        foreach ($array_discounts["0"]["name"]  as $ab){

                            $total_discount_amount = $total_discount_amount+$array_discounts["0"]["amount"][$iterate];
                            $iterate = $iterate+1;
                        }
                    }
                }



            }else{
                $total_agreed_amount = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->sum('agreed_amount');
                $total_advance_amount = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->sum('advance_amount');
                $total_final_amount = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->sum('final_amount');

                $discount_objects = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->get();

                foreach ($discount_objects as $gamer){
                    if($gamer->discount_details!= null){
                        $array_discounts = json_decode($gamer->discount_details,true);
                        $iterate = 0;
                        foreach ($array_discounts["0"]["name"]  as $ab){
                            echo $ab."(".$array_discounts["0"]["amount"][$iterate].")".",";
                            $total_discount_amount = $total_discount_amount+$array_discounts["0"]["amount"][$iterate];
                            $iterate = $iterate+1;
                        }
                    }
                }


            }

        }else{

            $total_agreed_amount = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->sum('agreed_amount');
            $total_advance_amount = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->sum('advance_amount');
            $total_final_amount = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->sum('final_amount');

            $discount_objects = AgreedAmount::whereNotNull('attachment')->where('taken_status','=',$request->request_type)->get();

            foreach ($discount_objects as $gamer){
                if($gamer->discount_details!= null){
                    $array_discounts = json_decode($gamer->discount_details,true);
                    $iterate = 0;
                    foreach ($array_discounts["0"]["name"]  as $ab){

                        $total_discount_amount = $total_discount_amount+$array_discounts["0"]["amount"][$iterate];
                        $iterate = $iterate+1;
                    }
                }
            }

        }

        $array_to_send = array(
                    'total_agreed_amount' => $total_agreed_amount,
                    'total_advance_amount' => $total_advance_amount,
                    'total_final_amount' => $total_final_amount,
                    'total_discount_amount' => $total_discount_amount,
                );

        return $array_to_send;


    }

    public function save_update_status_taken(Request $request){

        $validator = Validator::make($request->all(), [
            'primary_id_selected' => 'required',
            'select_choice' => 'required',
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $user = Auth::user();

         $agreed_amount = AgreedAmount::find($request->primary_id_selected);
         $agreed_amount->taken_status =  $request->select_choice;
         $agreed_amount->updated_status_time =  Carbon::now();
         $agreed_amount->action_by =  $user->id;
         $agreed_amount->update();

        $message = [
            'message' => "Status has been updated successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);


    }



    public function upload_missing_agreed_amount(Request $request){

        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'primary_id_agreed' => 'required',
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        if (!file_exists('../public/assets/upload/agreed_amount')) {
            mkdir('../public/assets/upload/agreed_amount', 0777, true);
        }

        if(!empty($_FILES['image']['name'])){

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["image"]["tmp_name"], '../public/assets/upload/agreed_amount/' . $file_name);
            $file_path_front = 'assets/upload/agreed_amount/' . $file_name;
        }

         $agreed_amount = AgreedAmount::find($request->primary_id_agreed);
         $agreed_amount->attachment = $file_path_front;
         $agreed_amount->update();

        $message = [
            'message' => "Agreed Amount uploaded successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);



    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $discount_names = DiscountName::orderby('id','desc')->get();
        $master_steps = Master_steps::where('id','!=','1')->get();

        return  view('admin-panel.agreed_amount.create',compact('discount_names','master_steps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'passport_id_selected' => 'required|unique:agreed_amounts,passport_id',
            'agreed_amount' => 'required',
            'final_amount' => 'required',
            'attchemnt' => 'required'
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();

            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $step_amount_now  = $this->check_the_step_amount($request);

        if($step_amount_now!=$request->final_amount){

            $message = [
                'message' => "Step amount is not Equal to Final Amount",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $passport_id = $request->passport_id_selected;
        $advance_amount = 0;
        $json_discount_detail = "";
        if(!empty($request->discount_name) && !empty($request->discount_amount)){

            $array_to_send = [];
//            foreach ($request->discount_amount as $d_amount){
                $data = array(
                    'name' => $request->discount_name,
                    'amount' => $request->discount_amount,
                );
                $array_to_send [] = $data;
//            }
            $json_discount_detail = json_encode($array_to_send);
        }

        if(!empty($request->advance_amount)){
            $advance_amount =  $request->advance_amount;
        }

        if (!file_exists('../public/assets/upload/agreed_amount')) {
            mkdir('../public/assets/upload/agreed_amount', 0777, true);
        }

        if(!empty($_FILES['attchemnt']['name'])){

//            $ext = pathinfo($_FILES['attchemnt']['name'], PATHINFO_EXTENSION);
//            $file_name = time() . "_" . $request->date . '.' . $ext;
//
//            move_uploaded_file($_FILES["attchemnt"]["tmp_name"], '../public/assets/upload/agreed_amount/' . $file_name);
//            $file_path_front = 'assets/upload/agreed_amount/' . $file_name;



            $img = $request->file('attchemnt');
            $file_path_front = 'assets/upload/agreed_amount/' .time() . '.' . $img ->getClientOriginalExtension();

            $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
            });

            Storage::disk("s3")->put($file_path_front, $imageS3->stream());

        }

         $agreed_amount  = new AgreedAmount();
        $agreed_amount->passport_id =  $passport_id;
        $agreed_amount->agreed_amount = $request->agreed_amount;
        $agreed_amount->advance_amount  = $advance_amount;
        if(isset($json_discount_detail)){
            $agreed_amount->discount_details = $json_discount_detail;
        }

        $agreed_amount->final_amount = $request->final_amount;
        $agreed_amount->attachment = $file_path_front;
        if(isset($request->payroll_deduct)){
            $agreed_amount->payroll_deduct_amount = $request->payroll_deduct_amount;
        }

        $agreed_amount->save();
        $last_id = $agreed_amount->id;

         $logAfter = new  LogAfterPpuid();
        $logAfter->log_status_id = 2;
        $logAfter->passport_id = $passport_id;
        $logAfter->save();



    if(!isset($request->payroll_deduct)){

        $counter_amount_step = 0;
        foreach($request->select_amount_step as  $step_amount){
            if(!empty($step_amount) && !empty($request->step_amount[$counter_amount_step])){
                $array_insert = array(
                    'amount' => $request->step_amount[$counter_amount_step],
                    'master_step_id' => $step_amount,
                    'passport_id' => $passport_id,
                    'agreed_amount_id' => $last_id,
                );
                AssigningAmount::create($array_insert);
            }
            $counter_amount_step =  $counter_amount_step+1;
        }

    }


        $message = [
            'message' => "Agreed Amount saved successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);


    }

    function check_the_step_amount($request){

        $totaly_amount = 0;

        foreach ($request->step_amount as $amount){
            $totaly_amount = $totaly_amount+$amount;
        }

        if(isset($request->payroll_deduct)){
            $totaly_amount = $totaly_amount+$request->payroll_deduct_amount;
        }

        return $totaly_amount;
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

    public function render_view_renew_agreement_count_block(Request  $request){

        $total_agreed_amount = 0;
        $total_advance_amount  = 0;
        $total_final_amount = 0;
        $total_discount_amount = 0;
        if(isset($request->from_date)){
            if($request->request_type=="0"){
                $total_agreed_amount = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->sum('agreed_amount');
                $total_advance_amount = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->sum('advance_amount');
                $total_final_amount = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->sum('final_amount');

                $discount_objects = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->get();

                foreach ($discount_objects as $gamer){
                    if($gamer->discount_details!= null){
                        $array_discounts = json_decode($gamer->discount_details,true);
                        $iterate = 0;
                        foreach ($array_discounts["0"]["name"]  as $ab){

                            $total_discount_amount = $total_discount_amount+$array_discounts["0"]["amount"][$iterate];
                            $iterate = $iterate+1;
                        }
                    }
                }



            }else{
                $total_agreed_amount = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->sum('agreed_amount');
                $total_advance_amount = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->sum('advance_amount');
                $total_final_amount = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->sum('final_amount');

                $discount_objects = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->get();

                foreach ($discount_objects as $gamer){
                    if($gamer->discount_details!= null){
                        $array_discounts = json_decode($gamer->discount_details,true);
                        $iterate = 0;
                        foreach ($array_discounts["0"]["name"]  as $ab){
                            echo $ab."(".$array_discounts["0"]["amount"][$iterate].")".",";
                            $total_discount_amount = $total_discount_amount+$array_discounts["0"]["amount"][$iterate];
                            $iterate = $iterate+1;
                        }
                    }
                }


            }

        }else{

            $total_agreed_amount = RenewAgreedAmount::where('taken_status','=',$request->request_type)->sum('agreed_amount');
            $total_advance_amount = RenewAgreedAmount::where('taken_status','=',$request->request_type)->sum('advance_amount');
            $total_final_amount = RenewAgreedAmount::where('taken_status','=',$request->request_type)->sum('final_amount');

            $discount_objects = RenewAgreedAmount::where('taken_status','=',$request->request_type)->get();

            foreach ($discount_objects as $gamer){
                if($gamer->discount_details!= null){
                    $array_discounts = json_decode($gamer->discount_details,true);
                    $iterate = 0;
                    foreach ($array_discounts["0"]["name"]  as $ab){

                        $total_discount_amount = $total_discount_amount+$array_discounts["0"]["amount"][$iterate];
                        $iterate = $iterate+1;
                    }
                }
            }

        }

        $array_to_send = array(
                    'total_agreed_amount' => $total_agreed_amount,
                    'total_advance_amount' => $total_advance_amount,
                    'total_final_amount' => $total_final_amount,
                    'total_discount_amount' => $total_discount_amount,
                );

        return $array_to_send;


    }


    public function render_view_renew_agreement_table(Request  $request){

        if(isset($request->from_date)){
            if($request->request_type=="0"){
                $agreed_amounts = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('created_at', [$request->from_date, $request->end_date." 23:59:59"])->get();
                $status = $request->request_type;
            }else{
                $agreed_amounts = RenewAgreedAmount::where('taken_status','=',$request->request_type)->whereBetween('updated_status_time', [$request->from_date, $request->end_date." 23:59:59"])->get();
                $status = $request->request_type;
            }

        }else{

            $agreed_amounts = RenewAgreedAmount::where('taken_status','=',$request->request_type)->get();
            $status = $request->request_type;
        }


        $view =  view('admin-panel.agreed_amount.render_view_renew_agreement_table',compact('agreed_amounts','status'))->render();
        return response()->json(['html'=>$view]);

    }

    public function save_update_renew_status_taken(Request $request){

        $validator = Validator::make($request->all(), [
            'primary_id_selected' => 'required',
            'select_choice' => 'required',
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $user = Auth::user();

         $agreed_amount = RenewAgreedAmount::find($request->primary_id_selected);
         $agreed_amount->taken_status =  $request->select_choice;
         $agreed_amount->updated_status_time =  Carbon::now();
         $agreed_amount->action_by =  $user->id;
         $agreed_amount->update();

        $message = [
            'message' => "Status has been updated successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);


    }
}
