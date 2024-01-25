<?php
//added
include_once('../includes/dbconnection.php');
function collect_grade($t_id,$period_id,$role_id){
    global $con;

    $table_custom_grading = [['item'=>"Inclusion",'id'=>"1"],['item'=>"Grade Category",'id'=>"2"],['item'=>"Total Points",'id'=>"4"],['item'=>"Grading Period",'id'=>"5"]];

    $section_id = '';
    $subject_id = '';
    $sql = "SELECT * FROM tblfacultyload  WHERE id ='".mysqli_real_escape_string($con,$t_id)."'";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info = $data;
                $section_id = $data['sectionId'];
                $subject_id = $data['subjectId'];
            } 
        }
        mysqli_free_result($result);
    }

    if(empty($section_id) OR empty($subject_id)){
        return array('error'=>'No Section Found!');
    }

    //get ready for student data
    $student_list = array();
    $sql = "SELECT * FROM tblpromoted as p LEFT JOIN (SELECT Id,firstName,lastName,middleName FROM tblstudent) as s ON p.studentId = s.Id WHERE p.sectionId = '".mysqli_real_escape_string($con,$section_id)."' AND p.sessionId = '".$_SESSION['global_session']."'";

    if($role_id == 5){
        $sql = "SELECT * FROM tblpromoted as p LEFT JOIN (SELECT Id,firstName,lastName,middleName,LRN FROM tblstudent) as s ON p.studentId = s.Id  WHERE p.sectionId = '".mysqli_real_escape_string($con,$section_id)."'  AND s.LRN = '".$_SESSION['staffId']."' AND p.sessionId = '".$_SESSION['global_session']."'";

    }
    if($role_id == 6){
        $sql = "SELECT * FROM tblpromoted as p LEFT JOIN (SELECT Id,firstName,lastName,middleName,guardiannum FROM tblstudent) as s ON p.studentId = s.Id    WHERE p.sectionId = '".mysqli_real_escape_string($con,$section_id)."'  AND s.guardiannum= '".$_SESSION['staffId']."' AND p.sessionId = '".$_SESSION['global_session']."'";

    }
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            while($data = mysqli_fetch_assoc($result)){
                $id = $data['Id'];
                $temp = [];
                $middle = empty(trim($data['middleName'])) ? " ".substr(trim($data['middleName']),0,1).".": "";
                $temp['full_name'] = mb_strtoupper($data['lastName'], "UTF-8"). ", ".$data['firstName']."".$middle;
                $temp['student_id'] = $id;
                

                $student_list[$id]= $temp;
            } 
        }
        mysqli_free_result($result);
    }


    //get default written or perf percentage	
	$percent_equivalent =array();
	$select_rating = "SELECT Id,title,percent,teachingId FROM tbltask_type WHERE teachingId = '".$t_id."'  ";
	$result = mysqli_query($con,$select_rating);			
	if($result){
		$num_student = mysqli_num_rows($result);
		if($num_student != 0){
			while($data_percent  = mysqli_fetch_assoc($result)){
				$id = $data_percent['Id'];
				$percent_equivalent[$id] = array('title'=>$data_percent['title'],'percent'=>$data_percent['percent']);
			}
		}
		mysqli_free_result($result);
	}


    $custom_list_header = array();
	//for custom grades
	$query = "SELECT * FROM tbltask WHERE teachingId = '".$t_id."' AND gradingperiod = '".$period_id."'";
	$result = mysqli_query($con,$query);			
	if($result){
		$num_student = mysqli_num_rows($result);
		if($num_student != 0){
			while($row  = mysqli_fetch_assoc($result)){
					$id = $row['Id'];
					$title = $row['taskname'];
					$extra = '';
					
					$p_id = $row['tasktype'];
					$percent = array('',0);
					if(isset($percent_equivalent[$p_id])){
						$percent[0] =  $percent_equivalent[$p_id]['title'];
						$percent[1] =  $percent_equivalent[$p_id]['percent']; 
					}
				
				$custom_list_header[$id] = array('title'=>$title,'term'=>$row['gradingperiod'],'highest'=>$row['highest'],'p_id'=>$p_id,'p_title'=>$percent[0],'p_percent'=>$percent[1],'passing'=>$row['passing'],'flagvisible'=>$row['flagvisible']);
			}
			
		}
		mysqli_free_result($result);
	}



    foreach($custom_list_header as $index=>$value){        
        $table_custom_grading[0] =  array_merge($table_custom_grading[0],array('custom_'.$index => $value['flagvisible'])); //visible
        $table_custom_grading[1] =  array_merge($table_custom_grading[1],array('custom_'.$index => $value['p_id'])); //category
        $table_custom_grading[2] =  array_merge($table_custom_grading[2],array('custom_'.$index => $value['highest'])); // Total Points
        $table_custom_grading[3] =  array_merge($table_custom_grading[3],array('custom_'.$index => $value['term'])); // Grading Period
    }


    $table_student = array();
    foreach($student_list as $student_id => $student){
		
		$temp_log =array();
		$temp_log['id']= $student_id;
		$temp_log['student_id']= $student_id;
		$temp_log['student_name']= $student['full_name'];

        $table_student[$student_id]  = $temp_log;   
		$data_logs =array();
        foreach($custom_list_header as $id=>$data_logs){
			$grade_type = "CUSTOM";
			$total = $data_logs['highest'];

			
			$table_student[$student_id]['custom_'.$id] = array("class_exam_id"=>$id,"update_id"=>"","id_user"=>$student_id,"grade"=>0,"total"=>$total,"datein"=>"","status"=>"", "term"=>$period_id, "title"=>$data_logs['title'],"grade_type"=>$grade_type,'percent_id'=>$data_logs['p_id'],'flag_visible'=>$data_logs['flagvisible']);
		}


    }

    //set grades
	if(!empty($custom_list_header)){
		$class_standing=array();
		$add_student= "";

		$query = "SELECT tk.Id,tk.tasktype,tk.gradingperiod,tk.teachingId,tk.highest,tk.passing,tk.flagvisible,gd.gradeId,gd.studentId,gd.score,gd.taskId,gd.dateCreated FROM tbltask as tk INNER JOIN (SELECT * FROM tblgrading)  as gd ON tk.Id = gd.taskId WHERE tk.teachingId = '".$t_id."'";
		$result = mysqli_query($con,$query);			
        if($result){
			$num_student = mysqli_num_rows($result);
			if($num_student != 0){
				while($data_logs  = mysqli_fetch_assoc($result)){
					$student_id = $data_logs['studentId'];
					$key = $data_logs['Id'];
					$unique_id = $data_logs['gradeId'];
					$grade_type = "CUSTOM";
					
					
					if(isset($table_student[$student_id])){ // add details for student
						if (isset($table_student[$student_id]['custom_'.$key])){
							$table_student[$student_id]['custom_'.$key] = array("class_exam_id"=>$key,"update_id"=>$unique_id,"id"=>$unique_id,"id_user"=>$student_id,"data_type"=>0,"grade"=>$data_logs['score'],"total"=>$data_logs['highest'],"datein"=>$data_logs['dateCreated'],"status"=>"", "term"=>$custom_list_header[$key]['term'],"title"=>$custom_list_header[$key]['title'],"grade_type"=>$grade_type,'percent_id'=>$custom_list_header[$key]['p_id'],'flag_visible'=>$custom_list_header[$key]['flagvisible']);
							$table_custom_grading[2]['custom_'.$key] =  $data_logs['highest'];
						
						}
					}
					
				}
				
			}
			mysqli_free_result($result);
		}
	
	}


 
    //computing grades, final touch with table_student
    $table_header = []; 
    $table_header[$period_id] = []; 
foreach($table_student as $index=>&$val){ //each loop is student
	$grade =0;
	$sort_grades = [];

    $table_header = []; 
    $table_header[$period_id] = []; 
    $table_main_header = [];
	$sort_grades = []; 
    $sort_grades[$period_id] = []; 
	foreach ($val as $field_id=> $value	) { // per activity
        if (is_array($value)) { 
		
            $percent_id = $value['percent_id'];
            $term = $period_id;
			
            //collect table header
			if(!isset($table_header[$term][$percent_id][$field_id])){
				$table_header[$term][$percent_id][$field_id]= array('title'=>$value['title'],'total'=>$value['total'],'flag_visible'=>$value['flag_visible'],'mark'=>0);
			}
			
            $value['total_temp'] = ($value['total'] == 0) ? 1 : $value['total'];
			$compute = ($value['grade']/$value['total_temp'])*100;
			
            //collect grades per percentage id
			if(isset($sort_grades[$term][$percent_id])){
				$sort_grades[$term][$percent_id][0][]= $compute;
                $sort_grades[$term][$percent_id][1][]= $value['grade'];
			}else{
				$sort_grades[$term][$percent_id][0] = array($compute);
                $sort_grades[$term][$percent_id][1] = array($value['grade']);
			}
            
            // //collect table main header
			// if(!isset($table_main_header[$term][$percent_id][$field_id])){
			// 	$table_main_header[$term][$percent_id][$field_id]= array('title'=>$value['title'],'total'=>$value['total'],'flag_visible'=>$value['flag_visible']);
			// }
			
        }   
    }

        $total_grades[$period_id] = array(0);
        //calculate total group by percentage
            foreach($sort_grades[$period_id] as $percent_id=>$data){
                $grade = $data[0];
                $score = $data[1];
                
                $percent = isset($percent_equivalent[$percent_id]['percent']) ? $percent_equivalent[$percent_id]['percent'] : 0;
                $ps = (array_sum($grade)/count($grade));
                $wa = $ps*($percent/100);
                $total = array_sum($score);
                $table_header[$period_id][$percent_id]['title'] = $percent_equivalent[$percent_id]['title']." (".$percent."%)";


                $table_header[$term][$percent_id]['total_'.$percent_id]= array('title'=>'Total','total'=>$total,'flag_visible'=>$value['flag_visible'],'mark'=>1);
                $table_header[$term][$percent_id]['ps_total_'.$percent_id]= array('title'=>'PS','total'=>$ps,'flag_visible'=>$value['flag_visible'],'mark'=>1);
                $table_header[$term][$percent_id]['wa_total_'.$percent_id]= array('title'=>'WA','total'=>$wa,'flag_visible'=>$value['flag_visible'],'mark'=>1);
                $val['total_'.$percent_id] =  $total;
                $val['ps_total_'.$percent_id] =  number_format($ps);
                $val['wa_total_'.$percent_id] =  number_format($wa,2);
                // $table_main_header[$period_id][$percent_id]['title'] = $percent_equivalent[$percent_id]['title']." (".$percent."%)";
                $total_grades[$period_id]['wa_'.$percent_id] = $wa;
            }

        
    
        $val['initial_grade'] =  number_format(array_sum($total_grades[$period_id]),0);
        $val['quarter_grade'] =  0;
    

}


    $table_project = array();
    $table_project['table_array'] = $table_student;
    $table_project['category_header'] = $table_custom_grading;
    $table_project['header_edit'] = $custom_list_header;
    $table_project['table_header'] = $table_header;

    // print_r($table_project);
    // exit();
    return $table_project;
}

?>