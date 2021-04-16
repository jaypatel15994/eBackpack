<?php

namespace App\Http\Controllers;

use App\Models\{Notice,Batch};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Auth,Validator;

class NoticeController extends Controller
{
    function __construct() {
        $this->middleware('checkUserType', ['except' => ['index']]);
        $this->common = 'notice';
        $this->create = 'Notice Created Successfully.';
        $this->update = 'Notice Updated Successfully.';
        $this->delete = 'Notice Deleted Successfully.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Notice $notice)
    {
        $user = Auth::user();
        if($user->user_type == '1'){
            $notices =$notice->listNoticeForStudent($user->batch_id);
        }else{
            $notices =$notice->listNotice();
        }
        $common = $this->common;
        return view($common.'.index',compact('notices','common'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Notice $notice,Batch $batch)
    {
        $batches =$batch->allBatch();
        $notice = $notice->listNotice();
        $common = $this->common;
        return view($common.'.addEdit',compact('batches','notice','common'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'batch_id' => 'required',
            'attachment' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }
        
        if($files=$request->file('attachment')){
            $dir = 'public/upload/wallet/';
            $extension = $files->getClientOriginalExtension();
            $original_filename = $files->getClientOriginalName();
            $name = rand(1111,9999).'_'.time().'.'.$extension;
            $files->move($dir,$name); //$dir.$name
            // echo $dir,$name;die;
            $ins['path'] = $dir.$name;
            $ins['mime_type'] = $files->getClientMimeType();
            $ins['size'] = round(File::size($dir.$name) * 0.001,2);
            $ins['about_file'] = $original_filename;
            $data['attachment'] = $dir.'/'.$name;
        }
        $data['name'] = $input['name'];
        $data['batch_id'] = $input['batch_id'];
        $data['created_by'] = Auth::user()->id;
        Notice::create($data);
        
        return redirect(route($this->common.'.index'))->with('success', $this->create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice,Batch $batch)
    {
        $batches =$batch->allBatch();
        $notice =$notice->editNotice($notice['id']);
        $common = $this->common;
        return view($common.'.addEdit',compact('batches','notice','common'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'batch_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }
        if($files=$request->file('attachment')){
            $dir = 'public/upload/wallet/';
            $extension = $files->getClientOriginalExtension();
            $original_filename = $files->getClientOriginalName();
            $name = rand(1111,9999).'_'.time().'.'.$extension;
            $files->move($dir,$name); //$dir.$name
            // echo $dir,$name;die;
            $ins['path'] = $dir.$name;
            $ins['mime_type'] = $files->getClientMimeType();
            $ins['size'] = round(File::size($dir.$name) * 0.001,2);
            $ins['about_file'] = $original_filename;
            $data['attachment'] = $dir.'/'.$name;
        }
        $data['name'] = $input['name'];
        $data['batch_id'] = $input['batch_id'];
        $data['created_by'] = Auth::user()->id;
        
        $notice->updateNotice($data,$notice['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        $notice->deleteNotice($notice['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->delete);
    }
}
