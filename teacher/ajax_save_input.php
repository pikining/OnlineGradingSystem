<?php
//added 
include('../includes/dbconnection.php');
include('../includes/session.php');
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){
    echo "Invalid Request";
}
define('DATE_NOW',date('Y-m-d'));
define('TIME_NOW',date('H:i:s'));

header("Content-type: application/json; charset=utf-8");

$response_msg =array(
    "errors"=> "",
    "result"=>"error",
    "msg" => "",
);

function output($data){
    return json_encode($data, JSON_NUMERIC_CHECK );
}

function validate_grades($grade){
    $max = 100;
    $response_msg = array();
    $response_msg['errors'] = "";
    
    if(is_digit($grade) == false){
        $response_msg['errors']="Your  grade entry is invalid. Please input numeric only.";
        return $response_msg;
    }
    
    if($max < $grade){
        $response_msg['errors']="Your  grade entry has exceeded the maximum grade required.";
        return $response_msg;
    }
    
    if($grade < 0){
        $response_msg['errors']="You cannot input garde lower than zero.";
        return $response_msg;
    }	

    return $response_msg;
}

function is_digit($digit) {
	if(is_int($digit)) {
		return true;
	} elseif(is_string($digit)) {
		return ctype_digit($digit);
	} else {
		// booleans, floats and others
		return false;
	}
}

$action = isset($_POST['action']) ? $_POST['action']:'';
$teachingId =  isset($_POST['teachingId']) ? $_POST['teachingId']:0;

$additional_info = faculty_load_info($teachingId,$_SESSION['Id']);
if(!isset($additional_info['success'])){
    $response_msg =array(
        "errors"=> "Invalid Access",
        "result"=>"error",
        "msg" => "",
    );
    echo  output($response_msg);
    exit();
}
$additional_info = $additional_info['success'];

if($teachingId != $additional_info['id']){
    $response_msg['msg']="";
    $response_msg['errors'] = 'Altered Data, changes not allowed';
    $response_msg['result']= 'error';	
    echo output($response_msg);
    exit();
}

if($action == 'DELETE_TASK' AND !empty($additional_info['id'])){
	$taskId =  isset($_POST['id']) ? $_POST['id']:0;
	$teachingId =  isset($_POST['teachingId']) ? $_POST['teachingId'] : '';
	
	
	if (strpos($taskId, 'custom_') !== false) { //custom db
		$field_id = explode("_",$taskId);
        $update_array_field = "DELETE FROM tbltask WHERE Id = '".$field_id[1]."' AND teachingId = '".$additional_info['id']."'";
		if($result = mysqli_query($con,$update_array_field)){
			$response_msg['errors']="";
			$response_msg['msg'] = 
			$response_msg['result'] ="success";	
			echo output($response_msg);
			exit();
		}else{
			$response_msg['msg']="";
			$response_msg['errors'] = 'Unable to save';
			$response_msg['result']= 'error';	
			echo output($response_msg);
			exit();
		}


    }

}

//save inputted grade each task
if($action =="SAVE_GRADE" AND !empty($additional_info['id'])){

    $to_encode=array();
    $class_exam_id =  isset($_POST['id']) ? $_POST['id']:0; //taskID
    $grade_input =  isset($_POST['grade']) ? $_POST['grade']:0;
    $student_id =  isset($_POST['student_id']) ? $_POST['student_id']:0;
 
    
    if(!is_digit($class_exam_id)){
        $error =true;
        $response_msg['msg'] = '';
        $response_msg['errors'] = 'Invalid ID';
        $response_msg['result']= 'error';
        echo output($response_msg);
        exit();
    }
    
    
    $select_assign = "SELECT highest FROM tbltask WHERE teachingId='".$additional_info['id']."' AND Id = '".$class_exam_id."' LIMIT 1";
    $query = mysqli_query($con,$select_assign);
    
    $data_row =array();
    if($query){
        $num = mysqli_num_rows($query);
        if($num!=0){
            $data_row =mysqli_fetch_assoc($query);
        }
    }
        
    if(empty($data_row)){
        $error =true;
        $response_msg['msg'] = '';
        $response_msg['errors'] = 'Not Found';
        $response_msg['result']= 'error';
        echo output($response_msg);
        exit();
    }
    
    if( is_digit($grade_input) AND $grade_input <= $data_row['highest']){
    
    }else{
        $error =true;
        $response_msg['msg'] = '';
        $response_msg['errors'] = 'Invalid Input Grade';
        $response_msg['result']= 'error';
        echo output($response_msg);
        exit();
    }
    
    
    if( is_digit($student_id) AND $student_id  > 0){
    
    }else{
        $error =true;
        $response_msg['msg'] = '';
        $response_msg['errors'] = 'Invalid Student ID';
        $response_msg['result']= 'error';
        echo output($response_msg);
        exit();
    }
    
        if(!empty($data_row)){
            $update_sign = "INSERT INTO `tblgrading`(`taskId`, `studentId`, `score`, `dateCreated`) VALUES ('".$class_exam_id."','".$student_id."','".$grade_input."','".DATE_NOW.' '.TIME_NOW."') ON DUPLICATE KEY UPDATE score=VALUES(score),dateCreated=VALUES(dateCreated);";
        
                if(mysqli_query($con,$update_sign)){
                    if(mysqli_affected_rows($con)){
                        $response_msg['errors']="";
                        $response_msg['msg'] = 
                        $response_msg['result'] ="success";	
                        echo output($response_msg);
                        exit();
                    }
                }
        }else{
            $error =true;
            $response_msg['errors'] = 'Invalid Data!';
            $response_msg['msg'] ="retain";
            $response_msg['result'] ="error";
            echo output($response_msg);
            exit();
        }
        
        $error =true;
        $response_msg['msg'] = '';
        $response_msg['errors'] = 'Unable to saved';
        $response_msg['result']= 'error';
        echo output($response_msg);
        exit();	
}

/*===========================================
=============================================*/
//save quarter grade
if($action =="SAVE_QUARTER" AND !empty($additional_info['id'])){

    $to_encode=array();
    $grade_input =  isset($_POST['grade']) ? $_POST['grade']:0;
    $student_id =  isset($_POST['student_id']) ? $_POST['student_id']:0;    
    $term =  isset($_POST['term']) ? $_POST['term']:0;  
    

    if(!is_digit($term)){
        $error =true;
        $response_msg['msg'] = '';
        $response_msg['errors'] = 'Invalid Period';
        $response_msg['result']= 'error';
        echo output($response_msg);
        exit();
    }

    $result =  validate_grades($grade_input);
    if(empty($result['errors'])){
    
    }else{
        $error =true;
        $response_msg['msg'] = '';
        $response_msg['errors'] = $result['errors'];
        $response_msg['result']= 'error';
        echo output($response_msg);
        exit();
    }
    
    
    if( is_digit($student_id) AND $student_id  > 0){
    
    }else{
        $error =true;
        $response_msg['msg'] = '';
        $response_msg['errors'] = 'Invalid Student ID';
        $response_msg['result']= 'error';
        echo output($response_msg);
        exit();
    }
    

            $update_sign = "INSERT INTO `tblquartergrade`(`teachingId`,`student_id`,`period`, `grade`, `dateCreated`) VALUES ('".$additional_info['id']."','".$student_id."','".$term."','".$grade_input."','".DATE_NOW.' '.TIME_NOW."') ON DUPLICATE KEY UPDATE grade=VALUES(grade),dateCreated=VALUES(dateCreated);";
        
                if(mysqli_query($con,$update_sign)){
                    if(mysqli_affected_rows($con)){
                        $response_msg['errors']="";
                        $response_msg['msg'] = 
                        $response_msg['result'] ="success";	
                        echo output($response_msg);
                        exit();
                    }
                }

        
        $error =true;
        $response_msg['msg'] = $update_sign;
        $response_msg['errors'] = 'Unable to saved';
        $response_msg['result']= 'error';
        echo output($response_msg);
        exit();	
    }






?>