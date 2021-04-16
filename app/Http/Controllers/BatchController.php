<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Auth,Validator;

class BatchController extends Controller
{
    function __construct() {

        $this->middleware('checkUserType');
        
        $this->common = 'batches';
        $this->create = 'Batch Created Successfully.';
        $this->update = 'Batch Updated Successfully.';
        $this->delete = 'Batch Deleted Successfully.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Batch $batch)
    {
        $batches =$batch->listBatch();
        $common = $this->common;
        return view($common.'.index',compact('batches','common'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $common = $this->common;
        return view($common.'.addEdit',compact('common'));
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
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }
        $input['created_by'] = Auth::user()->id;

        Batch::create($input);
        
        return redirect(route($this->common.'.index'))->with('success', $this->create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        
        $batch =$batch->editBatch($batch['id']);
        $common = $this->common;
        return view($common.'.addEdit',compact('batch','common'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }
        $batch->updateBatch(['name'=>$input['name']],$batch['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        $batch->deleteBatch($batch['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->delete);
    }
}
