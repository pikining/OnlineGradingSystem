
<?php

    include('../includes/dbconnection.php');
    include('../includes/session.php');
    
    
    $principal ="";
    $query =mysqli_query($con,"SELECT * FROM tbladmin WHERE adminTypeId = '1'");
    if($row = mysqli_fetch_assoc($query)){
        if($row){
            $principal = $row['fullName'];
        }
    }


    $sectionID ="";
    $student_name="";
    $student_age="";
    $student_LRN="";
    $student_gender="";
    $student_year="";
    $student_grade="";
    $student_Id="";
    $query = mysqli_query($con,"SELECT tblpromoted.levelId,s.sessionName,tblstudent.LRN,tblstudent.firstName,tblstudent.age,tblstudent.gender,tblpromoted.sessionId,tblstudent.middleName,tblstudent.lastName,tblpromoted.sectionId,tblpromoted.studentId,tblpromoted.sessionId FROM tblstudent LEFT JOIN tblpromoted ON tblstudent.Id = tblpromoted.studentId
     LEFT JOIN (SELECT Id,sessionName FROM tblsession) as s ON tblpromoted.sessionId = s.Id WHERE LRN='".$_SESSION['staffId']."' AND tblpromoted.sessionId = '".$_SESSION['global_session']."'");

    if($row = mysqli_fetch_assoc($query)){
        if($row){
            //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
            $sectionID = $row['sectionId'];
            $student_name =ucwords($row['firstName']).' '.strtoupper(substr($row['middleName'], 0, 1)).'. '.ucwords($row['lastName']);
            $student_age=$row['age'];
            $student_LRN=$row['LRN'];
            $student_gender=$row['gender'];
            $student_year=$row['sessionName'];
            $student_grade=$row['levelId'];
            $student_Id = $row['studentId'];
        }
    }
    
    $additional_info =[];
    $additional_info['adviser_name'] = "";
    $additional_info['section'] = "";
    if(!empty($sectionID)){
        $additional_info['section'] ="";
        $sql = "SELECT Id,sectionName FROM tblsection  WHERE id = '".$sectionID."' ";
        if($result = mysqli_query($con, $sql)){
            $num = mysqli_num_rows($result);
            if($num > 0){
                if($data = mysqli_fetch_assoc($result)){
                    $additional_info['section'] = $data['sectionName'];
                } 
            }
        }

        $additional_info['adviser_name'] ="None";
        $sql = "SELECT teacherId FROM tbladviser WHERE sectionId = '".$sectionID."' ";
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
    <style> 
        .underline{
            text-decoration-line: underline;
        }
    </style>
</head>
<body>
    <!-- Left Panel -->
    <?php $page="dashboard"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
        <!-- Content -->
            <div class="content">
                <!--<div class="col-lg-12">
                    <?php
                    if(!empty($sectionID)){
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h3 align="center"><b>Section: <?php echo $additional_info['section'];?><br>
                            Adviser : <?php echo $additional_info['adviser_name'];?></b></h3>
                        </div>
                    </div>
                    <?php
                    }

                    ?>
                </div>--><!-- /# column -->

                   <!--<div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-3">
                            <div class="card-body">
                                <div class="card-left pt-1 float-left">
                                    <h3 class="mb-0 fw-r">
                                        <span class="currency float-left mr-1"></span>
                                        <span class="count"><?php echo $coutAllStudentCourses;?></span>
                                    </h3>
                                    <p class="text-light mt-1 m-0">Courses</p>
                                </div>

                                <div class="card-right float-right text-right">
                                    <i class="icon fade-5 icon-lg pe-7s-notebook"></i>
                                </div>>

                            </div>

                        </div>
                    </div>-->

                    <!--<?php
                    $query = mysqli_query($con,"SELECT f.Id, a.fullName, s.subjectTitle,f.subjectId,f.sectionId FROM tblfacultyload as f LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as s ON f.subjectId = s.Id LEFT JOIN (SELECT Id,fullName FROM tbladmin) as a ON  f.teacherId = a.Id WHERE f.sectionId = '".$sectionID."' AND f.sessionId = '".$_SESSION['global_session']."'");


                    
                    while ($row=mysqli_fetch_array($query)) {    
                    ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="subject">     
                                <h2><?php echo $row['subjectTitle'];?></h2>
                                <h5><i>Teacher: <?php echo $row['fullName'];?></i></h5>
                                <a href="listofscores.php?viewId=<?php echo $row['Id'];?>" title="View Section Details"><i class="las la-info-circle"></i><i><u>View Sections</u></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                    }?>-->
                <?php
                    if(!empty($sectionID)){
                ?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="header">
                                <img src="../assets/img/calambalogo.png" width="150px" height="150px">
                                <div class="card-title" align="center"><h5>Republic of The Philippines<br> Department of Education<br> Region IV-A CALABARZON<br><strong>SCHOOLS DIVISION OF CALAMBA CITY</strong><br>District Cluster 7<br><b> Majada In Elementary School</b></h5></div>
                                <img src="../assets/img/logo.png" width="150px" height="150px">
                            </div>
                            <div class="card_body">
                                <h4>Name: <u class="underline">&nbsp;&nbsp; <?php echo $student_name;?>&nbsp;&nbsp; </u><br></h4>
                                <div class="age_sex">
                                    <div class="age"> 
                                        Age: <u class="underline">&nbsp;&nbsp;<?php echo $student_age;?>&nbsp; &nbsp;&nbsp;&nbsp;</u> &nbsp;&nbsp; 
                                    </div>
                                    <div class="sex">
                                        Sex: <u class="underline">&nbsp;&nbsp;<?php echo $student_gender;?>&nbsp; &nbsp;&nbsp;&nbsp;</u><br>
                                    </div>
                                </div>
                                <div class="grade_sec">
                                    <div class="grades">
                                        Grade: <u class="underline">&nbsp;&nbsp;<?php echo $student_grade;?>&nbsp; &nbsp;&nbsp;&nbsp;</u> &nbsp;&nbsp; 
                                    </div> 
                                    <div class="sec">  
                                        Section: <u class="underline">&nbsp;&nbsp;<?php echo $additional_info['section'];?>&nbsp; &nbsp;</u><br>
                                    </div>
                                </div>
                                <div class="sy_lrn">
                                    <div class="grades">
                                        School Year: <u class="underline">&nbsp;&nbsp;<?php echo $student_year;?>&nbsp; &nbsp;&nbsp;&nbsp;</u> &nbsp;&nbsp; 
                                    </div> 
                                    <div class="sec">  
                                        LRN: <u class="underline">&nbsp;&nbsp;<?php echo $student_LRN;?>&nbsp; &nbsp;</u><br>
                                    </div>  
                                </div>
                                <br>
                                <h4>
                                 Dear Parent: <br>
                                 &emsp;&emsp;This report card shows the ability and progress your child has made in the different learning areas as well as his/her core values.<br>
                                 &emsp;&emsp;The school welcome you should you desire to know more about your child's progress. <br><br>
                                </h4>

                                
                                
                                <div class="principal">
                                    <div class="principal_name">
                                        Principal:<u class="underline">&nbsp;&nbsp;<?php echo $principal;?>&nbsp; &nbsp;</u>
                                    </div>
                                    <div class="teacher_name"> 
                                        Teacher:<u class="underline">&nbsp;&nbsp;<?php echo $additional_info['adviser_name'];?>&nbsp; &nbsp;</u>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="table-responsive">
                                <table id="" class="table table-hover table-bordered">
                                    <h5><center>REPORT ON LEARNING PROGRESS AND ACHIEVEMENT</center></h5>
                                    <thead class="table-light">
                                        <tr>
                                        <th>LEARNING AREAS</th>
                                            <th>1st Quarter</th>
                                            <th>2nd Quarter</th>
                                            <th>3rd Quarter</th> 
                                            <th>4th Quarter</th>
                                            <th>Final Grade</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sectionID ="";
                                            $student_id ="";
                                            $query = mysqli_query($con,"SELECT tblstudent.Id,tblstudent.LRN,tblpromoted.sectionId,tblpromoted.sessionId FROM tblstudent LEFT JOIN tblpromoted ON tblstudent.Id = tblpromoted.studentId
                                            WHERE LRN ='".$_SESSION['staffId']."' AND tblpromoted.sessionId = '".$_SESSION['global_session']."' ");
                
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
                                            <td ><?php  echo $row['grade'][1];?></td>
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
                                <div class="col-3" style="float: right;">
                                    <div class="form-group">
                                                <?php 
                                                    if(empty($over_grade)){
                                                        echo '';
                                                    }
                                                    else ($gwa = (array_sum($over_grade)/count($over_grade)));
                                                ?>
                                        <input id="" name="LRN" type="tel" class="form-control cc-exp" value="General Average: <?php echo number_format($gwa,2);?>" placeholder="" disabled>
                                                
                                        <?php 
                                        
                                            //if(empty($collect_subj)){
                                              //  echo '</tbody>
                                                //</table>
                                                //<div class="col-3" style="float: right;">
                                                  //  <div class="form-group">';
                                            //}
                                        ?>    
                                    </div>
                                </div>
                            </div><br>
                            <div class="table-reponsive">
                                <table  class="table table-hover table-bordered">
                                    <h5><center>REPORT ON ATTENDANCE</center></h5>
                                        <thead class="table-light">
                                            <tr>
                                                <th>Item</th>
                                                <th>Jan.</th>
                                                <th>Feb.</th>
                                                <th>Mar.</th>
                                                <th>Apr.</th>
                                                <th>May</th>
                                                <th>June</th>
                                                <th>July</th>
                                                <th>Aug</th>
                                                <th>Sept.</th>
                                                <th>Oct.</th>
                                                <th>Nov.</th>
                                                <th>Dec.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $collect = [];
                                        $months = array(
                                            'January',
                                            'February',
                                            'March',
                                            'April',
                                            'May',
                                            'June',
                                            'July ',
                                            'August',
                                            'September',
                                            'October',
                                            'November',
                                            'December',
                                        );
                                        $collect['sd'] =[];
                                        $collect['dp'] =[];
                                        $collect['da'] =[];
                                        $collect['sd']['title'] = 'No. of School Day';
                                        $collect['dp']['title'] = 'No. of Day of Present';
                                        $collect['da']['title'] = 'No. of Day of Absent';
                                                    
                                            $query=mysqli_query($con,"SELECT * FROM tblattendance WHERE studentId = '".$student_Id."' AND sessionId = '".$_SESSION['global_session']."' ORDER BY dateCreated");
                                            while ($row=mysqli_fetch_array($query)) {
                                                $pos = array_search($row['month'], $months);
                                                if($pos!==false){
                                                    $collect['sd'][$pos] = $row['schoolday'];
                                                    $collect['dp'][$pos] = $row['day_present'];
                                                    $collect['da'][$pos] = $row['day_absent'];
                                                    
                                                    
                                                   // unset($arr[$pos]);
                                                }
                                                
                                            }

                                        foreach($collect as $ndex => $row){
                                        ?>
                                        <tr>
                                        <td ><?php  echo $row['title'];?></td> 
                                        <td ><?php  echo $row[0];?></td> 
                                        <td ><?php  echo $row[1];?></td> 
                                        <td ></td> 
                                        <td ></td> 
                                        <td ></td> 
                                        <td ></td> 
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td> 
                                        <td ></td> 
                                        <td ></td>
                                       
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
                <?php
                }else {
                    echo "<h3><center>No card Found!!!</center></h3>";
                }?>
            </div><!-- .content -->

<div class="clearfix"></div>

</main>
<!-- FOOTER-->
    <?php include 'includes/footer.php';?>
<!-- END OF FOOTER-->

</div><!-- /#right-panel -->

<!-- Right Panel -->

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

    <script>
       // Menu Trigger
        $('#menuToggle').on('click', function(event) {
        var windowWidth = $(window).width();   		 
        if (windowWidth<1010) { 
            $('body').removeClass('open'); 
            if (windowWidth<760){ 
            $('#left-panel').slideToggle(); 
            } else {
            $('#left-panel').toggleClass('open-menu');  
            } 
        } else {
            $('body').toggleClass('open');
            $('#left-panel').removeClass('open-menu');  
        } 
            
        }); 


    </script>


<script type="text/javascript">
    $(document).ready(function() {
      $('#bootstrap-data-table-export').DataTable();
  } );

  
</script>



<script src=../assets/plugins/bootstrap-sweetalert/sweetalert.min.js></script>
<script src="../_common/delete_swal.js"></script>


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

<!-- END OF SCRIPT-->
</body>

</html>