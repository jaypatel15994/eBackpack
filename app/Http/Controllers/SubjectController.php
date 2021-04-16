<?php

namespace App\Http\Controllers;

use App\Models\{Subject,Batch};
use Illuminate\Http\Request;
use Auth,Validator;

class SubjectController extends Controller
{
    function __construct() {
        $this->common = 'subject';
        $this->create = 'Subject Created Successfully.';
        $this->update = 'Subject Updated Successfully.';
        $this->delete = 'Subject Deleted Successfully.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Subject $subject,Batch $batch)
    {
        $user = Auth::user();
        if($user->user_type == '1'){
            $subjects = $subject->listSubjectForStudent($user->batch_id);
        }else{
            $subjects = $subject->listSubject();
        }

        $common = $this->common;
        return view($common.'.index',compact('subjects','common'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Subject $subject,Batch $batch)
    {
        $batches =$batch->allBatch();
        $subject = $subject->listSubject();
        $common = $this->common;
        return view($common.'.addEdit',compact('batches','subject','common'));
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
            'internal1' => 'required',
            'internal2' => 'required',
            'finalquiz' => 'required',
            'finalpractical' => 'required',
            'assignment' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }
        $input['created_by'] = Auth::user()->id;

        Subject::create($input);
        
        return redirect(route($this->common.'.index'))->with('success', $this->create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject,Batch $batch)
    {
        $batches =$batch->allBatch();
        $subject =$subject->editSubject($subject['id']);
        $common = $this->common;
        return view($common.'.addEdit',compact('batches','subject','common'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'batch_id' => 'required',
            'internal1' => 'required',
            'internal2' => 'required',
            'finalquiz' => 'required',
            'finalpractical' => 'required',
            'assignment' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }
        unset($input['_method']);
        unset($input['_token']);
        $subject->updateSubject($input,$subject['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->deleteSubject($subject['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->delete);
    }
}
