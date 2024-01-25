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

    header('Location: ../teacher/createstudent.php?viewId='.$_GET['viewId']);
    exit();
}

if(isset($_POST['import_file'])){

    $grade_level = [1,2,3,4,5,6];

    $section_list = array();
    $qry = mysqli_query($con,"SELECT Id, sectionName FROM tblsection");
    if($qry){
        $num = mysqli_num_rows($qry);
        if($num > 0){
            while($res = mysqli_fetch_assoc($qry)){
                $cid = sha1($res['sectionName']);
                $section_list[$cid] = $res['Id'];
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
            

            $skip_row = ["3","9","10","11","12"];
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

                for($x=0 ; $x <= 15;$x++){
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

                
                $section_hash = sha1($line[7]);
                if(!isset($section_list[$section_hash])){
                    $output['msg'] ="Error Section not found at row: ".$row_count;
                    $output['status'] ="error";

                    result($output,'rollback');
                }

                $section_id = $section_list[$section_hash];

  
                $gender =  $line[5];
                if(!($gender == 'Male' OR $gender ==  'Female')){
                    $output['msg'] ="Error Gender is invalid at row: ".$row_count.$gender;
                    $output['status'] ="error";

                    result($output,'rollback');
                }

                $student_id = NULL;
                $qry = mysqli_query($con,"SELECT Id,LRN FROM tblstudent WHERE LRN ='".$line[0]."' LIMIT 1");
                if($qry){
                    $num = mysqli_num_rows($qry);
                    if($num > 0){
                        while($res = mysqli_fetch_assoc($qry)){
                            $student_id = $res['Id'];
                        }
                    }
                }


                try{
                    $inserted = mysqli_query($con,"INSERT  INTO tblstudent (Id,LRN,lastName,firstName,middleName,age,gender,levelId,sectionId,sessionId,father,fathernum,mother,mothernum,guardian,guardiannum,password,dateCreated) VALUES('".$student_id."','".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."','".$line[4]."','".$line[5]."','".$line[6]."','".$section_id."','".$session_list."','".$line[9]."','".$line[10]."','".$line[11]."','".$line[12]."','".$line[13]."','".$line[14]."','".$line[15]."','".date('Y-m-d H:i:s')."') ON DUPLICATE KEY UPDATE lastName=VALUES(lastName), firstName = VALUES(firstName), middleName = VALUES(middleName), age = VALUES(age), gender = VALUES(gender), levelId= VALUES(levelId), sectionId= VALUES(sectionId), sessionId= VALUES(sessionId), father= VALUES(father), fathernum= VALUES(fathernum), mother= VALUES(mother), mothernum= VALUES(mothernum), guardian= VALUES(guardian), guardiannum= VALUES(guardiannum)");
                    
                    if(mysqli_affected_rows($con) == 1) { $student_id = mysqli_insert_id($con); }
                
                    $entry = false;
                    if($inserted){
                        $entry = true;
                        $inserted = mysqli_query($con,"INSERT  INTO tblpromoted (studentId,levelId,sectionId,sessionId,dateCreated) VALUES('".$student_id."','".$line[6]."','".$section_id."','".$session_list."','".date('Y-m-d')."') ON DUPLICATE KEY UPDATE levelId=VALUES(levelId), sectionId = VALUES(sectionId), sessionId = VALUES(sessionId)");

                        $inserted = mysqli_query($con,"INSERT  INTO tbladmin (userId,staffId,fullName,staffpass,adminTypeId,dateCreated) VALUES('".$student_id."','".$line[0]."', '".$line[2].' '.$line[1]."','".$line[15]."','5','".date('Y-m-d H:i:s')."') ON DUPLICATE KEY UPDATE fullName=VALUES(fullName) ");
                    }
                   

                } catch (mysqli_sql_exception $exception) {
                    $output['msg'] ="Error Unable to save in database ".$exception." at row: ".$row_count;
                    $output['status'] ="error";      
                    result($output,'rollback');
                    exit();       
                }

                if(!$entry){
                    $output['msg'] ="Error Unable to save in database INSERT at row: ".$row_count;
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




 