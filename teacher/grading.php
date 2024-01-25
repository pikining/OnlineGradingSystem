
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

if(isset($_POST['submit'])){

 $alertStyle ="";
  $statusMsg="";


$gradingperiod=$_POST['gradingperiod'];
$levelId=$_POST['levelId'];
$sectionName=$_POST['sectionName'];
$subject=$_POST['subject'];

$dateCreated = date("Y-m-d");


$query=mysqli_query($con,"select * from tblsection where levelId ='$levelId' and sectionName = '$sectionName'");
$ret=mysqli_fetch_array($query);
if($ret > 0){

  $alertStyle ="alert alert-danger";    
  $statusMsg="This Section already exist for this Faculty!";

}
else{

$query=mysqli_query($con,"insert into tblsection(sectionName,levelId,facultyId) value('$levelId- $sectionName','$levelId','$facultyId')");

if ($query) {

  $alertStyle ="alert alert-success";
  $statusMsg="Section Added Successfully!";
}
else
{
  $alertStyle ="alert alert-danger";
  $statusMsg="An error Occurred!";
}
}
}
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
<?php $page="grading"; include 'includes/leftMenu.php';?>

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
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="index.php">Dashboard</a></li>
                                <li class="active">Grading</li>
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Grading</h2></strong>
                        </div>
                        <div class="card-body">
                            <form method="Post" action="">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="x_card_code" class="control-label mb-1">Grade Level</label>
                                                <?php 
                                                    $query=mysqli_query($con,"select * from tbllevel ORDER BY id ASC");                        
                                                    $count = mysqli_num_rows($query);
                                                    if($count > 0){                       
                                                        echo ' <select required name="levelId" class="custom-select form-control">';
                                                        echo'<option value="">Select Grade Level</option>';
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo'<option value="'.$row['Id'].'" >'.$row['Id'].'</option>';
                                                        }
                                                        echo '</select>';
                                                    }
                                                ?>    
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="x_card_code" class="control-label mb-1">Section</label>
                                            <?php 
                                                $query=mysqli_query($con,"select * from tblsection ORDER BY levelId ASC");                        
                                                $count = mysqli_num_rows($query);
                                                if($count > 0){                       
                                                    echo ' <select  name="sectionName" class="custom-select form-control">';
                                                    echo'<option value="">Select Section</option>';
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        echo'<option value="'.$row['Id'].'" >'.$row['sectionName'].'</option>';
                                                    }
                                                    echo '</select>';
                                                }
                                            ?>   
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="x_card_code" class="control-label mb-1">Subject</label>
                                                <?php 
                                                    $query=mysqli_query($con,"select * from tblsubject ORDER BY levelId ASC");                        
                                                    $count = mysqli_num_rows($query);
                                                    if($count > 0){                       
                                                        echo ' <select  name="subject" class="custom-select form-control">';
                                                        echo'<option value="">Select Subject</option>';
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo'<option value="'.$row['Id'].'" >'.$row['subjectTitle'].'</option>';
                                                        }
                                                        echo '</select>';
                                                    }
                                                ?>   
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label mb-1">Grading Period</label>
                                            <select Required name="gradingperiod" id="" class="custom-select form-control">
                                                <option value="">Select Grading</option>
                                                <option value="1st Grading">1st Grading</option>
                                                <option value="2nd Grading">2nd Grading</option>
                                                <option value="3rd Grading">3rd Grading</option>
                                                <option value="4th Grading">4th Grading</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                            </form>    
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
