<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'batch_id',
        'created_by',
        'user_type',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function listUser(){
        return $this->where([['id','!=',Auth::user()->id],['user_type','1']])->orderBy('id','desc')->simplePaginate(10);
    }

    public function allUser(){
        return $this->where([['id','!=',Auth::user()->id],['user_type','1']])->orderBy('id','desc')->get();
    }

    public function EditUser($id){
        return $this->where('id',$id)->first();
    }

    public function updateUser($data,$id){
        return $this->where('id',$id)->update($data);
    }

    public function deleteUser($id){
        return $this->where('id',$id)->delete();
    }

    public function batch(){
        return $this->hasOne(Batch::class,'id','batch_id');
    }

    public function allUserByBatch($id){
        return $this->where('batch_id',$id)->orderBy('id','desc')->get();
    }

    public function allUserExceptByBatch($ids,$batchId){
        return $this->whereNotIn('id',$ids)->where('batch_id',$batchId)->orderBy('id','desc')->get();
    }
}
