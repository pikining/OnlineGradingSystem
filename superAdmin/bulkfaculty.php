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

    header('Location: ../superAdmin/createFaculty.php');
    exit();
}

if(isset($_POST['import_file'])){



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
            

            $skip_row = ["3","4"];
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

                for($x=0 ; $x <= 5;$x++){
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


                $faculty_id = NULL;
                $qry = mysqli_query($con,"SELECT Id,fid FROM tblfaculty WHERE fid ='".$line[0]."' LIMIT 1");
                if($qry){
                    $num = mysqli_num_rows($qry);
                    if($num > 0){
                        while($res = mysqli_fetch_assoc($qry)){
                            $faculty_id = $res['Id'];
                        }
                    }
                }


                try{
                    $inserted = mysqli_query($con,"INSERT INTO tblfaculty (Id,fid,lname,fname,mname,designation,password,dateCreated) VALUES('".$faculty_id."','".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."','".$line[4]."','".$line[5]."','".date("Y-m-d H:i:s")."') ON DUPLICATE KEY UPDATE lname=VALUES(lname), fname = VALUES(fname), mname = VALUES(mname), designation= VALUES(designation)");
                    
                   
                    if(mysqli_affected_rows($con) == 1) { $faculty_id = mysqli_insert_id($con); }

                    
                
                    $entry = false;
                    if($inserted){
                        $entry = true;

                        $inserted = mysqli_query($con,"INSERT  INTO tbladmin (userId,staffId,fullName,staffpass,adminTypeId,dateCreated) VALUES('".$faculty_id."','".$line[0]."', '".$line[2].' '.$line[1]."','".$line[5]."','4','".date("Y-m-d H:i:s")."') ON DUPLICATE KEY UPDATE fullName=VALUES(fullName) ");

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




 