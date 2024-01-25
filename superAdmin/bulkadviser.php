<?php
include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(1);
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

    header('Location: ../superAdmin/createAdviser.php');
    exit();
}

if(isset($_POST['import_file'])){

    $grade_level = [1,2,3,4,5,6];

    $section_list = array();
    $qry = mysqli_query($con,"SELECT Id, sectionName, levelId FROM tblsection");
    if($qry){
        $num = mysqli_num_rows($qry);
        if($num > 0){
            while($res = mysqli_fetch_assoc($qry)){
                $cid = sha1($res['sectionName']);
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
    $query1 =[];
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
            while (($line = fgetcsv($csvFile, 0, ",")) !== FALSE) { //get data per row


                if($row_count == 0){
                    $row_count++;
                    continue;
                }

                for($x=0 ; $x <= 2;$x++){
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

                try{
                    $inserted = mysqli_query($con,"INSERT  INTO tbladviser (teacherId,sectionId,sessionId) VALUES('".$teacher_id."','".$section_id."','".$session_list."') ON DUPLICATE KEY UPDATE teacherId=VALUES(teacherId), sectionId = VALUES(sectionId), sessionId = VALUES(sessionId)");
                    
                    $query1[] = "INSERT  INTO tbladviser (teacherId,sectionId,sessionId) VALUES('".$teacher_id."','".$section_id."','".$session_list."') ON DUPLICATE KEY UPDATE teacherId=VALUES(teacherId), sectionId = VALUES(sectionId), sessionId = VALUES(sessionId)";


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
                $output['query'] = $query1;
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




 