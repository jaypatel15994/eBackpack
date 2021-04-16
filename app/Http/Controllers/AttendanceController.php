<?php

namespace App\Http\Controllers;

use App\Models\{Attendance,Batch,User,Subject};
use Illuminate\Http\Request;
use Auth,Validator,Helper;

class AttendanceController extends Controller
{
    function __construct() {
        $this->middleware('checkUserType', ['except' => ['index']]);
        
        $this->common = 'attendance';
        $this->create = 'Attendance Created Successfully.';
        $this->update = 'Attendance Updated Successfully.';
        $this->delete = 'Attendance Deleted Successfully.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Attendance $attendance,Batch $batch)
    {
        $user = Auth::user();
        $batches =$batch->allBatch();
        $common = $this->common;
        $user_type = $user->user_type;
        $attendances = $subjects = [];
        $html ='';
        if($user_type == '1'){
            $attendances =$attendance->listAttendanceForStudent($user->id);
        }
        return view($common.'.index',compact('attendances','common','batches','user_type','html','subjects'));
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
    public function store(Request $request,Attendance $attendance,User $user)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'subject_id' => 'required',
            'date' => 'required',
            'batch_id' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }
        $presentUser = request('user_id') ?? [];
        $lecture_no = $attendance->getLectureNo($input['subject_id']);

        $absentUser = $user->allUserExceptByBatch($presentUser,request('batch_id'));
        $data = [];
        $created_by = Auth::user()->id;
        foreach ($presentUser as $key => $value) {
            $data[] = [
                'user_id'  => $value,
                'subject_id' =>request('subject_id'),
                'batch_id' =>request('batch_id'),
                'attended' => 1,
                'date' => request('date'),
                'created_by' => $created_by,
                'lecture_no' => $lecture_no
            ];
        }
        if($absentUser->pluck('id')){
            foreach ($absentUser->pluck('id') as $key => $value) {
                $data[] = [
                    'user_id'  => $value,
                    'subject_id' =>request('subject_id'),
                    'batch_id' =>request('batch_id'),
                    'attended' => 0,
                    'date' => request('date'),
                    'created_by' => $created_by,
                    'lecture_no' => $lecture_no
                ];
            }
        }
        
        Attendance::insert($data);        
        return redirect(route($this->common.'.index'))->with('success', $this->create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance,Batch $batch,Subject $subject,User $user)
    {
        $attendance =$attendance->editAttendance($attendance['id']);
        $batches =$batch->allBatch();
        $subjects = $subject->allSubjectByBatch($attendance['batch_id']);
        $users =$user->allUserByBatch($attendance['batch_id']);
        $common = $this->common;
        return view($common.'.addEdit',compact('attendance','common','batches','subjects','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'subject_id' => 'required',
            'date' => 'required',
            'batch_id' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }
        unset($input['_method']);
        unset($input['_token']);
        $attendance->updateAttendance($input,$attendance['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->deleteAttendance($attendance['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->delete);
    }

    public function getAttendance(Request $request, Attendance $attendance,Subject $subject,Batch $batch){
        $attendances = [];
        $user = Auth::user();
        $user_type = $user->user_type;
        $common = $this->common;
        $batches =$batch->allBatch();
        $batch_id = request('batch_id');
        $subject_id = request('subject_id');
        $subjects = $subject->allSubjectByBatch($batch_id);
        $html = Helper::getAttendance($attendance,$batch_id,$subject_id);
        return view($common.'.index',compact('attendances','common','batches','user_type','html','subjects','batch_id','subject_id'));
    }
}
