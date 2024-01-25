
<?php
//added 
include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

$levelId ="";
$section_name ="";
if(isset($_GET['viewId'])){
    $_SESSION['viewId'] = $_GET['viewId'];
    $query =mysqli_query($con, "SELECT * FROM tblsection WHERE Id = '".$_SESSION['viewId']."' ");
    if($row = mysqli_fetch_assoc($query)){
        if($row){
            //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
            $section_name = $row['sectionName'];
            $levelId = $row['levelId'];
        }
    }
}

$student_name = "";
if(isset($_GET['cardid'])){

    $_SESSION['cardid'] = $_GET['cardid'];
    
    $query =mysqli_query($con, "SELECT p.studentId,p.sessionId,s.firstName,s.middleName,s.lastName,s.gender,s.Id,s.age FROM tblpromoted as p LEFT JOIN (SELECT Id, firstName,middleName,lastName,age,gender  FROM tblstudent) as s ON p.studentId = s.Id WHERE p.studentId='".mysqli_real_escape_string($con,$_GET['cardid'])."' AND p.sessionId = '".$_SESSION['global_session']."'");
    if($row= mysqli_fetch_assoc($query)){
        if($row ){
            $student_name = $row['firstName'].' '.strtoupper(substr($row['middleName'], 0, 1)).'. '.$row['lastName'] ;
            $age= $row['age'];
            $gender = $row['gender'];
        }
        mysqli_free_result($query);
    }
    $row = $faculty_data;
}

if(isset($_POST['attendance'])){

    $alertStyle ="";
     $statusMsg="";
   
   $month=$_POST['month'];
   $schoolday=$_POST['schoolday'];
   $day_present=$_POST['day_present'];
   $day_absent=$_POST['day_absent'];
   $sessionId=$_POST['sessionId'];
   $dateCreated = date("Y-m-d");
   
    $query=mysqli_query($con,"SELECT * FROM tblattendance where studentId ='".$_GET['cardid']."', month = '".$month."' , sessionId = $sessionId");
    $ret=mysqli_fetch_array($query);
   
   if($ret > 0){
   
     $alertStyle ="error";
     $statusMsg="Student with the LRN already exist!";
   
   }
   else{
   
   $query=mysqli_query($con,"INSERT INTO tblattendance(studentId,month,schoolday,day_present,day_absent,sessionId,dateCreated) 
   VALUES('".$_GET['cardid']."','".$month."','".$schoolday."','".$day_present."','".$day_absent."','".$sessionId."','".$dateCreated."') ON DUPLICATE KEY UPDATE schoolday= VALUES(schoolday), day_present= VALUES(day_present), day_absent= VALUES(day_absent)");
   $rowi = mysqli_fetch_array($query);
   if ($query) {
   
     $alertStyle ="success";
     $statusMsg="Attendance Added Successfully!";
   }
   else
   {
     $alertStyle ="error";
     $statusMsg="An error Occurred!";
   }
   }
   }

   if(isset($_POST['students_grade'])){

    $alertStyle ="";
     $statusMsg="";
   
   $subjectId=$_POST['subjectId'];
   $period=$_POST['period'];
   $grade=$_POST['grade'];
   
   $query=mysqli_query($con,"INSERT INTO tblquartergrade(teachingId,student_Id,period,grade) 
   VALUES('".$subjectId."','".$_GET['cardid']."','".$period."','".$grade."') ON DUPLICATE KEY UPDATE grade= VALUES(grade)");
   
if ($query) {
   
    $alertStyle ="success";
    $statusMsg="Grade Added Successfully!";
  }
  else
  {
    $alertStyle ="error";
    $statusMsg="An error Occurred!";
  }
   
   }
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
    <?php $page="grade_list"; include 'includes/Advisee_menu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-heads">
                <div class="page-title">
                    <h2> <?php echo $student_name;?></h2>
                </div>
            </div>

    
            <div class="content">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Report on a Attendance</h2></strong>
                        </div>
                        <div class="card-body">
                            <div class="bulk">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#attendance" name="submit" class="btn "><i class="lar la-calendar la-lg" ></i> Add Attendance</button>
                            </div>
                            <br>
                            <div class="table-reponsive">
                                <table  class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>No. of School Days</th>
                                                <th>No. of Days Present</th>
                                                <th>No. of Day Absent</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $query=mysqli_query($con,"SELECT * FROM tblattendance WHERE studentId = '".$_GET['cardid']."' ORDER BY dateCreated");
                                            while ($row=mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                        <td ><?php  echo $row['month'];?></td>  
                                        <td ><?php  echo $row['schoolday'];?></td>
                                        <td ><?php  echo $row['day_present'];?></td>
                                        <td ><?php  echo $row['day_absent'];?></td>
                                        <td><a href="editattendance.php?editattendance=<?php echo $row['Id'];?>" title="Edit Details" data-bs-toggle="modal" data-bs-target="#editattendance"><i class="las la-edit"></i></a>
                                        <a class="delete" data-href="deletepromoted.php?delid=<?php echo $row['pId'];?>&viewId=<?php echo $_SESSION['viewId'];?>&aId=<?php echo $_GET['aId'];?>" title="Delete Student Details"><i class="las la-trash-alt"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card">
                    <div class="card-header">
                        <strong class="card-title"><h2 align="center">Report on Learning Progress and Achievement</h2></strong>
                    </div>
                    <div class="card-body">
                  <!--  <div class="bulk">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#student_grade" name="submit" class="btn "><i class="las la-plus la-lg" ></i> Add a Grade</button>
                    </div><br>-->
                    <div class="table-responsive">
                        <table  class="table table-hover table-striped table-bordered" id="grade_table">
                            <thead>
                                <tr>
                                    <th>Learning Areas</th>
                                    <th>1st Grading</th>
                                    <th>2nd Grading</th>
                                    <th>3rd Grading</th> 
                                    <th>4th Grading</th>
                                    <th>Final Rating</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sectionID ="";
                                $student_id ="";
                                $query = mysqli_query($con,"SELECT tblstudent.Id,tblstudent.LRN,tblpromoted.sectionId,tblpromoted.sessionId FROM tblstudent LEFT JOIN tblpromoted ON tblstudent.Id = tblpromoted.studentId
                                WHERE tblpromoted.studentId ='".$_GET['cardid']."' AND tblpromoted.sessionId = '".$_SESSION['global_session']."' ");
    
                                if($row = mysqli_fetch_assoc($query)){
                                    if($row){
                                        //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
                                        $sectionID = $row['sectionId'];
                                        $student_id = $row['Id'];
                                    }
                                }
                            
                                $collect_subj = array();
                                $query = mysqli_query($con,"SELECT f.Id, s.subjectTitle,f.subjectId,f.sectionId FROM tblfacultyload as f LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as s ON f.subjectId = s.Id  WHERE f.sectionId = '".$sectionID."'  AND f.sessionId = '".$_SESSION['global_session']."'");

                                $cnt=1;
                                //subject ni student base sa section
                                while ($row=mysqli_fetch_array($query)) {
                                    $id = $row['Id'];
                                    if(!isset($collect_subj[$id])){
                                        $collect_subj[$id] = [];
                                    }

                                    $collect_subj[$id]['subjectTitle'] = $row['subjectTitle'];
                        
                                    $collect_subj[$id]['grade'][1] = "";
                                    $collect_subj[$id]['grade'][2] = "";
                                    $collect_subj[$id]['grade'][3] = "";
                                    $collect_subj[$id]['grade'][4] = "";
                                    
                                }

                                $keys = array_keys($collect_subj);
                                // get grades
                                $query = "SELECT gradeId,teachingId,student_id,period,grade,f.sessionId FROM tblquartergrade LEFT JOIN(SELECT id,sessionId FROM tblfacultyload) as f ON tblquartergrade.teachingId = f.id WHERE  teachingId IN (".implode(",",$keys).") AND student_id = '".$student_id."'";
                                
                                $cnt=1;
                                $ret = mysqli_query($con,$query);
                                if($ret){
                                while ($row=mysqli_fetch_array($ret)) {
                                    $id = $row['teachingId'];
                                    $period = $row['period'];
                                    $gradeId = $row['gradeId'];
                                    if(!isset($collect_subj[$id])){
                                        continue;
                                    // $collect_subj[$id][$period] = $row['grade'];
                                    }
                                    $collect_subj[$id]['grade'][$period] = $row['grade'];

                                    if(empty($row['grade'])){};
                                }}

                                //subject display with grades
                    $gwa = 0;
                    $over_grade =[];
                    foreach($collect_subj as $row){
                            $final_grade = (array_sum($row['grade'])/count($row['grade']));
                            $over_grade[] = $final_grade;
                            
                            ?>
                            <tr>
                            <td ><?php  echo $row['subjectTitle'];?></td>  
                            <td > <?php  echo $row['grade'][1];?></td>
                            <td ><?php  echo $row['grade'][2];?></td>
                            <td ><?php  echo $row['grade'][3];?></td>
                            <td ><?php  echo $row['grade'][4];?></td>
                            <td id = "finalgrade"><?php echo $final_grade;?></td>
                            <td ><?php  if ($final_grade >= 75) {
                                echo ("Passed");
                            } else {
                                echo ("Failed");
                            }};?></td>
                            </tr>
                                                    
                        </tbody>
                    </table>
                    </div>
                    <div class="col-3" style="float: right;">
                        <div class="form-group">
                            <?php 
                                if(empty($over_grade)){
                                    echo '';
                                }
                                    else ($gwa = (array_sum($over_grade)/count($over_grade)));
                            ?>
                            <input id="" name="LRN" type="tel" class="form-control cc-exp" value="General Average:<?php echo number_format($gwa,2);?>" placeholder="" disabled>
                            
                            <?php 
                            
                                if(empty($collect_subj)){
                                    echo '</tbody>
                                    </table>
                                    <div class="col-3" style="float: right;">
                                        <div class="form-group">';
                                }
                            ?>    
                        </div>
                    </div>
                </div>
        </div>
        <!-- end of datatable -->

        </div><!-- .content -->

        </div><!-- .content -->

<div class="clearfix"></div>

</main>
<!-- FOOTER-->
    <?php include 'includes/footer.php';?>
<!-- END OF FOOTER-->

</div><!-- /#right-panel -->

<!-- MODAL -->
<div class="modal fade" id="editattendance" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="col-12 modal-title text-center" id="exampleModalLongTitle" >ATTENDANCE</h5>
      </div>
      <form method="POST" action="" >
      <div class="modal-body">
        <div class="mb-3">
            <label for="cc-exp" class="form-label">Month:</label>
            <select Required id="month" name="month"  class="form-select">
                <option value="">Select Category</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="cc-exp" class="form-label">No. of School Days:</label>
            <input type="text" class="form-control cc-exp" value="" id="schoolday" name="schoolday" placeholder="">
        </div>
        <div class="row">
            <div class="col-auto">
                <label for="cc-exp" class="form-label">No. of Days Present:</label>
                <input type="text" class="form-control cc-exp" value="" id="present" name="day_present" placeholder="">
            </div>
            <div class="col-auto">
                <label for="cc-exp" class="form-label">No. of Days Absent:</label>
                <input type="text" class="form-control cc-exp" value="" id="absent" name="day_absent" placeholder="">
            </div>
        </div>
        <div class="row">
        <div class="mb-3">
            <label for="cc-exp" class="form-label">No. of School Days:</label>
                <?php 
                    $query=mysqli_query($con,"select * from tblsession where isActive = '1' ORDER BY id ASC");                        
                    $count = mysqli_num_rows($query);
                    if($count > 0){                       
                        echo ' <select required id="year" name="sessionId" class="form-select">';
                        echo'<option value="">Select Session</option>';
                        while ($row = mysqli_fetch_array($query)) {
                            echo'<option value="'.$row['Id'].'" >'.$row['sessionName'].'</option>';
                        }
                        echo '</select>';
                        }
                ?>   
            </div></div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="attendance" id="send">Add</button>
      </div>
        </form>
    </div>
  </div>
</div>


<div class="modal fade" id="attendance" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="col-12 modal-title text-center" id="exampleModalLongTitle" >ATTENDANCE</h5>
      </div>
      <form method="POST" action="" >
      <div class="modal-body">
        <div class="mb-3">
            <label for="cc-exp" class="form-label">Month:</label>
            <select Required id="month" name="month"  class="form-select">
                <option value="">Select Category</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="cc-exp" class="form-label">No. of School Days:</label>
            <input type="text" class="form-control cc-exp" value="" id="schoolday" name="schoolday" placeholder="">
        </div>
        <div class="row">
            <div class="col-auto">
                <label for="cc-exp" class="form-label">No. of Days Present:</label>
                <input type="text" class="form-control cc-exp" value="" id="present" name="day_present" placeholder="">
            </div>
            <div class="col-auto">
                <label for="cc-exp" class="form-label">No. of Days Absent:</label>
                <input type="text" class="form-control cc-exp" value="" id="absent" name="day_absent" placeholder="">
            </div>
        </div>
        <div class="row">
        <div class="mb-3">
            <label for="cc-exp" class="form-label">No. of School Days:</label>
                <?php 
                    $query=mysqli_query($con,"select * from tblsession where isActive = '1' ORDER BY id ASC");                        
                    $count = mysqli_num_rows($query);
                    if($count > 0){                       
                        echo ' <select required id="year" name="sessionId" class="form-select">';
                        echo'<option value="">Select Session</option>';
                        while ($row = mysqli_fetch_array($query)) {
                            echo'<option value="'.$row['Id'].'" >'.$row['sessionName'].'</option>';
                        }
                        echo '</select>';
                        }
                ?>   
            </div></div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="attendance" id="send">Add</button>
      </div>
        </form>
    </div>
  </div>
</div>


<div class="modal fade " id="student_grade" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="col-12 modal-title text-center" id="exampleModalLongTitle" >Add a Grade</h5>
      </div>
      <form method="POST" action="" >
      <div class="modal-body">
        <div class="mb-3">
            <label for="x_card_code" class="control-label mb-1">Subject:</label>
            <?php 
                $query=mysqli_query($con,"SELECT fl.Id as fid ,fl.sectionId,fl.subjectId,s.subjectTitle FROM tblfacultyload as fl LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as s ON fl.subjectId = s.Id WHERE fl.sectionId = '".$_GET['viewId']."' AND sessionId = '".$_SESSION['global_session']."'");                        
                $count = mysqli_num_rows($query);
                if($count > 0){                       
                    echo ' <select required name="subjectId" class="form-select">';
                    echo'<option value="">Select Subject</option>';
                    while ($row = mysqli_fetch_array($query)) {
                        echo'<option value="'.$row['fid'].'" >'.$row['subjectTitle'].'</option>';
                    }
                    echo '</select>';
                }
            ?>   
        </div>
        <div class="row">
            <div class="col-6">
                <label for="cc-exp" class="form-label">Grading Period:</label>
                <select Required id="period" name="period"  class="form-select">
                    <option value="">Select Category</option>
                    <option value="1">1st Grading</option>
                    <option value="2">2nd Grading</option>
                    <option value="3">3rd Grading</option>
                    <option value="4">4th Grading</option>
                </select>
            </div>
            <div class="col-6">
                <label for="cc-exp" class="form-label">Student Grade:</label>
                <input type="text" class="form-control cc-exp" value="" id="grade" name="grade" placeholder="">
            </div>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="students_grade" id="send">Add</button>
      </div>
        </form>
    </div>
  </div>
</div>

<!-- SCRIPT-->

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
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
    <script>
        $("#month").selectize({});
        $("#year").selectize({});
    </script>


<script type="text/javascript">
    $(document).ready(function() {
      $('#bootstrap-data-table-export').DataTable();
  } );

  
</script>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if(isset($statusMsg)){
?>
<script>
    Swal.fire({
        title: '<?php echo $statusMsg;?>',
        icon: '<?php echo $alertStyle;?>',
        //button:'Ok'
        timer: 1300
    })
</script>

<?php
    unset($statusMsg);
}
?>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="dist/jquery.tabledit.js"></script>
<script type="text/javascript" src="custom_table_edit.js"></script>
<!-- END OF SCRIPT-->

</body>
</html>
