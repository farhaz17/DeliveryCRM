<?php

namespace App\Http\Controllers\Jobs;

use App\Mail\JobMail;
use App\Model\Cities;
use App\Mail\JobMailReject;
use Illuminate\Http\Request;
use App\Model\Seeder\Company;
use App\Model\Jobs\CreateJobs;
use App\Model\Job\JobsApplication;
use Illuminate\Contracts\Queue\Job;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

        // $this->middleware('role_or_permission:Admin|Jobs');


        $this->middleware('role_or_permission:Admin|Jobs', ['only' => ['index','store','jobs_posted','applicants_list']]);


    }
    public function index()
    {

        $company=Company::where('type','1')->get();
        $states=Cities::all();
        return view('admin-panel.jobs.create_job',compact('company','states'));
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
        $validator = Validator::make($request->all(), [
            'company' => 'required',
       ]);
       if ($validator->fails()) {
           $validate = $validator->errors();
           $message_error = "";

           foreach ($validate->all() as $error){
               $message_error .= $error;
           }

           $validate = $validator->errors();
           $message = [
               'message' => $message_error,
               'alert-type' => 'error',
               'error' => $validate->first()
           ];
           return redirect()->back()->with($message);
       }

        $ref_no = IdGenerator::generate(['table' => 'create_jobs', 'field' => 'refrence_no', 'length' => 7, 'prefix' => '10']);


        $obj = new CreateJobs();
        $obj->company = $request->company;
        $obj->job_title = $request->job_title;
        $obj->state = $request->state;
        $obj->job_description = $request->job_description;
        $obj->qualification = $request->qualification;
        $obj->experience = $request->experience;
        $obj->start_date = $request->start_date;
        $obj->end_date = $request->end_date;
        $obj->status = '1';
        $obj->refrence_no = $ref_no;

        $obj->save();

        $message = [
            'message' => 'New Job Created Sucessfully!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        //,compact('company','states')
        //     $jobs_created=CreateJobs::all();
        //     $current_date=date("Y-m-d");

        //     $total_applicants=JobsApplication::all();
        // return view('admin-panel.jobs.jobs_posted',compact('jobs_created','current_date','total_applicants'));
    }
    public function jobs_posted(){
        $jobs_created=CreateJobs::all();
        $current_date=date("Y-m-d");

        $total_applicants=JobsApplication::all();
    return view('admin-panel.jobs.jobs_posted',compact('jobs_created','current_date','total_applicants'));
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

    public function get_job_detail(Request $request){
        $id=$request->id;
        $create_job_detail=CreateJobs::where('id',$id)->first();

        $view = view("admin-panel.jobs.jobs_ajax_files.get_job_detail",
        compact('create_job_detail'))->render();
        return response()->json(['html' => $view]);
    }


    public function list_of_jobs(){
        $jobs_created=CreateJobs::all();
        $current_date=date("Y-m-d");


    return view('admin-panel.jobs.jobs_list_view',compact('jobs_created','current_date'));

    }
    public function list_of_jobs2(){
        $current_date=date("Y-m-d");

        $jobs_created=CreateJobs::whereDate('start_date','<=', $current_date)
        ->whereDate('end_date','>=', $current_date)->get();


        $data=array();
        foreach ($jobs_created as $row) {
            $res = array(
                "id" => $row->id,
                "company" => $row->company,
                "state" => $row->states_detail->name,
                "job_title" => $row->job_title,
                "start_date" => $row->start_date,
                "end_date" => $row->end_date,

            );
            $data[]= $res;
        }

// dd($data);

    return response()->json(['data' => $data, 'current_date'=>$current_date]);

    }



    public function get_full_job_detail(Request $request){

                $id=$request->id;
                $create_job_detail=CreateJobs::where('id',$id)->first();



                return view('admin-panel.jobs.jobs_list_detail',compact('create_job_detail'));

    }

    public function get_full_job_detail2($id){



        $create_job_detail=CreateJobs::where('id',$id)->first();

        $data=array();
        $res = array(
            "id" => $create_job_detail->id,
            "company" => $create_job_detail->company,
            "state" => $create_job_detail->states_detail->name,
            "job_title" => $create_job_detail->job_title,
            "start_date" => $create_job_detail->start_date,
            "end_date" => $create_job_detail->end_date,
            "job_description" => $create_job_detail->job_description,
        );
        $data[]= $res;

        // dd($data);

            return response()->json(['data' => $data]);



}



    public function apply_job($id){
        return view('admin-panel.jobs.apply_job',compact('id'));
    }

    public function apply_job_2($id){
        $create_job_detail=CreateJobs::where('id',$id)->first();

        $data=array();
        $res = array(
            "id" => $create_job_detail->id,
            "job_title" => $create_job_detail->job_title,

        );
        $data[]= $res;

        // dd($data);

            return response()->json(['data' => $data]);

        // return view('admin-panel.jobs.apply_job',compact('id'));
    }



    public function apply_store(Request $request){


        $items = array();
        $count=1;
        for ($i = 0; $i < count($request->input('question')); $i++){
            $gamer = array([
                'no' => $count,
                'question' => $request->input('question')[$i],
        ]);
        $items[] = $gamer;
        $count++;
        }
        $objects= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($items), JSON_FORCE_OBJECT));
        $json="[".$objects."]";

        //refrences information-here-----

        $items2 = array();
        $count2=1;
        for ($j = 0; $j < count($request->input('ref_name')); $j++){
            for ($k = 0; $k < count($request->input('ref_no')); $k++){
            $gamer2 = array([
                'no' => $count2,
                'ref_name' => $request->input('ref_name')[$j],
                'ref_no' => $request->input('ref_no')[$k],
        ]);
        $items2[] = $gamer2;
        $count2++;
        }
    }
        $objects2= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($items2), JSON_FORCE_OBJECT));
        $json2="[".$objects2."]";

//-----Uplaod cv here
if(!empty($_FILES['file_name']['name'])){
    $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
    $img = $request->file('file_name');
    $file_path = 'assets/upload/resumes/' .time() . '.'. $request->date . '.' . $ext;

    Storage::disk("s3")->put($file_path,file_get_contents($img));

}


    //save data here




        $obj= new JobsApplication();
        $obj->job_id =$request->id;
        $obj->first_name =$request->first_name;
        $obj->last_name =$request->last_name;
        $obj->email_address =$request->email_address;
        $obj->phone_no =$request->phone_no;
        $obj->education =$request->education;
        if(!empty($file_path)){
            $obj->cv = $img;
        }
        $obj->comments =$request->comments;
        $obj->cover_letter =$request->cover_letter;
        $obj->last_company =$request->last_company;
        $obj->question =$json;
        $obj->references =$json2;
                $obj->save();

        $message = [
            'message' => 'You Have Applied Successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($message);


    }

    //user application
    public function apply_store_2(Request $request){



        if ($request->token == "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq") {

        $items = array();
        $count=1;
        for ($i = 0; $i < count($request->input('question')); $i++){
            $gamer = array([
                'no' => $count,
                'question' => $request->input('question')[$i],
        ]);
        $items[] = $gamer;
        $count++;
        }
        $objects= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($items), JSON_FORCE_OBJECT));
        $json="[".$objects."]";

        //refrences information-here-----

        $items2 = array();
        $count2=1;
        for ($j = 0; $j < count($request->input('ref_name')); $j++){
            for ($k = 0; $k < count($request->input('ref_no')); $k++){
            $gamer2 = array([
                'no' => $count2,
                'ref_name' => $request->input('ref_name')[$j],
                'ref_no' => $request->input('ref_no')[$k],
        ]);
        $items2[] = $gamer2;
        $count2++;
        }
    }
        $objects2= str_replace(array('[', ']'), '', htmlspecialchars(json_encode($items2), JSON_FORCE_OBJECT));
        $json2="[".$objects2."]";

//-----Uplaod cv here
// if(!empty($_FILES['file_name']['name'])){
//     $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
//     $img = $request->file('file_name');
//     $file_path = 'assets/upload/resumes/' .time() . '.'. $request->date . '.' . $ext;

//     Storage::disk("s3")->put($file_path,file_get_contents($img));

// }




// dd($img);
    //save data here



    // if(!empty($file_path)){
    //     $obj->cv = $img;
    // }

    $jobs= JobsApplication::where('job_id',$request->id)->where('email_address',$request->email_address)->count();
    if($jobs=='1'){
        return response()->json([
            'code' => "103"
        ]);
    }
        $obj= new JobsApplication();
        $obj->job_id =$request->id;
        $obj->first_name =$request->first_name;
        $obj->last_name =$request->last_name;
        $obj->email_address =$request->email_address;
        $obj->phone_no =$request->phone_no;
        $obj->education =$request->education;
        $obj->comments =$request->comments;
        $obj->cover_letter =$request->cover_letter;
        $obj->last_company =$request->last_company;
        $obj->question =$json;
        $obj->references =$json2;


        if($request->file_name != null){
            $img = $request->file('file_name');
            $cvName = 'assets/upload/resumes/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($cvName, file_get_contents($img));
            $obj->cv = $cvName;
        }



                $obj->save();

        $message = [
            'message' => 'You Have Applied Successfully!',
            'alert-type' => 'success'
        ];


        return response()->json([
            'code' => "100"
        ]);
    }
    else{
        $message = [
            'message' => "Something went wrong try again",
            'alert-type' => 'error',
            'error' => ''
        ];
        return response()->json([
            'code' => "101",
            'message' => $message,
        ]);
    }

    }




   public function applicants_list(){
       $applicants=JobsApplication::where('status','0')->get();

       return view('admin-panel.jobs.applicants_list',compact('applicants'));
   }

   public function view_jobs_title_sort($id){
    $applicants=JobsApplication::where('job_id',$id)->get();
    return view('admin-panel.jobs.applicants_list_job_wise',compact('applicants'));
}


   public function get_app_comments(Request $request){
    $id=$request->id;
    $app_detail=JobsApplication::where('id',$id)->first();

    $view = view("admin-panel.jobs.jobs_ajax_files.get_comments",
    compact('app_detail'))->render();
    return response()->json(['html' => $view]);
}




public function get_app_cover_letter(Request $request){
    $id=$request->id;
    $app_detail=JobsApplication::where('id',$id)->first();

    $view = view("admin-panel.jobs.jobs_ajax_files.get_cover_letter",
    compact('app_detail'))->render();
    return response()->json(['html' => $view]);
}


public function get_app_question(Request $request){

    $id=$request->id;
    $questions = JobsApplication::find($id)->question;

    $gamer_array =  array();
    $json = json_decode($questions);
        foreach($json as $obj){
            $gamer = array(
                'id' =>$id,
                'sn' =>$obj->no,
                'question'=> $obj->question,
        );
        $gamer_array[] = $gamer;
        }
        $view = view("admin-panel.jobs.jobs_ajax_files.get_questions",
        compact('gamer_array'))->render();
        return response()->json(['html'=>$view]);
 }


 public function get_app_ref(Request $request){

    $id=$request->id;
    $ref = JobsApplication::find($id)->references;

    $gamer_array =  array();
    $json = json_decode($ref);
        foreach($json as $obj){
            $gamer = array(
                'id' =>$id,
                'sn' =>$obj->no,
                'ref_name'=> $obj->ref_name,
                'ref_no'=> $obj->ref_no,
        );
        $gamer_array[] = $gamer;
        }
        $view = view("admin-panel.jobs.jobs_ajax_files.get_ref",
        compact('gamer_array'))->render();
        return response()->json(['html'=>$view]);
 }

 public function get_accept_applicant_list(){
    $applicants=JobsApplication::where('status','1')->get();

    $view = view("admin-panel.jobs.jobs_ajax_files.accepted_app",
        compact('applicants'))->render();
        return response()->json(['html'=>$view]);
}

public function get_reject_applicant_list(){
    $applicants=JobsApplication::where('status','2')->get();

    $view = view("admin-panel.jobs.jobs_ajax_files.rejected_app",
        compact('applicants'))->render();
        return response()->json(['html'=>$view]);
}

public function accept_app($id){
    $obj = JobsApplication::find($id);
    $obj->status='1';
    $obj->save();

    Mail::to($obj->email_address)->send(new JobMail($obj));

            $message = [
                'message' => 'Application has been accepted!! Acknowledment Email has been sent',
                'alert-type' => 'success'
            ];

return redirect()->back()->with($message);
}

public function rej_app($id){
    $obj = JobsApplication::find($id);
    $obj->status='2';
    $obj->save();

    Mail::to($obj->email_address)->send(new JobMailReject($obj));

            $message = [
                'message' => 'Application has been rejected!! Acknowledment Email has been sent',
                'alert-type' => 'success'
            ];

return redirect()->back()->with($message);
}




}
