<?php

namespace App\Http\Controllers;

use App\Models\{Result,Subject,Batch,User};
use Illuminate\Http\Request;
use Auth,Validator,Helper;

class ResultController extends Controller
{
    function __construct() {
        $this->middleware('checkUserType', ['except' => ['index']]);

        $this->common = 'result';
        $this->create = 'Result Created Successfully.';
        $this->update = 'Result Updated Successfully.';
        $this->delete = 'Result Deleted Successfully.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Result $result)
    {
        $user = Auth::user();
        if($user->user_type == '1'){
            $results = $result->listResultForStudent($user->batch_id);
        }else{
            $results =$result->listResult();
        }
        $common = $this->common;
        return view($common.'.index',compact('results','common'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Batch $batch)
    {
        $batches =$batch->allBatch();
        $common = $this->common;
        return view($common.'.addEdit',compact('common','batches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Subject $subject)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'subject_id' => 'required',
            'batch_id' => 'required',
            'user_id' => 'required',
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

        $input['total'] = Helper::getTotal($request,$subject);

        Result::create($input);        
        return redirect(route($this->common.'.index'))->with('success', $this->create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result,Batch $batch,Subject $subject,User $user)
    {
        $result =$result->editResult($result['id']);
        $batches =$batch->allBatch();
        $subjects = $subject->allSubjectByBatch($result['batch_id']);
        $users =$user->allUserByBatch($result['batch_id']);
        $common = $this->common;
        return view($common.'.addEdit',compact('result','common','batches','subjects','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'subject_id' => 'required',
            'batch_id' => 'required',
            'user_id' => 'required',
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
        $result->updateResult($input,$result['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        $result->deleteResult($result['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->delete);
    }
}
