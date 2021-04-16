<?php

class Helper
{
    public static function getAttendance($attendance,$batch_id,$subject_id) {
        $attendances = $attendance->listAttendanceByBatchIdSubjectId($batch_id,$subject_id);
        $dates = $data = $tdData = [];
        foreach ($attendances as $key => $value) {
            $data[$value['date']][] = [
                'user_name' => $value->user->name,
                'user_id' => $value->user_id,
                'attended' => $value->attended
            ];
        }
        foreach ($data as $key => $value) {
            $dates[] = $key;
            foreach ($value as $k => $val) {
                $tdData[$val['user_id'].'_'.$val['user_name']][] = [
                    'date' => $key,
                    'user_name' => $val['user_name'],
                    'user_id' => $val['user_id'],
                    'attended' =>$val['attended']
                ];
            }
        }
        array_unshift($dates,"Student Name");

        $html ='<thead><tr>';
        foreach ($dates as $key => $value) {
            $html .='<th>'.$value.'</th>';
        }
        $html .='</thead></tr><tbody>';
        
        foreach ($tdData as $key => $value) {
            $getKey = explode('_', $key);
            $html .='<tr><td>'.$getKey[1].'</td>';
            foreach ($value as $k => $val) {
                $attended ='';
                if($val['attended'] == 0){
                    $attended ='Absent';
                }else{
                    $attended ='Present';
                }
                $html .='<td>'.$attended.'</td>';
            }
            $html .='</tr>';
        }
        $html .='</tbody>';
        return $html;
    }

    

    public static function getTotal($request,$subject) {
        $resultValue = $request->only('internal1','internal2','finalquiz','finalpractical','assignment');
        $subjectData = $subject->getSubjectForResult(request('subject_id'));
        $finalTotal =0;
        // var_dump($resultValue);
        // var_dump($subjectData);
        foreach ($resultValue as $key => $value) {
            if($value != 0){
                $finalTotal += $value*$subjectData[$key]/100;
            }
            
        }
        // dd($finalTotal);
        return $finalTotal;
    }

}
