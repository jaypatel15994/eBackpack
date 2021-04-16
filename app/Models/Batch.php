<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'created_by',
    ];

    public function listBatch(){
        return $this->orderBy('id','desc')->simplePaginate(10);
    }

    public function allBatch(){
        return $this->orderBy('id','desc')->get();
    }

    public function editBatch($id){
        return $this->where('id',$id)->first();
    }

    public function updateBatch($data,$id){
        return $this->where('id',$id)->update($data);
    }

    public function deleteBatch($id){
        return $this->where('id',$id)->delete();
    }
}
