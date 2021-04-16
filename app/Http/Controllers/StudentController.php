<?php

namespace App\Http\Controllers;

use App\Models\{User,Batch};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth,Validator,Mail;

class StudentController extends Controller
{
    function __construct() {
        $this->middleware('checkUserType');

        $this->common = 'student';
        $this->create = 'Student Created Successfully.';
        $this->update = 'Student Updated Successfully.';
        $this->delete = 'Student Deleted Successfully.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $student,Batch $batch)
    {
        // echo '<pre>';print_r($student->toArray());die;
        $users = $student->listUser();
        $common = $this->common;
        return view($common.'.index',compact('users','common'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $student,Batch $batch)
    {
        $batches =$batch->allBatch();
        $user = $student->listUser();
        $common = $this->common;
        return view($common.'.addEdit',compact('batches','user','common'));
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
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }

        $password = '12345678';
        $input['password'] = Hash::make($password);
        $input['created_by'] = Auth::user()->id;
        $input['user_type'] = '1';
        $input['status'] = '1';

        User::create($input);

        //Send Mail
        /* $email = $input['email'];
        Mail::send('email.newUserRegister', array(
              'name'    => $input['name'],
              'email'         => $email,
              'password'    => $password
          ), function ($message) use ($email) {
          $message->to($email)->subject('User Register');
        }); */
        
        return redirect(route($this->common.'.index'))->with('success', $this->create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $student,Batch $batch)
    {
        $batches =$batch->allBatch();
        $user =$student->editUser($student['id']);
        $common = $this->common;
        return view($common.'.addEdit',compact('batches','user','common'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $student)
    {
        // dd($student);
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'batch_id' => 'required',
            'email' => 'required|email|unique:users,email,'.$student['id']
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }
        $student->updateUser(['name'=>$input['name']],$student['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $student)
    {
        $student->deleteUser($student['id']);
        return redirect(route($this->common.'.index'))->with('success', $this->delete);
    }
}
