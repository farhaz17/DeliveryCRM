<?php

namespace App\Http\Controllers\VehicleReport;

use Carbon\Carbon;
use App\Model\Cities;
use App\Model\Platform;
use App\Model\BikeCencel;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Model\Lpo\BikeMissing;
use App\Model\Assign\AssignBike;
use App\Model\Passport\Passport;
use App\Model\BoxInstall\BoxBatch;
use App\Http\Controllers\Controller;
use App\Model\BoxInstall\FoodPermit;
use Illuminate\Support\Facades\Auth;
use App\Model\Boxinstall\BikeRenewal;
use Illuminate\Support\Facades\Storage;
use App\Model\BoxInstall\BoxInstallation;
use Illuminate\Support\Facades\Validator;
use App\Model\VehicleAccident\VehicleAccident;
use App\Model\BikeImpounding\BikeImpoundingUpload;

class VehicleReportController extends Controller
{
    public function vehicle_report()
    {
       $vehicles = BikeDetail::with(
            'model_info:id,name',
            'category:id,name',
            'get_current_bike:id,passport_id,bike,status',
            'sub_category:id,name',
            'get_current_bike.passport:id',
            'get_current_bike.passport.personal_info:id,passport_id,full_name,personal_mob',
            'get_current_bike.passport.rider_sim_assign.telecome:id,account_number',
            'get_current_bike.passport.zds_code:id,passport_id,zds_code',
            'get_current_bike.passport.check_platform_code_exist',
            'get_current_bike.plateforms:id,passport_id,plateform',
            'get_current_bike.plateforms.plateformdetail:id,name',
            'get_current_bike.plateforms.platform_codes:id,platform_code,passport_id',
            'get_current_bike.passport.rider_dc_detail.user_detail:id,name',
            'bike_tracking:id,bike_id,tracking_number',
            'bike_tracking.tracker:id,tracking_no,status',
            'traffic:id,company_id,traffic_for,traffic_file_no',
            'traffic.company:id,name',
            'traffic.customer_supplier_info:id,contact_name',
            'insurances:id,name',
            'current_box',
            'food_permit',
            'food_permit.city:id,name',
            'salik_tag.salik:id,tag_no'
            )->get();
        return view('admin-panel.reports.vehicle_report.vehicle_report',compact('vehicles'));
    }

    public function box_install_request()
    {
        $user = Auth::user();
        $installed =BoxInstallation::whereNotIn('status',[3,7])->pluck('bike_id')->toArray();
        if($user->hasRole(['DC_roll'])){
            $bikes =BikeDetail::with('get_current_bike.plateforms.plateformdetail')->whereHas('get_current_bike.passport.dc_detail', function($q) use($user) {
                $q->where('user_id','=', $user->id);
            })->where('status','=',1)->whereNotIn('id',$installed)->get();
        }elseif($user->hasRole(['Admin'])){
            $bikes =BikeDetail::with('get_current_bike.plateforms.plateformdetail')->where('status','=',1)->whereNotIn('id',$installed)->get();
        }
        return view('admin-panel.box.dc_request',compact('bikes'));
    }

    public function get_bike_details(Request $request)
    {
        return $details = BikeDetail::with('get_current_bike.plateforms.plateformdetail')->where('id',$request->id)->where('status',1)->get();
    }

    public function save_box_request_dc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
        ]);

        foreach($request->details as $key => $value) {
            if(isset($request->details[$key]['bike_ids']) && isset($request->details[$key]['platform_id'])) {
                $abc = new BoxInstallation();
                $abc->bike_id = $request->details[$key]['bike_ids'];
                $abc->platform = $request->details[$key]['platform_id'];
                $abc->user_id = Auth::user()->id;
                $abc->status = 1;
                $abc->save();
            }
        }

        $message = [
            'message' => 'Request Sent Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);
    }

    public function dc_box_install_requests()
    {
        $bikes = BoxInstallation::with('bikes','platformdetail')->where('status',1)->get();
        $rejects = BoxInstallation::with('bikes','platformdetail')->where('status',3)->get();
        return view('admin-panel.box.dc_requests_box',compact('bikes','rejects'));
    }

    public function box_request_rta()
    {
        $installed =BoxInstallation::whereNotIn('status',[3,7])->pluck('bike_id')->toArray();
        $bikes =BikeDetail::whereNotIn('id',$installed)->get(['id','plate_no','status']);
        $platforms =Platform::all();
        return view('admin-panel.box.box_request_rta',compact('bikes','platforms'));
    }

    public function save_box_request_rta(Request $request)
    {
        $abc = new BoxInstallation();
        $abc->bike_id = $request->bike;
        $abc->platform = $request->platform;
        $abc->user_id = Auth::user()->id;
        $abc->status = 2;
        $abc->save();

        $message = [
            'message' => 'Request Sent Successfully',
            'alert-type' => 'success',

        ];
        return redirect()->back()->with($message);
    }

    public function box_requests()
    {
        $platforms = Platform::all();
        $bikes = BoxInstallation::with('bikes','platformdetail')->where('status',2)->get();
        $sent_to_install = BoxInstallation::with('bikes','platformdetail')->where('status',4)->get();
        $sended = BoxInstallation::with('bikes','platformdetail')->where('status',5)->get();
        $installed = BoxInstallation::with('bikes','platformdetail')->where('status',6)->get();
        return view('admin-panel.box.box_requests',compact('bikes','sent_to_install','platforms','sended','installed'));
    }

    public function accept_box_request(Request $request)
    {
        if($request->type == 1){
            $abc = BoxInstallation::find($request->id);
            $abc->status = 2;
            $abc->save();

            $message = [
                'message' => 'Accepted Successfully',
                'alert-type' => 'success',
            ];
        }elseif($request->type == 2){
            $abc = BoxInstallation::find($request->id);
            $abc->status = 3;
            $abc->save();

            $message = [
                'message' => 'Rejected Successfully',
                'alert-type' => 'success',
            ];
        }
        return redirect()->back()->with($message);
    }

    public function box_process()
    {
        $platforms = Platform::all();
        $bikes = BikeDetail::get(['id','plate_no']);
        return view('admin-panel.box.box_proccess',compact('bikes','platforms'));
    }

    public function box_process_details(Request $request)
    {
        $bike = $request->bike;
        $bikes = BoxInstallation::where('bike_id',$bike)->whereNotIn('status',[3,7])->first();
        $removed = BoxInstallation::where('bike_id',$bike)->where('status','=','7')->get();
        $pending = BoxInstallation::where('bike_id',$bike)->where('status','=','1')->get();
        if($bikes != null && (count($pending) == 0)){
            $view = view('admin-panel.box.box_process_details',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }elseif($bikes == null && (count($removed) != 0)){
            $bikes = 'removed';
            $view = view('admin-panel.box.box_process_details',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }elseif($bikes != null && (count($pending) != 0)){
            $bikes = 'pending';
            $view = view('admin-panel.box.box_process_details',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }else{
            $bikes = 'empty';
            $view = view('admin-panel.box.box_process_details',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function box_process_details_ajax(Request $request)
    {
        $bike = $request->bike;
        $bikes = BoxInstallation::where('bike_id',$bike)->whereNotIn('status',[3,7])->first();
        $removed = BoxInstallation::where('bike_id',$bike)->where('status','=','7')->get();
        $pending = BoxInstallation::where('bike_id',$bike)->where('status','=','1')->get();
        if($bikes != null && (count($pending) == 0)){
            $view = view('admin-panel.box.ajax_process_detail_box',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }elseif($bikes == null && (count($removed) != 0)){
            $bikes = 'removed';
            $view = view('admin-panel.box.ajax_process_detail_box',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }elseif($bikes != null && (count($pending) != 0)){
            $bikes = 'pending';
            $view = view('admin-panel.box.ajax_process_detail_box',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }else{
            $bikes = 'empty';
            $view = view('admin-panel.box.ajax_process_detail_box',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }
    }



    public function box_upload_documents(Request $request)
    {
        if($request->hasfile('documents'))
        {
            foreach($request->file('documents') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/box_documents/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }

        $abc = BoxInstallation::find($request->id);
        $abc->remark = $request->remarks;
        $abc->doc_date = $request->date;
        $abc->doc_uploaded_by = Auth::user()->id;
        $abc->status = 4;
        if(isset($data)){
            $abc->documents = json_encode($data);
        }
        $abc->save();

        return response()->json(['code' => "100",'id'=>$abc->bike_id]);
    }

    public function create_batch()
    {
        $platforms = Platform::all();
        $batchs = BoxBatch::all();
        return view('admin-panel.box.create_batch',compact('platforms','batchs'));
    }

    public function reference_number(Request $request)
    {
        if($request->ajax()){
            $platform = $request->id;
            $batches = BoxBatch::where('platform_id','=',$platform)->count();
            $now_platform = Platform::find($platform);
            $upper_case = strtoupper($now_platform->short_code);
            $referenc_number = $upper_case."-"."BOX"."-".($batches+1);
            return $referenc_number;
       }
    }

    public function save_box_batch(Request $request)
    {
        $obj = new BoxBatch();
        $obj->platform_id = $request->platform;
        $obj->reference_number = $request->reference_number;
        $obj->date = $request->date_time;
        $obj->location = $request->location;
        $obj->bike_quantity = $request->quantity;
        $obj->save();

        $message = [
            'message' => 'Created Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);
    }

    public function get_box_batchs(Request $request)
    {
        $batchs = BoxBatch::where('platform_id',$request->platform_id)->get();
        return $batchs;
    }

    public function get_batch_details(Request $request)
    {
        $batch = BoxBatch::where('id',$request->id)->first();
        $array = array(
            'platform' =>  $batch->platform->name,
            'date' =>  $batch->date,
            'location' =>  $batch->location,
            'quantity' =>  $batch->bike_quantity,
        );
        return $array;
    }

    public function send_bike_to_install(Request $request)
    {
        $date = Carbon::now()->toDateString();
        $checkbox_vals = explode(",",$request->arrays);

        foreach($checkbox_vals as $bike){
            $abc = BoxInstallation::find($bike);
            $abc->status = 5;
            $abc->batch_id = $request->batch_id;
            $abc->sended_date = $date;
            $abc->save();
        }
        $message = [
            'message' => 'Bike Sented To Installation successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function ajax_send_bike_to_install(Request $request)
    {
        $date = Carbon::now()->toDateString();
        $abc = BoxInstallation::find($request->arrays);
        $abc->status = 5;
        $abc->batch_id = $request->batch_id;
        $abc->sended_date = $date;
        $abc->save();

        return response()->json(['code' => "100",'id'=>$abc->bike_id]);
    }

    public function upload_box_image(Request $request)
    {
        if($request->hasfile('image'))
        {
            foreach($request->file('image') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/box_image/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $abc = BoxInstallation::find($request->id);
        $abc->status = 6;
        $abc->img_date = $request->date;
        $abc->img_remark = $request->remarks;
        if(isset($data)){
            $abc->box_image = json_encode($data);
        }
        $abc->save();

        return response()->json(['code' => "100",'id'=>$abc->bike_id]);
    }

    public function get_box_document_details(Request $request)
    {
        $box = BoxInstallation::find($request->id);
        $view = view('admin-panel.box.document_details',compact('box'))->render();
        return response()->json(['html' => $view]);
    }

    public function get_box_image(Request $request)
    {
        $box = BoxInstallation::find($request->id);
        $view = view('admin-panel.box.box_image',compact('box'))->render();
        return response()->json(['html' => $view]);
    }

    public function get_box_bike_details(Request $request)
    {
        $box = BoxInstallation::find($request->id);
        $view = view('admin-panel.box.box_batch_details',compact('box'))->render();
        return response()->json(['html' => $view]);
    }

    public function get_box_platform(Request $request)
    {
        $platform = BoxInstallation::find($request->id);
        $ids = $platform->platform;
        return response()->json(['id' => $ids]);
    }

    public function update_box_documents(Request $request)
    {
        if($request->hasfile('documents'))
        {
            foreach($request->file('documents') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/box_documents/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $box = BoxInstallation::find($request->id);
        $box->doc_date = $request->date;
        $box->remark = $request->remarks;
        if(isset($data)){
            $box->documents = json_encode($data);
        }
        $box->save();

        return response()->json(['code' => "100",'id'=>$box->bike_id]);
    }

    public function update_box_image(Request $request)
    {
        if($request->hasfile('image'))
        {
            foreach($request->file('image') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/box_image/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $abc = BoxInstallation::find($request->id);
        $abc->img_date = $request->date;
        $abc->img_remark = $request->remarks;
        if(isset($data)){
            $abc->box_image = json_encode($data);
        }
        $abc->save();

        return response()->json(['code' => "100",'id'=>$abc->bike_id]);
    }

    public function box_removal()
    {
        $bikes = BoxInstallation::where('status',6)->get();
        return view('admin-panel.box.box_removal',compact('bikes'));
    }

    public function get_current_box(Request $request)
    {
        $box = BoxInstallation::find($request->id);
        return $box->platformdetail->name;
    }

    public function save_box_removal(Request $request)
    {
        $obj = BoxInstallation::find($request->bike);
        $obj->status = 7;
        $obj->remove_date = $request->date;
        $obj->remove_remark = $request->remark;
        $obj->removed_by = Auth::user()->id;
        $obj->save();

        $message = [
            'message' => 'Box Removed successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function removed_boxes()
    {
        $boxes = BoxInstallation::where('status',7)->get();
        return view('admin-panel.box.removed_boxs',compact('boxes'));
    }

    public function dc_request_food()
    {
        $permits =FoodPermit::pluck('bike_id')->toArray();
        $states = Cities::all();
        $food =BikeDetail::with('current_box.platformdetail')->whereNotIn('id',$permits)->get();
        return view('admin-panel.foodpermit.dc_request_food',compact('food','states'));
    }

    public function food_request_dc(Request $request)
    {
        $checkbox_vals = explode(",",$request->id);
        foreach($checkbox_vals as $bike){
            $abc = new FoodPermit;
            $abc->bike_id = $bike;
            $abc->citie_id = $request->state;
            $abc->status = 1;
            $abc->requested_by = Auth::user()->id;
            $abc->save();
        }
        $message = [
            'message' => 'Request Sented successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function food_process()
    {
        $foods = FoodPermit::with('bikes','city')->where('status',1)->get();
        $doc_uploaded = FoodPermit::with('bikes','city')->where('status',2)->get();
        $permit_uploaded = FoodPermit::with('bikes','city')->where('status',3)->get();
        $expired = FoodPermit::where('status',4)->pluck('bike_id')->toArray();
        return view('admin-panel.foodpermit.food_process',compact('foods','doc_uploaded','permit_uploaded','expired'));
    }

    public function food_permit_process()
    {
        $bikes = BikeDetail::get(['id','plate_no']);
        return view('admin-panel.foodpermit.food_permit_process',compact('bikes'));
    }

    public function food_process_details(Request $request)
    {
        $bike = $request->bike;
        $bikes = FoodPermit::where('bike_id',$bike)->where('status','!=','4')->first();
        if(isset($bikes)){
            $view = view('admin-panel.foodpermit.food_process_details',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }else{
            $bikes = 'empty';
            $view = view('admin-panel.foodpermit.food_process_details',compact('bikes'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function food_upload_documents(Request $request)
    {
        if($request->hasfile('documents'))
        {
            foreach($request->file('documents') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/food_documents/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $abc = FoodPermit::find($request->id);
        $abc->documents = $request->date;
        $abc->status = 2;
        if(isset($data)){
            $abc->box_img = json_encode($data);
        }
        $abc->save();

        return response()->json(['code' => "100",'id'=>$abc->bike_id]);
    }

    public function food_upload_permit(Request $request)
    {
        $date = Carbon::now()->toDateString();
        if($request->hasfile('permits'))
        {
            foreach($request->file('permits') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/food_permit/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $abc = FoodPermit::find($request->id);
        $abc->expiry_date = $request->date;
        $abc->permit_upload_date = $date;
        $abc->status = 3;
        if(isset($data)){
            $abc->food_permit = json_encode($data);
        }
        $abc->save();

        return response()->json(['code' => "100",'id'=>$abc->bike_id]);
    }

    public function get_food_document_details(Request $request)
    {
        $food = FoodPermit::find($request->id);
        $view = view('admin-panel.foodpermit.food_document_details',compact('food'))->render();
        return response()->json(['html' => $view]);
    }

    public function get_food_permit_details(Request $request)
    {
        $food = FoodPermit::find($request->id);
        $view = view('admin-panel.foodpermit.food_permit_documents',compact('food'))->render();
        return response()->json(['html' => $view]);
    }

    public function food_permit_expiry()
    {
        $years_months = array(
            '0'=>'',
            '01'=> 'January',
            '02'=>'Feburary',
            '03'=>'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' =>'September',
            '10' => 'October',
            '11' =>  'November',
            '12' => 'December',
        );

        $time = strtotime(date('y-m-d'));
        $month = date("m", strtotime("+0 month",$time ));
        $final = date("m", strtotime("-1 month",$time ));
        $two = date("m", strtotime("-2 month",$time ));
        $three = date("m", strtotime("-3 month",$time ));
        $four = date("m", strtotime("-4 month",$time ));
        $five = date("m", strtotime("-5 month",$time ));

        $current_month = $years_months[$month];
        $first_month = $years_months[$final];
        $second_month = $years_months[$two];
        $third_month = $years_months[$three];
        $fourth_month = $years_months[$four];
        $fifth_month = $years_months[$five];

        $current = date("Y-m", strtotime("+0 month",$time ));
        $first_month_date = date("Y-m", strtotime("-1 month",$time ));
        $second_month_date = date("Y-m", strtotime("-2 month",$time ));
        $third_month_date = date("Y-m", strtotime("-3 month",$time ));
        $fourth_month_date = date("Y-m", strtotime("-4 month",$time ));
        $fifth_month_date = date("Y-m", strtotime("-5 month",$time ));

        $before_month = date("Y-m-30", strtotime("-5 month",$time ));

        $permit = FoodPermit::where("expiry_date",'like','%'.$current.'%')->where('status',3)->get();
        $permit_first = FoodPermit::where("expiry_date",'like','%'.$first_month_date.'%')->where('status',3)->get();
        $permit_sec = FoodPermit::where("expiry_date",'like','%'.$second_month_date.'%')->where('status',3)->get();
        $permit_third = FoodPermit::where("expiry_date",'like','%'.$third_month_date.'%')->where('status',3)->get();
        $permit_four = FoodPermit::where("expiry_date",'like','%'.$fourth_month_date.'%')->where('status',3)->get();
        $permit_five = FoodPermit::where("expiry_date",'like','%'.$fifth_month_date.'%')->where('status',3)->get();

        $before_permit = FoodPermit::where("expiry_date",'<',$before_month)->where("expiry_date",'!=','0000-00-00')->where('status',3)->get();
        $states = Cities::all();

        return view('admin-panel.foodpermit.permit_expiry',compact("current_month","first_month","second_month","third_month",'states',
            "fourth_month","fifth_month",'permit','permit_first','permit_sec','permit_third','permit_four','permit_five','before_permit'));
    }

    public function renew_permit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state' => 'required_if:state_status,2',
            'state_status' => 'required',
        ]);

        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        if($request->state_status == 2)
        {
            $checkbox_vals = explode(",",$request->id);
            foreach($checkbox_vals as $bike){

                $obj = FoodPermit::find($bike);
                $obj->status = 4;
                $obj->save();

                $abc = new FoodPermit;
                $abc->bike_id = $obj->bike_id;
                $abc->citie_id = $request->state;
                $abc->status = 1;
                $abc->requested_by = Auth::user()->id;
                $abc->save();
            }
            $message = [
                'message' => 'Request Sented successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }elseif($request->state_status == 1)
        {
            $checkbox_vals = explode(",",$request->id);
            foreach($checkbox_vals as $bike){

                $obj = FoodPermit::find($bike);
                $obj->status = 4;
                $obj->save();

                $abc = new FoodPermit;
                $abc->bike_id = $obj->bike_id;
                $abc->citie_id = $obj->citie_id;
                $abc->status = 1;
                $abc->requested_by = Auth::user()->id;
                $abc->save();
            }
            $message = [
                'message' => 'Request Sented successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }
    }

    public function bike_renewal()
    {
        $years_months = array(
            '0'=>'',
            '01'=> 'January',
            '02'=>'Feburary',
            '03'=>'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' =>'September',
            '10' => 'October',
            '11' =>  'November',
            '12' => 'December',
        );

        $time = strtotime(date('y-m-d'));
        $month = date("m", strtotime("+0 month",$time ));
        $final = date("m", strtotime("-1 month",$time ));
        $two = date("m", strtotime("-2 month",$time ));
        $three = date("m", strtotime("-3 month",$time ));
        $four = date("m", strtotime("-4 month",$time ));
        $five = date("m", strtotime("-5 month",$time ));

        $current_month = $years_months[$month];
        $first_month = $years_months[$final];
        $second_month = $years_months[$two];
        $third_month = $years_months[$three];
        $fourth_month = $years_months[$four];
        $fifth_month = $years_months[$five];

        $current = date("Y-m", strtotime("+0 month",$time ));
        $first_month_date = date("Y-m", strtotime("-1 month",$time ));
        $second_month_date = date("Y-m", strtotime("-2 month",$time ));
        $third_month_date = date("Y-m", strtotime("-3 month",$time ));
        $fourth_month_date = date("Y-m", strtotime("-4 month",$time ));
        $fifth_month_date = date("Y-m", strtotime("-5 month",$time ));

        $before_month = date("Y-m-30", strtotime("-5 month",$time ));

        $requested = BikeRenewal::whereNotIn('status',[4,5])->pluck('bike_id')->toArray();
        $bike = BikeDetail::where("expiry_date",'like','%'.$current.'%')->whereNotIn('id',$requested)->get();
        $bike_first = BikeDetail::where("expiry_date",'like','%'.$first_month_date.'%')->whereNotIn('id',$requested)->get();
        $bike_sec = BikeDetail::where("expiry_date",'like','%'.$second_month_date.'%')->whereNotIn('id',$requested)->get();
        $bike_third = BikeDetail::where("expiry_date",'like','%'.$third_month_date.'%')->whereNotIn('id',$requested)->get();
        $bike_four = BikeDetail::where("expiry_date",'like','%'.$fourth_month_date.'%')->whereNotIn('id',$requested)->get();
        $bike_five = BikeDetail::where("expiry_date",'like','%'.$fifth_month_date.'%')->whereNotIn('id',$requested)->get();

        $before_bike = BikeDetail::where("expiry_date",'<',$before_month)->whereNotIn('id',$requested)->get();

        return view('admin-panel.bikerenewal.expired_bikes',compact("current_month","first_month","second_month","third_month",
            "fourth_month","fifth_month",'bike','bike_first','bike_sec','bike_third','bike_four','bike_five','before_bike'));
    }

    public function renewal_token_save(Request $request)
    {
        if($request->hasfile('attachment'))
        {
            foreach($request->file('attachment') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/bike_reg_token_attachment/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $bike = BikeDetail::find($request->id);
        $old_expiry = $bike->expiry_date;

        $obj = new BikeRenewal();
        $obj->bike_id = $request->id;
        $obj->token = $request->token_no;
        $obj->status = 1;
        if(isset($old_expiry)){
            $obj->old_expiry = $old_expiry;
        }
        if(isset($data)){
            $obj->token_attachment = json_encode($data);
        }
        $obj->save();

        $message = [
            'message' => 'Token Added successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function renewal_pending_process()
    {
        $tokens = BikeRenewal::where('status',1)->get();
        $cashs = BikeRenewal::where('status',3)->get();
        $finished = BikeRenewal::where('status',5)->get();
        return view('admin-panel.bikerenewal.pending_process',compact('tokens','cashs','finished'));
    }

    public function save_cash_requesition(Request $request)
    {
        $obj = BikeRenewal::find($request->id);
        $obj->cash_amount = $request->acc_amount;
        $obj->cash_date = $request->acc_date;
        $obj->user_id = Auth::user()->id;
        $obj->status = 2;
        $obj->save();

        $message = [
            'message' => 'Cash Requisition Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function save_new_expiry(Request $request)
    {
        if($request->hasfile('mulkia'))
        {
            foreach($request->file('mulkia') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/bike_reg_renewal/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $obj = BikeRenewal::find($request->ids);
        $bike_exists = BikeDetail::find($obj->bike_id);
        if($bike_exists !== null){
            $bike_exists->issue_date = $request->issue_date;
            $bike_exists->expiry_date = $request->expiry_date;
            $bike_exists->save();
        }
        $obj->new_expiry_date = $request->expiry_date;
        $obj->new_issue_date = $request->issue_date;
        $obj->status = 5;
        if(isset($data)){
            $obj->mulkia = json_encode($data);
        }
        $obj->save();

        $message = [
            'message' => 'Registration Updated Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function pending_cash_request(Request $request)
    {
        $cashs = BikeRenewal::where('status',2)->get();
        $rejected = BikeRenewal::where('status',4)->get();
        return view('admin-panel.bikerenewal.cash_request',compact('cashs','rejected'));
    }

    public function accept_cash_request(Request $request)
    {
        if($request->type ==  1)
        {
            $obj = BikeRenewal::find($request->id);
            $obj->status = 3;
            $obj->accepted_by = Auth::user()->id;
            $obj->save();

            $message = [
                'message' => 'Accepted Successfully',
                'alert-type' => 'success'
            ];
        }elseif($request->type == 2){
            $obj = BikeRenewal::find($request->id);
            $obj->status = 4;
            $obj->accepted_by = Auth::user()->id;
            $obj->save();

            $message = [
                'message' => 'Rejected Successfully',
                'alert-type' => 'success'
            ];
        }
        return redirect()->back()->with($message);
    }

    public function rta_dashboard()
    {
        //Bike Counts
        $total_bike = BikeDetail::count();
        $cancel_bike = BikeCencel::pluck('bike_id')->toArray();
        $not_work_bike = BikeDetail::where('status',0)->whereNotIn('id',$cancel_bike)->count();
        $active_bike = BikeDetail::where('status',1)->count();
        $working_bike = BikeDetail::where('status',2)->whereNotIn('id',$cancel_bike)->count();
        $holding_bike = BikeDetail::where('status',3)->count();

        //Bike Checkin & Checkout
        $bike_checkins = AssignBike::with('passport.personal_info','bike_plate_number')
                        ->whereDate('checkin', '=', Carbon::today()->toDateString())->get();
        $bike_checkouts = AssignBike::with('passport.personal_info','bike_plate_number')
                        ->whereDate('checkout', '=', Carbon::today()->toDateString())->get();
        $bike_checkin_more = AssignBike::with('passport.personal_info','bike_plate_number')
                            ->whereBetween('checkin', [Carbon::now()->subDays(7)->format('Y-m-d'),Carbon::today()->toDateString()])->get();
        $bike_checkout_more = AssignBike::with('passport.personal_info','bike_plate_number')
                            ->whereBetween('checkout', [Carbon::now()->subDays(7)->format('Y-m-d'),Carbon::today()->toDateString()])->get();
        $boxes = BoxInstallation::with('bikes','platformdetail')->where('status',6)
                ->whereDate('updated_at', '=', Carbon::today()->toDateString())->get();
        $permits = FoodPermit::with('bikes','city')->where('status',3)
                ->whereDate('updated_at', '=', Carbon::today()->toDateString())->get();
        $accidents = VehicleAccident::with('passport','bikes')->whereDate('created_at', '=', Carbon::today()->toDateString())->get();
        $missings = BikeMissing::with('bike')->whereDate('created_at', '=', Carbon::today()->toDateString())->get();
        $impoundings = BikeImpoundingUpload::whereDate('created_at', '=', Carbon::today()->toDateString())->get();
        $impounding_more = BikeImpoundingUpload::whereBetween('created_at', [Carbon::now()->subDays(7)->format('Y-m-d'),Carbon::today()->toDateString()])->get();

        return view('admin-panel.reports.vehicle_report.rta_dashboard',compact(
            'total_bike','not_work_bike','active_bike','working_bike','holding_bike','cancel_bike','impoundings','impounding_more',
            'bike_checkins','bike_checkouts','boxes','permits','bike_checkin_more','bike_checkout_more','accidents','missings'));
    }
}
