
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');

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

</head>
<body>
    <!-- Left Panel -->
    <?php $page="card"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-head">
                <div class="page-title">
                    <h2></h2>
                </div>
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Card</li>
                          </ol>
                        </nav>
                </div>
            </div>

    <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Card</h2></strong>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th>Subject</th>
                                        <th>1st Grading</th>
                                        <th>2nd Grading</th>
                                        <th>3rd Grading</th> 
                                        <th>4th Grading</th>
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
                        </div>
                        <div class="col-3" style="float: right;">
                            <div class="form-group">
                                        <?php 
                                            if(empty($over_grade)){
                                                echo '';
                                            }
                                               else ($gwa = (array_sum($over_grade)/count($over_grade)));
                                        ?>
                                <input id="" name="LRN" type="tel" class="form-control cc-exp" value="GWA:<?php echo number_format($gwa,2);?>" placeholder="" disabled>
                                        
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
