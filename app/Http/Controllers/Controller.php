<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\{User,Subject};

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getSubjectsByBatch(Request $request,Subject $subject){
    	$id = request('id');
		$subjects = $subject->allSubjectByBatch($id);
		$html = '<option value="">Select Subject Name</option>';
		if($subjects){
	    	foreach ($subjects as $key => $value) {
	    		$html .= '<option value="'.$value->id.'">'.$value->name.'</option>';
	    	}
		}
    	return response()->json($html);
    }

    public function getUsersByBatch(Request $request,User $user){
        $id = request('id');
        $users = $user->allUserByBatch($id);
        $html ='';
        if($users){
            foreach ($users as $key => $value) {
                $html .= '<option value="'.$value->id.'">'.$value->name.'</option>';
            }
            
        }
        return response()->json($html);
    }

    public function getUsersByBatchLabel(Request $request,User $user){
    	$id = request('id');
    	$users = $user->allUserByBatch($id);
        $html ='';
    	if($users){
	    	foreach ($users as $key => $value) {
	    		$html .= '<label class = "checkbox-inline">
                           <input type="checkbox" name="user_id[]" value="'.$value->id.'"> '.$value->name.'&nbsp;
                        </label>';
	    	}
    	}
    	return response()->json($html);
    }
}
