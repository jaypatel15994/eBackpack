<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'batch_id',
        'subject_id',
        'date',
        'lecture_no',
        'user_id',
        'attended',
        'created_by',
    ];

    public function listAttendance(){
        return $this->orderBy('id','desc')->simplePaginate(10);
    }

    public function listAttendanceByBatchIdSubjectId($batchId,$subjectId){
        return $this->where([['batch_id',$batchId],['subject_id',$subjectId]])->orderBy('date','desc')->orderBy('user_id','desc')->get();
    }

    public function allAttendance(){
        return $this->orderBy('id','desc')->get();
    }

    public function getLectureNo($subject_id){
        $lecture_no = 1;
        if($lastAttendance = $this->where('subject_id',$subject_id)->orderBy('id','desc')->first()){
            $lecture_no = $lastAttendance['lecture_no']+1;
        }
        return $lecture_no;
    }

    public function EditAttendance($id){
        return $this->where('id',$id)->first();
    }

    public function updateAttendance($data,$id){
        return $this->where('id',$id)->update($data);
    }

    public function deleteAttendance($id){
        return $this->where('id',$id)->delete();
    }

    public function batch(){
        return $this->hasOne(Batch::class,'id','batch_id');
    }

    public function subject(){
        return $this->hasOne(Subject::class,'id','subject_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function listAttendanceForStudent($user_id){
        return $this->where('user_id',$user_id)->orderBy('id','desc')->simplePaginate(10);
    }
}
