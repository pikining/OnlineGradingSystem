
<?php
//added 
include('../includes/dbconnection.php');
include('../includes/session.php');

error_reporting(0);



if(isset($_GET['viewId'])){

    $_SESSION['viewId'] = $_GET['viewId'];

    $query = "SELECT * FROM tblfacultyload WHERE id = '".$_SESSION['viewId'] ."' ";
}
//added ended
?>

<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php include '../includes/title.php';?>
<meta name="description" content="Ela Admin - HTML5 Admin Template">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
<link rel="shortcut icon" href="../assets/img/student-grade.png" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
<link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
<link rel="stylesheet" href="../assets/css/lib/datatable/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/style2.css">

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->



</head>

<body>
<!-- Left Panel -->
<?php $page="listofgrades"; include 'includes/leftMenu.php';?>

<!-- /#left-panel -->

<!-- Left Panel -->

<!-- Right Panel -->

<div id="right-panel" class="right-panel">

    <!-- Header-->
        <?php include 'includes/header.php';?>
    <!-- /header -->
    <!-- Header-->

    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Dashboard</a></li>
                                <li><a href="#">List of Grades</a></li>
                                <?php $sql_query = "SELECT * FROM tblfacultyload as f LEFT JOIN (SELECT Id,sectionName FROM tblsection)as s ON f.sectionId = s.Id LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as sub ON f.subjectId = sub.Id WHERE f.id = '".$_SESSION['viewId'] ."' ";
                                $query=mysqli_query($con,$sql_query);
                                while ($row=mysqli_fetch_array($query)) {
                                ?>
                                <li><a href="#"><?php echo $row['sectionName'];?></a></li>
                                <li><a href="#"><?php echo $row['subjectTitle'];?></a></li>
                                
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Grades of <?php echo $row['sectionName']; ?>
                            <?php
                            }?></h2></strong>
                        </div>
                        <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>FullName</th>
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
                                //added 
                                $sectionID ="";
                                $student_id ="";
                                    $query = mysqli_query($con,"SELECT tblstudent.Id,tblstudent.firstName,tblstudent.lastName,tblpromoted.sectionId,tblpromoted.sessionId,tblpromoted.studentId,tblfacultyload.sectionId,tblfacultyload.id FROM tblpromoted LEFT JOIN tblstudent ON tblpromoted.studentId = tblstudent.Id LEFT JOIN tblfacultyload ON tblfacultyload.sectionId = tblpromoted.sectionId
                                    WHERE tblfacultyload.id ='".$_GET['viewId']."' AND tblpromoted.sessionId = '".$_SESSION['global_session']."' ");

        
                                    if($row = mysqli_fetch_assoc($query)){
                                        if($row){
                                            //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
                                            $sectionID = $row['sectionId'];
                                            $student_id = $row['studentId'];
                                            
                                        }
                                    }

                                $student_id =array();
                                $query = mysqli_query($con,"SELECT tblstudent.Id,tblstudent.firstName,tblstudent.lastName,p.sectionId,p.sessionId,p.studentId FROM tblpromoted as p
                                LEFT JOIN tblstudent ON p.studentId = tblstudent.Id
                                WHERE p.sectionId ='".$sectionID."' AND  p.sessionId = '".$_SESSION['global_session']."' ");
                                echo "SELECT tblstudent.Id,tblstudent.firstName,tblstudent.lastName,p.sectionId,p.sessionId,p.studentId FROM tblpromoted as p
                                LEFT JOIN tblstudent ON p.studentId = tblstudent.Id
                                WHERE p.sectionId ='".$sectionID."' AND  p.sessionId = '".$_SESSION['global_session']."' ";
                                    

                                    while ($row=mysqli_fetch_array($query)) {
                                        $id = $row['studentId'];
                                        if(!isset($student_id[$id])){
                                            $student_id[$id] = [];
                                        }

                                        $student_id[$id]['student_id'] = $row['firstName'].' '.$row['lastName'];

                                        $student_id[$id]['grade'][1] = "";
                                        $student_id[$id]['grade'][2] = "";
                                        $student_id[$id]['grade'][3] = "";
                                        $student_id[$id]['grade'][4] = "";
                                        
                                    }

                                $keys = array_keys($student_id);
                                // get grades
                                $query = "SELECT gradeId,teachingId,student_id,period,grade,f.sessionId FROM tblquartergrade LEFT JOIN(SELECT id,sessionId FROM tblfacultyload) as f ON tblquartergrade.teachingId = f.id WHERE  teachingId = '".$_SESSION['viewId']."'  AND student_id IN (".implode(",",$keys).")";
                                
                                
                                echo "SELECT gradeId,teachingId,student_id,period,grade,f.sessionId FROM tblquartergrade LEFT JOIN(SELECT id,sessionId FROM tblfacultyload) as f ON tblquartergrade.teachingId = f.id WHERE  teachingId = '".$_SESSION['viewId']."'  AND student_id IN (".implode(",",$keys).")";

                                $cnt=1;
                                $ret = mysqli_query($con,$query);
                                if($ret){
                                while ($row=mysqli_fetch_array($ret)) {
                                    $period = $row['period'];
                                    if(!isset($student_id)){
                                        continue;
                                       // $collect_subj[$id][$period] = $row['grade'];
                                    }
                                    $student_id['grade'][$period] = $row['grade'];

                                    if(empty($row['grade'])){};
                                }}

                                //subject display with grades
                                foreach($student_id as $row){
                                    $final_grade = (array_sum($row['grade'])/count($row['grade']));
                                    $studentname = $row['firstName'].' '.$row['lastName'];
                        ?> 
                            <tr>
                               <td> <?php echo $cnt;?> </td>
                               <td> <?php  echo $row['firstName'];?> <?php  echo $row['lastName'];?></td>
                               <td> <?php  echo $row['grade'][1];?></td>
                               <td> <?php  echo $row['grade'][2];?></td>
                               <td> <?php  echo $row['grade'][3];?></td>
                               <td> <?php  echo $row['grade'][4];?></td>
                                <td id = "finalgrade"><?php echo $final_grade;?></td>
                                <td ><?php  if ($final_grade >= 75) {
                                    echo ("Passed");
                                } else {
                                    echo ("Failed");
                                };?></td>
                            </tr>
                        <?php
                            $cnt=$cnt+1;
                            } //added end
                            
                            //ended
                        ?>                                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<!-- end of datatable -->

        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>

    <?php include 'includes/footer.php';?>


</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
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


<script type="text/javascript">
    $(document).ready(function() {
      $('#bootstrap-data-table-export').DataTable();
  } );

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

</body>
</html>
