<?php

namespace App\Http\Controllers\Package;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cities;
use App\Model\Package\Package;
use App\Model\Package\PackageAssignment;
use App\Model\Passport\Passport;
use App\Model\Platform;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;






class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $states=Cities::all();
        $packages=Package::where('status','0')->get();
        $platform=Platform::all();
        $package_assign= PackageAssignment::all();



        return view('admin-panel.package.index',compact('states','packages','platform','package_assign'));

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
        // dd($request->all());
        //
        // try{
            $validator = Validator ::make($request->all(), [
                'package_name' => 'unique:packages,package_name',

            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => 'Name Already Existed',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('packages')->with($message);
            }




            if($request->hasfile('file_attachments'))
            {
                foreach($request->file('file_attachments') as $file)
                {
                    $name =rand(100,200000).'.'.time().'.'.$file->extension();
                    $filePath = '/assets/upload/packages/' . $name;
                   Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }
            $package_no = IdGenerator::generate(['table' => 'packages', 'field' => 'package_no', 'length' => 6, 'prefix' => 'PK1']);
            $obj=new Package();

            $obj->package_no = $package_no;
            $obj->package_name = $request->input('package_name');
            $obj->state = $request->input('state');
            $obj->limitation=$request->input('limitation');
            $obj->qty = $request->input('qty');
            $obj->salary_package = $request->input('salary_package');
            $obj->platform = $request->input('platform');
            $obj->user_id = Auth::user()->id;
            if(isset($data)){
                $obj->file_attachments =json_encode($data);
            }

            $obj->save();
            $message = [
                'message' => 'Package added Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('packages')->with($message);
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

    public function get_rider_detail(Request $request){
        $pass=Passport::where('passport_no',$request->keyword)->first();
        $passport_id=$pass->id;
        $name=$pass->personal_info->full_name;
        $ppuid=$pass->pp_uid;
        $passport_no=$pass->passport_no;
        $image=isset($pass->profile->image)?$pass->profile->image:'';

        return response()->json([
            'code' => "100",
            'passport_id' => $passport_id,
            'name' => $name,
            'ppuid' => $ppuid,
            'image' =>  $image,
            'passport_no' => $passport_no,
        ]);
    }

    public function get_package_detail(Request $request){

        $package=Package::where('id',$request->val)->first();

        //limtiation
        //salary package
        //files
        //platform

        $limitation=$package->limitation;
        if($limitation=='0'){

            $limit='Yes';

        }else{
            $limit='No';
        }
        $qty=$package->qty;
        $salary_package=$package->salary_package;
        $platform=$package->platform_detail->name;
        $file_attachments=$package->file_attachments;


        return response()->json([
            'code' => "100",
            'limit' => $limit,
            'limitation' => $limitation,
            'salary_package' => $salary_package,
            'platform' => $platform,
            'file_attachments' => $file_attachments,
            'qty' => $qty,
        ]);
    }


//     $fileArray= array("name1.pdf","name2.pdf","name3.pdf","name4.pdf");

// $datadir = "save_path/";
// $outputName = $datadir."merged.pdf";

// $cmd = "gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=$outputName ";
// //Add each pdf file to the end of the command
// foreach($fileArray as $file) {
//     $cmd .= $file." ";
// }
// $result = shell_exec($cmd);


    public function package_assign(){
        $packages= Package::all();
        $package_assign= PackageAssignment::all();
        return view('admin-panel.package.package_assign',compact('package_assign','packages'));

    }


    public function package_assign_save(Request $request){


        $validator = Validator::make($request->all(), [
            'passport_id' => 'unique:package_assignments',

       ]);
       //if already exist check status
       $PackageAssignment= PackageAssignment::where('passport_id',$request->passport_id)->orderBy('created_at','DESC')->first();
if(isset($PackageAssignment)){
       $status=$PackageAssignment->status;

       if($status=='0'){
        return response()->json([
            'code' => "105",

        ]);
       }
    }



        if($request->hasfile('file_attachments'))
        {
            foreach($request->file('file_attachments') as $file)
            {
                $name =rand(100,200000).'.'.time().'.'.$file->extension();
                $filePath = '/assets/upload/packages_assign/' . $name;
               Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }

        $obj=new PackageAssignment();

        $obj->passport_id = $request->passport_id;
        $obj->package_id = $request->input('package_val');
        $obj->checkin_time = $request->input('checkin_time');
        $obj->user_id = Auth::user()->id;
        if($request->hasfile('file_attachments')==null){
            $obj->ammentment_package_sign = '1';
        }
        if(isset($data)){
            $obj->signed_file =json_encode($data);
        }
        $obj->save();
        return response()->json([
            'code' => "100",

        ]);
    }
   public function package_assign_save_file(Request $request){
$id=$request->passport_id_modal;
$obj= PackageAssignment::find($id);

if($request->hasfile('file_attachments2'))
{
    foreach($request->file('file_attachments2') as $file)
    {
        $name =rand(100,200000).'.'.time().'.'.$file->extension();
        $filePath = '/assets/upload/packages_assign/' . $name;
       Storage::disk('s3')->put($filePath, file_get_contents($file));
        $data[] = $name;
    }

    if(isset($data)){
        $obj->signed_file =json_encode($data);
    }
    $obj->ammentment_package_sign='0';
    $obj->save();
    return response()->json([
        'code' => "100",

    ]);
}

   }

   public function package_ammend_save_file(Request $request){
    $id=$request->passport_id_modal;
    $obj= Package::find($id);
    $no_of_ammend=$obj->amendment_times;
    if($no_of_ammend==null){
        $no_of_ammend_val='0';

    }else{
        $no_of_ammend_val=$no_of_ammend;
    }


$amendment_times=$no_of_ammend_val+1;


    if($request->hasfile('file_attachments2'))
    {
        foreach($request->file('file_attachments2') as $file)
        {
            $name =rand(100,200000).'.'.time().'.'.$file->extension();
            $filePath = '/assets/upload/packages/' . $name;
           Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }

        if(isset($data)){
            $obj->file_attachments =json_encode($data);
        }
        $obj->amendment_times=$amendment_times;
        $obj->amendment='0';
        $obj->user_id_ammend = Auth::user()->id;


        DB::table('package_assignments')->where('package_id', $id)
        ->update(['ammentment_package' =>$amendment_times,'ammentment_package_sign'=>'1']);

        $obj->save();
        return response()->json([
            'code' => "100",

        ]);
    }

       }





  public function package_report(){
      $packages=Package::all();
      $active_packages=Package::where('status','0')->get();
      $deactive_packages=Package::where('status','1')->get();

      $package_assign= PackageAssignment::all();

      $platforms= Platform::all();

      foreach($platforms as $res){
      $gamer = array(
        'name' => $res->name,
        'count' => count($packages->where('platform',$res->id)),
    );
    $platform2[] = $gamer;
    $platform = collect($platform2)->sortBy('count')->reverse()->toArray();
}



      return view('admin-panel.package.package_report',compact('active_packages','deactive_packages','packages','package_assign','platform'));
  }

  public function view_riders($id){
    $package_assign= PackageAssignment::where('package_id',$id)->get();
    $package= Package::where('id',$id)->first();

    return view('admin-panel.package.view_riders_list',compact('package_assign','package'));

  }

//   get_inactive

public function get_inactive(){
    $package_assign= PackageAssignment::all();
    $inactive_packages=Package::where('status','1')->get();

    $view = view("admin-panel.package.inactive_packages",compact('inactive_packages','package_assign'))->render();
    return response()->json(['html'=>$view]);
}

public function deactive_packages($id){
            $obj = Package::find($id);
            $obj->status='1';
            $obj->save();
            $message = [
                'message' => 'Deactivation successfully!!',
                'alert-type' => 'success'
            ];
    return redirect()->back()->with($message);

}

public function active_packages($id){
    $obj = Package::find($id);
    $obj->status='0';
    $obj->save();
    $message = [
        'message' => 'Activated successfully!!',
        'alert-type' => 'success'
    ];

return redirect()->back()->with($message);

}
public  function package_sign_unsigned(){
    $package_assign= PackageAssignment::all();
    $package_sign=PackageAssignment::where('ammentment_package_sign','1')->get();
    $package_unsign=PackageAssignment::where('ammentment_package_sign','!=','1')->get();

    return view('admin-panel.package.signed_unsinged',compact('package_sign','package_unsign'));


}


public function package_assign_checkout(Request $request){

    $id=$request->passport_id_modal_checkout;

    $obj= PackageAssignment::find($id);

    if(isset($obj) && $obj->status=='1'){
        $date=$package->checkin_time;

        if($date > $request->datee){

            return response()->json([
            'code' => "101",
            'date' =>  date('d-m-Y', strtotime($date)),
    ]);

        }


    }
    elseif(isset($package) && $package->status=='0'){
        return response()->json([
            'code' => "102",

    ]);



    }else{


    $obj->checkout_time=$request->checkout_time;
    $obj->status='1';
    $obj->save();
    return response()->json([
        'code' => "105",
    ]);
}

}
//date assignment
public function get_date_detail(Request $request){


    $package=PackageAssignment::where('passport_id',$request->passport_id)->orderBy('created_at','DESC')->first();

    if(isset($package) && $package->status=='1'){
        $date=$package->checkin_time;

        if($date > $request->datee){

            return response()->json([
            'code' => "100",
            'date' =>  date('d-m-Y', strtotime($date)),
    ]);

        }


    }
    elseif(isset($package) && $package->status=='0'){
        return response()->json([
            'code' => "101",

    ]);



    }
    else{
        return response()->json([
            'code' => "102",

    ]);

    }

}

public function get_checkout_date_detail(Request $request){


    $package=PackageAssignment::where('id',$request->passport_id)->first();





    if(isset($package)){

        $date=$package->checkin_time;

        if($date > $request->datee){

            return response()->json([
            'code' => "100",
            'date' =>  date('d-m-Y', strtotime($date)),
    ]);

        }
        else{

        }


    }

}




}
