<?php

namespace App\Http\Controllers\Agreement;

use App\Model\Agreement\AgreementCategoryTree;
use App\Model\Agreement\TreeAmount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Agreement\DocumentTree;
use Illuminate\Support\Facades\Validator;

class DocumentTreeController extends Controller
{
    //

    public function index(){



        $parents = AgreementCategoryTree::where('parent_id','=','0')->get();
        $all_options = AgreementCategoryTree::pluck('sub_id','id')->all();

        $tree_document = DocumentTree::orderby('id','desc')->get();

        $array_to_send = array();

        foreach($tree_document as $ab){
            $arraay_set = explode(',',$ab->tree_path);

            $parnet_name = AgreementCategoryTree::find($arraay_set[0]);

            $names = AgreementCategoryTree::whereIn('id',$arraay_set)->get();

            $gamer = array(
                'parent_name' => $parnet_name->get_parent_name->name,
                'childs' => $names,
                'is_mandatory' => $names,
                'amount' => $ab->amount,
            );
            $array_to_send [] = $gamer;

        }

        return view('admin-panel.agreement.document_selection.create',compact('parents','all_options','array_to_send'));

    }

    public function store(Request $request){


     try{
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_mandatory' => 'required',
        ]);

        if($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('agreement_selection')->with($message);
        }

        if(count($request->category)==1){
            $path_tree = $request->category[0];
        }else{
            $path_tree = implode(',',$request->category);
        }




        $array_insert = array(
            'is_mandatory' => $request->is_mandatory,
            'name' => $request->name,
            'tree_path' => $path_tree,
        );


         DocumentTree::create($array_insert);

        $message = [
            'message' => 'Document For Agreement has been created Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('document_selection')->with($message);

    }
            catch (\Illuminate\Database\QueryException $e){
            $message = [
            'message' => 'Error Occured',
            'alert-type' => 'error'
            ];
            return redirect()->route('document_selection')->with($message);
            }

    }


    public function ajax_check_document_current_status(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','1')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $path_now = $parent_id.','.$request->current_status;

        $documents =  DocumentTree::where('tree_path','like','%'.$path_now.'%')->get();

        $childe['data'] = array();

        if(!empty($documents)) {
            foreach($documents as $doc){
                $gamer = array(
                    'id' => $doc->id,
                    'name' => $doc->name,
                    'is_mandatory' => $doc->is_mandatory,
                );
                $childe['data'] [] = $gamer;
            }
            echo json_encode($childe);
            exit;
        }

    }

    public function ajax_check_document_driving_license(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','2')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $selected_val =  $request->items;

        $path_now = implode(',',$selected_val);

        $path_now = $parent_id.','.$path_now;

        $documents =  DocumentTree::where('tree_path','=', $path_now)->get();
        $childe['data'] = array();

        if(!empty($documents)) {
            foreach($documents as $doc){
                $gamer = array(
                    'id' => $doc->id,
                    'name' => $doc->name,
                    'is_mandatory' => $doc->is_mandatory,
                );
                $childe['data'] [] = $gamer;
            }

            echo json_encode($childe);
            exit;
        }

    }

    public function ajax_check_document_document_process(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','3')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $selected_val =  $request->items;

        $path_now = implode(',',$selected_val);

        $path_now = $parent_id.','.$path_now;

        $documents =  DocumentTree::where('tree_path','=', $path_now)->get();
        $childe['data'] = array();

        if(!empty($documents)) {
            foreach($documents as $doc){
                $gamer = array(
                    'id' => $doc->id,
                    'name' => $doc->name,
                    'is_mandatory' => $doc->is_mandatory,
                );
                $childe['data'] [] = $gamer;
            }

            echo json_encode($childe);
            exit;
        }

    }

    public function  ajax_check_document_emirates_id(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','4')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $selected_val =  $request->items;

       // $path_now = implode(',',$selected_val);

        $path_now = $parent_id.','.$selected_val;

        $documents =  DocumentTree::where('tree_path','=', $path_now)->get();
        $childe['data'] = array();

        if(!empty($documents)) {
            foreach($documents as $doc){
                $gamer = array(
                    'id' => $doc->id,
                    'name' => $doc->name,
                    'is_mandatory' => $doc->is_mandatory,
                );
                $childe['data'] [] = $gamer;
            }

            echo json_encode($childe);
            exit;
        }
    }
    public  function ajax_check_document_status_change(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','5')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $selected_val =  $request->items;

        // $path_now = implode(',',$selected_val);

        $path_now = $parent_id.','.$selected_val;

        $documents =  DocumentTree::where('tree_path','=', $path_now)->get();
        $childe['data'] = array();

        if(!empty($documents)) {
            foreach($documents as $doc){
                $gamer = array(
                    'id' => $doc->id,
                    'name' => $doc->name,
                    'is_mandatory' => $doc->is_mandatory,
                );
                $childe['data'] [] = $gamer;
            }

            echo json_encode($childe);
            exit;
        }

    }

    public  function ajax_check_document_case_fine(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','6')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $selected_val =  $request->items;

        // $path_now = implode(',',$selected_val);

        $path_now = $parent_id.','.$selected_val;

        $documents =  DocumentTree::where('tree_path','=', $path_now)->get();
        $childe['data'] = array();

        if(!empty($documents)) {
            foreach($documents as $doc){
                $gamer = array(
                    'id' => $doc->id,
                    'name' => $doc->name,
                    'is_mandatory' => $doc->is_mandatory,
                );
                $childe['data'] [] = $gamer;
            }

            echo json_encode($childe);
            exit;
        }

    }

    public  function ajax_check_document_rta_permit(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','7')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $selected_val =  $request->items;

        // $path_now = implode(',',$selected_val);

        $path_now = $parent_id.','.$selected_val;

        $documents =  DocumentTree::where('tree_path','=', $path_now)->get();
        $childe['data'] = array();

        if(!empty($documents)) {
            foreach($documents as $doc){
                $gamer = array(
                    'id' => $doc->id,
                    'name' => $doc->name,
                    'is_mandatory' => $doc->is_mandatory,
                );
                $childe['data'] [] = $gamer;
            }

            echo json_encode($childe);
            exit;
        }

    }












}
