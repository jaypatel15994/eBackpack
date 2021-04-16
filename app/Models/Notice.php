<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
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
        'created_by',
        'attachment',
    ];

    public function listNotice(){
        return $this->orderBy('id','desc')->simplePaginate(10);
    }

    public function allNotice(){
        return $this->orderBy('id','desc')->get();
    }

    public function editNotice($id){
        return $this->where('id',$id)->first();
    }

    public function updateNotice($data,$id){
        return $this->where('id',$id)->update($data);
    }

    public function deleteNotice($id){
        return $this->where('id',$id)->delete();
    }

    public function batch(){
        return $this->hasOne(Batch::class,'id','batch_id');
    }

    public function listNoticeForStudent($batch_id){
        return $this->where('batch_id',$batch_id)->orderBy('id','desc')->simplePaginate(10);
    }
}
