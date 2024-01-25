<?php

// $conn = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_database)or die('Cannot open database');	
// $con=mysqli_connect("localhost", "id13019632codeastro.com", "PASS=word@codeastro.com", "id13019632_attendance");

$servername = "localhost";
$database = "u357079883_resultgrading1";
$username = "root";
$password = "";

if(function_exists('base_url')){

}else{
    function base_url(){   
        // first get http protocol if http or https
            $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? 'https://' : 'http://';
            #$base_url .= "192.168.0.100/final_lms_prod/"; #change to localhost or domain
            $base_url .= "localhost/OnlineGradingSystem/"; #change to localhost or domain
            
            return $base_url; 
    }
}

if(!defined('BASE_URL')){
    define('BASE_URL',base_url());
}

$con=mysqli_connect("$servername", "$username", "$password", "$database");
if(mysqli_connect_errno()){
    echo "Connection Fail".mysqli_connect_error(); 
}


//added
if(function_exists('faculty_load_info')){

}else{

function faculty_load_info($f_id,$t_id){
    global $con;

    if(empty($f_id) OR empty($t_id)){
        return array('error'=>'Invalid Input!');
    }

//check if teacher has access to faculty load
    $section_id = '';
    $subject_id = '';
    $f_id = mysqli_real_escape_string($con, $f_id);
    $sql = "SELECT * FROM tblfacultyload  WHERE id = '".$f_id."' AND teacherId ='".mysqli_real_escape_string($con,$t_id)."'";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info = $data;
                $section_id = $data['sectionId'];
                $subject_id = $data['subjectId'];
            } 
        }
    }

    if(empty($section_id) OR empty($subject_id)){
        return array('error'=>'No Section Found!');
    }

    $sql = "SELECT Id,sectionName FROM tblsection  WHERE id = '".$section_id."' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['section'] = $data['sectionName'];
            } 
        }
    }

    $sql = "SELECT Id,subjectTitle FROM tblsubject  WHERE id = '".$subject_id."' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['subject'] = $data['subjectTitle'];
            } 
        }
    }

    return array('success'=>$additional_info);
}


}

if(function_exists('student_load_info')){

}else{
    
function student_load_info($f_id,$t_id){
    global $con;

    if(empty($f_id) OR empty($t_id)){
        return array('error'=>'Invalid Input!');
    }

//check if teacher has access to faculty load
    $section_id = '';
    $subject_id = '';
    $additional_info = [];
    $f_id = mysqli_real_escape_string($con, $f_id);
    $sql = "SELECT * FROM tblfacultyload  WHERE id = '".$f_id."'";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info = $data;
                $section_id = $data['sectionId'];
                $subject_id = $data['subjectId'];
            } 
        }
    }

    if(empty($section_id) OR empty($subject_id)){
        return array('error'=>'No Section Found!');
    }

    $additional_info['section'] ="";
    $sql = "SELECT Id,sectionName FROM tblsection  WHERE id = '".$section_id."' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['section'] = $data['sectionName'];
            } 
        }
    }

    $additional_info['subject'] ="";
    $sql = "SELECT Id,subjectTitle FROM tblsubject  WHERE id = '".$subject_id."' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['subject'] = $data['subjectTitle'];
            } 
        }
    }
    

    return array('success'=>$additional_info);
}
}


if(function_exists('student_load_section')){

}else{
    
function student_load_section($sectionId,$session){
    global $con;

    if(empty($sectionId)){
        return array('error'=>'Invalid Input!');
    }

//check if teacher has access to faculty load
    $section_id = '';
    $subject_id = '';
    $additional_info = [];
    $sectionId = mysqli_real_escape_string($con, $sectionId);



    $sql = "SELECT * FROM tblfacultyload  WHERE sectionId = '".$sectionId."' AND sessionId ='".$session."'";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info = $data;
                $section_id = $data['sectionId'];
                $subject_id = $data['subjectId'];
            } 
        }
    }

    if(empty($section_id) OR empty($subject_id)){
        return array('error'=>'No Section Found!');
    }

    $additional_info['section'] ="";
    $sql = "SELECT Id,sectionName FROM tblsection  WHERE id = '".$section_id."' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['section'] = $data['sectionName'];
            } 
        }
    }

    $additional_info['subject'] ="";
    $sql = "SELECT Id,subjectTitle FROM tblsubject  WHERE id = '".$subject_id."' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['subject'] = $data['subjectTitle'];
            } 
        }
    }

    $additional_info['teacher_name'] ="";
    $sql = "SELECT fullName FROM tbladmin  WHERE Id = '".$additional_info['teacherId']."' AND adminTypeId = '4' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['teacher_name'] = $data['fullName'];
            } 
        }
    }

    $additional_info['adviser_name'] ="";
    $sql = "SELECT teacherId FROM tbladviser WHERE sectionId = '".$section_id."' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['adviser_id'] = $data['teacherId'];
                $sql = "SELECT fullName FROM tbladmin  WHERE Id = '".$additional_info['adviser_id']."' ";
                if($result = mysqli_query($con, $sql)){
                    $num = mysqli_num_rows($result);
                    if($num > 0){
                        if($data = mysqli_fetch_assoc($result)){
                            $additional_info['adviser_name'] = $data['fullName'];
                        } 
                    }
                }


            } 
        }
    }
    return array('success'=>$additional_info);
}
}

// $con=mysqli_connect("localhost", "root", "codeastro.com", "amsys");
    // if(mysqli_connect_errno()){
    // echo "Connection Fail".mysqli_connect_error();
    // }
    
?>
