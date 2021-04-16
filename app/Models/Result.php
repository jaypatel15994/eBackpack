<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
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
        'user_id',
        'internal1',
        'internal2',
        'finalquiz',
        'finalpractical',
        'assignment',
        'created_by',
        'total'
    ];

    public function listResult(){
        return $this->orderBy('id','desc')->simplePaginate(10);
    }

    public function allResult(){
        return $this->orderBy('id','desc')->get();
    }

    public function EditResult($id){
        return $this->where('id',$id)->first();
    }

    public function updateResult($data,$id){
        return $this->where('id',$id)->update($data);
    }

    public function deleteResult($id){
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

    public function listResultForStudent($batch_id){
        return $this->where('batch_id',$batch_id)->orderBy('id','desc')->simplePaginate(10);
    }
}
