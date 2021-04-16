<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'batch_id',
        'internal1',
        'internal2',
        'finalquiz',
        'finalpractical',
        'assignment',
        'created_by',
    ];

    public function listSubject(){
        return $this->orderBy('id','desc')->simplePaginate(10);
    }

    public function allSubject(){
        return $this->orderBy('id','desc')->get();
    }

    public function EditSubject($id){
        return $this->where('id',$id)->first();
    }

    public function updateSubject($data,$id){
        return $this->where('id',$id)->update($data);
    }

    public function deleteSubject($id){
        return $this->where('id',$id)->delete();
    }

    public function batch(){
        return $this->hasOne(Batch::class,'id','batch_id');
    }
    public function allSubjectByBatch($id){
        return $this->where('batch_id',$id)->orderBy('id','desc')->get();
    }

    public function listSubjectForStudent($batch_id){
        return $this->where('batch_id',$batch_id)->orderBy('id','desc')->simplePaginate(10);
    }

    public function getSubjectForResult($id){
        return $this->select('internal1','internal2','finalquiz','finalpractical','assignment')->where('id',$id)->first();
    }
}
