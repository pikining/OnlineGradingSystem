<?php
include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);
$output = array();
$output['msg'] ="";
$output['status'] ="";



function result($output,$action = 'commit'){
    global $con;

    $output =  json_encode($output,JSON_NUMERIC_CHECK);
    $_SESSION['import_file'] = $output;

    if($action == 'commit') {
        mysqli_commit($con);
    }else{
        mysqli_rollback($con);
    }

    header('Location: ../superAdmin/facultyload.php');
    exit();
}

if(isset($_POST['import_file'])){

    $grade_level = [1,2,3,4,5,6];
    $section_level = array();
    $section_list = array();
    $grade = "";
    $qry = mysqli_query($con,"SELECT Id, sectionName, levelId FROM tblsection");
    if($qry){
        $num = mysqli_num_rows($qry);
        if($num > 0){
            while($res = mysqli_fetch_assoc($qry)){
                $cid = sha1($res['sectionName']);
                $grade = $res['levelId'];
                $section_level[$cid] = $grade;
                $section_list[$cid] = $res['Id'];
            }
        }
    }
    

    $teacher_list = array();

    $qry = mysqli_query($con,"SELECT Id, fullName,adminTypeId FROM tbladmin WHERE adminTypeId = '4'");
    if($qry){
        $num = mysqli_num_rows($qry);
        if($num > 0){
            while($res = mysqli_fetch_assoc($qry)){
                $fid = sha1( $res['fullName']);
                $teacher_list[$fid] = $res['Id'];
            }
        }
    }

    

    $session_list = "";
    $qry = mysqli_query($con,"SELECT * FROM tblsession WHERE isActive ='1' LIMIT 1");
    if($qry){
        $num = mysqli_num_rows($qry);
        if($num > 0){
            while($res = mysqli_fetch_assoc($qry)){
                $session_list = $res['Id'];
            }
        }
    }


    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv');
   
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['csv']['name']) && in_array($_FILES['csv']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['csv']['tmp_name'])){
            $csvFile = fopen($_FILES['csv']['tmp_name'], 'r');
            
            // Skip the first line
            //fgetcsv($csvFile);
            
            $skip_row = [""];
            $found_error = true;
            $row_count = 0;

            /* Start transaction */
            mysqli_begin_transaction($con);
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile, 0, ",")) !== FALSE){
                // Get row data
                
                if($row_count == 0){
                    $row_count++;
                    continue;
                }

                for($x=0 ; $x <= 3;$x++){
                    $line[$x] = trim($line[$x]);
                    if(in_array($x,$skip_row)){
                        continue;
                    }

                    if($line[$x] == ""){
                        $output['msg'] ="Error empty value at row: ".$row_count;
                        $output['status'] ="error";

                        result($output,'rollback');
                    }
                }

                
                $section_hash = sha1($line[1]);
                if(!isset($section_list[$section_hash])){
                    $output['msg'] ="Error Section not found at row: ".$row_count;
                    $output['status'] ="error";

                    result($output,'rollback');
                }

                $section_id = $section_list[$section_hash];

  
                $teacher_hash = sha1($line[0]);
                if(!isset($teacher_list[$teacher_hash])){
                    $output['msg'] ="Error Teacher not found at row: ".$row_count;
                    $output['status'] ="error";

                    result($output,'rollback');
                }

                $teacher_id = $teacher_list[$teacher_hash];

                $date = DateTime::createFromFormat('d/m/Y H:i', $line[2]);
                
                $subject_id = $subject_list[$subject_hash];
                
                $section_hash = sha1($line[1]);
                if(!isset($section_level[$section_hash])){
                    $output['msg'] ="Error Sections not found at row: ".$row_count;
                    $output['status'] ="error";

                    result($output,'rollback');
                }

                $levelId = $section_level[$section_hash];

                $subjectId = "";
                $qry = mysqli_query($con,"SELECT Id, subjectTitle,levelId FROM tblsubject WHERE levelId = '$levelId' AND subjectTitle = '".$line[2]."'");
                if($qry){
                    $num = mysqli_num_rows($qry);
                    if($num > 0 ){
                        while($res = mysqli_fetch_assoc($qry)){
                            $subjectId = $res['Id'];
                        }
                    }
                }

                if(empty($subjectId)){
                    $output['msg'] ="Error Subjects not found at row: ".$row_count;
                    $output['status'] ="error";

                    result($output,'rollback');
                    exit();
                }
                

                try{
                    $inserted = mysqli_query($con,"INSERT  INTO tblfacultyload (teacherId,sectionId,subjectId,sessionId,dateCreated) VALUES('".$teacher_id."','".$section_id."','".$subjectId."','".$session_list."','".date('Y-m-d H:i:s')."') ON DUPLICATE KEY UPDATE teacherId=VALUES(teacherId), sectionId = VALUES(sectionId), subjectId = VALUES(subjectId), sessionId = VALUES(sessionId)");
                    
                } catch (mysqli_sql_exception $exception) {
                    $output['msg'] ="Error Unable to save in database ".$exception." at row: ".$row_count;
                    $output['status'] ="error";      
                    result($output,'rollback');
                    exit();       
                }


                $row_count++;
            }
            if($row_count <= 1){
                $output['msg'] ="Error NO data found";
                    $output['status'] ="error";      
                    result($output,'rollback');
                    exit(); 
            }

            try{
                $output['msg'] ="File Uploaded in database!";
                $output['status'] ="success"; 
                result($output,'commit');
                exit();
            } catch (mysqli_sql_exception $exception) {
                $output['msg'] ="Error Unable to commit in database ".$exception." at row: ".$row_count;
                $output['status'] ="error";      
                result($output,'rollback');
                exit();       
            }
        }

        $output['msg'] ="Error File not uploaded at row: ".$row_count;
        $output['status'] ="error";      
        result($output,'rollback');
    }
    $output['msg'] ="Invalid File type, only CSV is accepted!";
    $output['status'] ="error";      
    result($output,'rollback'); 
}

     
?>




 