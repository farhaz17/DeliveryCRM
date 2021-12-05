<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\AttachmentLabel;

class AttachmentLabelController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|RTAManage', ['only' => ['index','create','store','edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attachmentLabel  = AttachmentLabel::all();
        return view('admin-panel.vehicle_master.attachment_label_list', compact('attachmentLabel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('admin-panel.vehicle_master.attachment_label_create', compact('data'));
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
            'name' => 'unique:attachment_labels|required'
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
        try {        
            $AttachmentLabel = new AttachmentLabel();
            $AttachmentLabel->name = $request->name;
            $AttachmentLabel->save();
            $message = [
                'message' => 'Attachment label Added Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Master\Vehicle\AttachmentLabel  $attachmentLabel
     * @return \Illuminate\Http\Response
     */
    public function show(AttachmentLabel $attachmentLabel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Master\Vehicle\AttachmentLabel  $attachmentLabel
     * @return \Illuminate\Http\Response
     */
    public function edit(AttachmentLabel $attachmentLabel)
    {
        return view('admin-panel.vehicle_master.attachment_label_edit', compact('attachmentLabel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Master\Vehicle\AttachmentLabel  $attachmentLabel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttachmentLabel $attachmentLabel)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:attachment_labels,name,' . $attachmentLabel->id,
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
        try {        
            $attachmentLabel->name = $request->name;
            $attachmentLabel->update();
            $message = [
                'message' => 'Attachment Label Updated Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Master\Vehicle\AttachmentLabel  $attachmentLabel
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttachmentLabel $attachmentLabel)
    {
        //
    }
}
