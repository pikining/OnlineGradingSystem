
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

$glevel ="";
$section_name ="";
$sectionId ="";
if(isset($_GET['viewId'])){
    $_SESSION['viewId'] = $_GET['viewId'];
    $query =mysqli_query($con, "SELECT * FROM tblsection WHERE Id = '".$_SESSION['viewId']."' ");
    if($row = mysqli_fetch_assoc($query)){
        if($row){
            //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
            $section_name = $row['sectionName'];
            $glevel = $row['levelId'];
            $sectionId = $row['Id'];
        }
    }
}
$aId = isset($_GET['aId']) ? trim($_GET['aId']) : '';
$viewId = isset($_GET['viewId']) ? trim($_GET['viewId']) : '';
$activesession ="";
$query = mysqli_query($con,"SELECT * FROM tblsession WHERE isActive ='1'");
if($row = mysqli_fetch_assoc($query)){
    if($row){
        //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
        $activesession = $row['Id'];
    }
}

if(isset($_POST['submit'])){

 $alertStyle ="";
  $statusMsg="";

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$middlename=$_POST['middlename'];
$age=$_POST['age'];
$gender=$_POST['gender'];
$lrn=$_POST['lrn'];
$father=$_POST['father'];
$fathernum=$_POST['fathernum'];
$mother=$_POST['mother'];
$mothernum=$_POST['mothernum'];
$guardian=$_POST['guardian'];
$guardiannum=$_POST['guardiannum'];
$dateCreated = date("Y-m-d H:i:s");

$query=mysqli_query($con,"select * from tblstudent where LRN ='$lrn'");
$ret=mysqli_fetch_array($query);
$query=mysqli_query($con,"select * from tbladmin where staffId ='$lrn'");
$ret=mysqli_fetch_array($query);

$pw = strtoupper(substr($firstname, 0, 1));
$pw .= strtolower(substr($lastname, 0, 1));
$pw .= rand(10000, 99999);
$pw .= "!";

$pw2 = strtoupper(substr($guardian, 0, 1));
$pw2 .= rand(10000, 99999);
$pw2 .= "!";

if(!preg_match ("/^[a-zA-Z\s]+$/", $firstname)){
    $alertStyle ="alert alert-danger";
    $statusMsg="Name should consist of only letters!";
}
else{
if($age <= 5){
    $alertStyle ="alert alert-danger";
    $statusMsg="Invalid Age!";
    }
else{
    if($ret > 0){
    
      $alertStyle ="alert alert-danger";
      $statusMsg="Student with the LRN already exist!";
    }
    else{
    
        $query=mysqli_query($con,"insert into tblstudent(firstName,lastName,middleName,age,gender,LRN,password,levelId,sectionId,sessionId,father,fathernum,mother,mothernum,guardian,guardiannum,dateCreated) 
        value('".$firstname."','".$lastname."','".$middlename."','".$age."','".$gender."','".$lrn."','".$pw."','".$glevel."','".$sectionId."','".$activesession."','".$father."','".$fathernum."','".$mother."','".$mothernum."','".$guardian."','".$guardiannum."','".$dateCreated."')");
        if($query){
            $last_id = mysqli_insert_id($con);
        
    //Student
    $query=mysqli_query($con,"insert into  tbladmin (userId,fullName,staffid,staffpass,adminTypeId,dateCreated) 
        VALUES ('$last_id','$firstname $lastname','$lrn','$pw','5','$dateCreated')");
    //promote last_id as student id
    $query=mysqli_query($con,"insert into  tblpromoted (studentId,levelId,sectionId,sessionId,adviseeId,dateCreated) 
        VALUES ('".$last_id."','".$glevel."','".$sectionId."','".$activesession."','".$aId."','".$dateCreated."')");
        }
    //
    
        if ($query) {
        
          echo "<script type = \"text/javascript\">
                window.location = (\"viewstudent.php?viewId=$viewId&aId=$aId\");
                </script>";
        }
        else
        {
          $alertStyle ="alert alert-danger";
          $statusMsg="An error Occurred!";
        }
    }
 } 
}
}

// if(isset($_POST['form_submit'])){


// if(isset( $_FILES['csv'] )) :
//     $csv_file = $_FILES['csv']['tmp_name'];
//     if(is_file( $csv_file)) :
//         $counter = 0;
//       if(($handle = fopen($csv_file,"r")) !== FALSE) :
//          while (($csv_data = fgetcsv($handle, 1000, ",")) !== FALSE)  {
//             if($counter == 0){
//                 //skip headers
//                 counter++;
//                 continue;
//             }
//         print_r($csv_data);
       
//          $num = count($csv_data);
//           for ($c=0; $c < $num; $c++):
//             $colum[$c] = $csv_data[$c]; 
//           endfor;         
//           $inserted= mysqli_query($con,"INSERT INTO tblstudent (LRN,lastName,firstName,middleName,age,gender,levelId,sectionId,sessionId,father,fathernum,mother,mothernum,guardian,guardiannum,password)
//            VALUES('".$colum[0]."','".$colum[1]."','".$colum[2]."','".$colum[3]."','".$colum[4]."','".$colum[5]."','".$colum[6],."','$colum[7]','$colum[8]','$colum[9]','$colum[10]','$colum[11]','$colum[12]','$colum[13]','$colum[14]','$colum[15]')");

//            echo "INSERT INTO tblstudent (LRN,lastName,firstName,middleName,age,gender,levelId,sectionId,sessionId,father,fathernum,mother,mothernum,guardian,guardiannum,password)
//            VALUES('$colum[0]','$colum[1]','$colum[2]','$colum[3]','$colum[4]','$colum[5]','$colum[6]','$colum[7]','$colum[8]','$colum[9]','$colum[10]','$colum[11]','$colum[12]','$colum[13]','$colum[14]','$colum[15]')";
//            exit();
//          }


//          $msg = "Data uploaded successfully.";
//          fclose($handle);
//       else :
//         $msg = "unable to read the format try again";
//       endif;
//     else :
//       $msg = "CSV format File not found";
//     endif;
//   else :
//       $msg = "Please try again.";
//   endif;
//   echo $msg;
// }
?>

<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include '../includes/title.php';?>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link  rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <link rel="stylesheet" href="../assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.css" integrity="sha512-pZE3NzBgokXUM9YLBGQIw99omcxiRdkMhZkz0o7g0VjC0tCFlBUqbcLKUuX8+jfsZgiZNIWFiLuZpLxXoxi53w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- Left Panel -->
    <?php $page="newstudent"; include 'includes/Advisee_menu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-head">
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Advisee</li>
                                <li class="breadcrumb-item">Student</li>
                                <li class="breadcrumb-item active" aria-current="page">Add New Student</li>
                            </ol>
                        </nav>
                </div>
            </div>

            
    <div class="content">
            <div class="bulk">
                <button type="button" data-bs-toggle="modal" data-bs-target="#bulk" name="submit" class="btn "><i class="las la-file-upload" ></i> Bulk Insert</button>
            </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Add New Student in <?php echo $section_name;?></h2></strong>
                        </div>
                        <form method="Post" action="" id="add_form_student">
                        <div class="card-body">
                            <!-- Credit Card -->
                                <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                <h3>Student Details</h3> <hr color="black">
                                   
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Firstname <span style="color:red;">*</span></label>
                                                    <input id="first" name="firstname" type="text" class="form-control cc-exp" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                    <!--value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>"-->
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Middlename</label>
                                                    <input id="middle" name="middlename" type="text" class="form-control cc-exp" value="<?= isset($_POST['middlename']) ? $_POST['middlename'] : ''; ?>" placeholder="">
                                                    <!--value="<?= isset($_POST['middlename']) ? $_POST['middlename'] : ''; ?>"-->
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label for="x_card_code" class="control-label mb-1">Lastname<span style="color:red;">*</span></label>
                                                    <input id="last" name="lastname" type="text" class="form-control cc-cvc" value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="">
                                                    <!--value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>"-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="x_card_code" class="control-label mb-1">Age <span style="color:red;">*</span></label>
                                                    <input id="" name="age" type="text" class="form-control cc-cvc" value="<?= isset($_POST['age']) ? $_POST['age'] : ''; ?>" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="">
                                                    <!--value="<?= isset($_POST['age']) ? $_POST['age'] : ''; ?>"-->
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Gender <span style="color:red;">*</span></label>
                                                        <select Required id="gender" name="gender"  class="form-select">
                                                            <option value="">Select Category</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Male">Male</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">LRN <span style="color:red;">*</span></label>
                                                    <input id="lrn" name="lrn" type="phone" maxlength="12" minlength="12" class="form-control cc-exp" value="<?= isset($_POST['lrn']) ? $_POST['lrn'] : ''; ?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                    <!--value="<?= isset($_POST['lrn']) ? $_POST['lrn'] : ''; ?>"-->
                                                </div>
                                            </div>
                                        </div> 

                                    <!--<div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="x_card_code" class="control-label mb-1">Grade Level</label>
                                                <?php 
                                                $query=mysqli_query($con,"select * from tbllevel where Id = '$levelId' ORDER BY id ASC");                        
                                                $count = mysqli_num_rows($query);
                                                if($count > 0){                       
                                                    echo ' <select required id="grade" name="levelId" class="form-select">';
                                                    echo'<option value="">Select Grade Level</option>';
                                                    while ($row = mysqli_fetch_array($query)) {
                                                    echo'<option value="'.$row['Id'].'" >'.$row['levelName'].'</option>';
                                                        }
                                                            echo '</select>';
                                                        }
                                                ?>    
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="x_card_code" class="control-label mb-1">Section</label>
                                                <?php 
                                                $query=mysqli_query($con,"select * from tblsection where Id = '".$_SESSION['viewId']."' ORDER BY levelId ASC");                        
                                                $count = mysqli_num_rows($query);
                                                if($count > 0){                       
                                                    echo ' <select required id="section_sel" name="section" class="form-select">';
                                                    echo'<option value="">Select Section</option>';
                                                    while ($row = mysqli_fetch_array($query)) {
                                                    echo'<option value="'.$row['Id'].'" >'.$row['sectionName'].'</option>';
                                                        }
                                                            echo '</select>';
                                                        }
                                                ?>   
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="x_card_code" class="control-label mb-1">School Year</label>
                                               <?php 
                                                    //$query=mysqli_query($con,"select * from tblsession where isActive = '1' ORDER BY id ASC");                        
                                                    //$count = mysqli_num_rows($query);
                                                    //if($count > 0){                       
                                                      //  echo ' <select required id="year" name="sessionId" class="form-select">>';
                                                        //echo'<option value="">Select Session</option>';
                                                       // while ($row = mysqli_fetch_array($query)) {
                                                       // echo'<option value="'.$row['Id'].'" >'.$row['sessionName'].'</option>';
                                                         //   }
                                                           //     echo '</select>';
                                                            //}
                                                ?>   
                                            </div>
                                        </div>
                                    </div>-->
                                    <h3>Secondary Details</h3> <hr color="black">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Father's Name</label>
                                                <input id="father" name="father" type="text" class="form-control cc-exp" value="<?= isset($_POST['father']) ? $_POST['father'] : ''; ?>"  placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                <input id="fathernum" name="fathernum" type="phone" maxlength="11" minlength="11" class="form-control cc-exp" value="<?= isset($_POST['fathernum']) ? $_POST['fathernum'] : ''; ?>"   placeholder="">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Mother's Name</label>
                                                <input id="mother" name="mother" type="text" class="form-control cc-exp" value="<?= isset($_POST['mother']) ? $_POST['mother'] : ''; ?>"   placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                <input id="mothernum" name="mothernum" type="phone" maxlength="11" minlength="11" class="form-control cc-exp" value="<?= isset($_POST['mothernum']) ? $_POST['mothernum'] : ''; ?>"  placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Guardian's Name <span style="color:red;">*</span></label>
                                                <input id="guardian" name="guardian" type="text" class="form-control cc-exp" value="<?= isset($_POST['guardian']) ? $_POST['guardian'] : ''; ?>" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-exp="Please enter a valid security code" placeholder="">
                                                </div>
                                            </div>  
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="x_card_code" class="control-label mb-1">Contact Number <span style="color:red;">*</span></label>
                                                <input id="guardiannum" name="guardiannum" type="phone" maxlength="11" minlength="11" class="form-control cc-exp" value="<?= isset($_POST['guardiannum']) ? $_POST['guardiannum'] : ''; ?>" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-exp="Please enter a valid security code" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                        <div>
                                            <button type="submit" name="submit" class="btn">Add New Student</button>
                                        </div>
                                    </form>
                                </div>
                    </div> <!-- .card -->
                </div><!--/.col-->
           

            
<!-- end of datatable -->

    </div><!-- .content -->

<div class="clearfix"></div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="../assets/js/main.js"></script>

<script src="../assets/js/lib/data-table/datatables.min.js"></script>
<script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="../assets/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="../assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
<script src="../assets/js/lib/data-table/jszip.min.js"></script>
<script src="../assets/js/lib/data-table/vfs_fonts.js"></script>
<script src="../assets/js/lib/data-table/buttons.html5.min.js"></script>
<script src="../assets/js/lib/data-table/buttons.print.min.js"></script>
<script src="../assets/js/lib/data-table/buttons.colVis.min.js"></script>
<script src="../assets/js/init/datatables-init.js"></script>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    ></script>
<!--<script>
$("#gender").val("<?= isset($_POST['gender']) ? $_POST['gender'] : ''; ?>");
$("#grade").val("<?= isset($_POST['levelId']) ? $_POST['levelId'] : ''; ?>");
$("#section_sel").val("<?= isset($_POST['section']) ? $_POST['section'] : ''; ?>");
$("#year").val("<?= isset($_POST['sessionId']) ? $_POST['sessionId'] : ''; ?>");
</script>-->
</main>
<!-- FOOTER-->
    <?php include 'includes/footer.php';?>
<!-- END OF FOOTER-->

</div><!-- /#right-panel -->
<!-- MODAL -->
<div class="modal fade" id="bulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" align="center">
        <h5 class="modal-title" id="exampleModalLongTitle">Bulk Data upload</h5>
      </div>
      <form class="bulk-form" action="<?php echo "../teacher/import_file.php?viewId=".$_GET['viewId']; ?>" enctype="multipart/form-data"  id="bulk-form" method="POST" >
      <div class="modal-body">
     
           <!-- <div class="col-12">
                <div class="form-group">
                    <label for="x_card_code" class="control-label mb-1">Import csv file :</label>
                    <input type="file" name="csv" id="csv" class="input-large">
                </div>
            </div>-->
            <div class="col-12">
                <label for="x_card_code" class="form-label">Import csv file :</label>
                <input class="form-control" type="file" id="csv" name="csv">
            </div><br>
            <div class="col-12">
                <div class="form-group">
                    <a href="../New_Students.xlsx" target="_blank" download="template">DOWNLOAD TEMPLATE</a>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="import_file" id="send">Import file</button>
      </div>
     </form>
    </div>
  </div>
</div>
<!-- SCRIPT-->


    <script>
        $("#gender").val("<?= isset($_POST['gender']) ? $_POST['gender'] : ''; ?>");
    </script>
    <script>
       // Menu Trigger
       //$("#grade").selectize({});
       //$("#year").selectize({});
       $("#gender").selectize({});
      // $("#section_sel").selectize({});
    </script>


<script type="text/javascript">
    $(document).ready(function() {
      $('#bootstrap-data-table-export').DataTable();
  } );

  
</script>



<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    let arrow = document.querySelectorAll(".arrow");
    console.log(arrow);
    for (var i = 0; i < arrow.length; i++){
        arrow[i].addEventListener("click", (e)=>{
        let arrowParent = e.target.parentElement.parentElement
            arrowParent.classList.toggle("showMenu");
        });
    }

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".la-bars");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click",()=>{
        sidebar.classList.toggle("close");
    });

</script>

<script>
<?php
if(isset($_SESSION['import_file'])){
    echo "var json_result = ".$_SESSION['import_file'].";\r\n";
?>
    Swal.fire({
        title: json_result.msg,
        icon: json_result.status,
        button:'Ok'
    });
<?php
   unset($_SESSION['import_file']);
}
?>
</script>
<script
  src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
  integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo="
  crossorigin="anonymous"></script>
  
<script>
     $(document).ready(function() {
      $('#first').on('input',function(){
         var expression= /[^a-zA-Z\s]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#middle').on('input',function(){
          var expression= /[^a-zA-Z\s]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#last').on('input',function(){
          var expression= /[^a-zA-Z\s]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#father').on('input',function(){
          var expression= /[^a-zA-Z\s]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#mother').on('input',function(){
          var expression= /[^a-zA-Z\s]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#guardian').on('input',function(){
          var expression= /[^a-zA-Z\.\s]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#mothernnum').on('input',function(){
          var expression= /[^0-9]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#fathernum').on('input',function(){
          var expression= /[^0-9]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#guardiannum').on('input',function(){
          var expression= /[^0-9]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#lrn').on('input',function(){
          var expression= /[^0-9]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- END OF SCRIPT-->

</body>
</html>
