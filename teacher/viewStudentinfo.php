
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

if(isset($_GET['editid'])){

$_SESSION['editId'] = $_GET['editid'];

//$query = mysqli_query($con,"select * from tblstudent INNER JOIN tbllevel on tbllevel.Id=tblstudent.levelId where tblstudent.Id='$_SESSION[editId]'");
//$query = mysqli_query($con,"select * from tblstudent INNER JOIN tblfaculty on tblfaculty.Id=tblstudent.facultyId where tblstudent.Id='$_SESSION[editId]'");
//$query = mysqli_query($con,"select * from tblstudent INNER JOIN tblsession on tblsession.Id=tblstudent.sessionId where tblstudent.Id='$_SESSION[editId]'");
//$sql_query = "SELECT * FROM tblstudent as s LEFT JOIN (SELECT Id, sectionName, levelId,facultyId FROM tblsection) AS ts on s.sectionId = ts.Id  WHERE s.Id='".mysqli_real_escape_string($con,$_SESSION['editId'])."'";
$student_data = array();
$sql_query = "SELECT * FROM tblpromoted LEFT JOIN (SELECT Id, LRN,firstName,lastName,middleName,age,gender,father,fathernum,mother,mothernum,guardian,guardiannum FROM tblstudent) as s ON tblpromoted.studentId = s.Id WHERE s.Id='".mysqli_real_escape_string($con,$_GET['editid'])."'";
$query = mysqli_query($con,$sql_query);
if($query){
    $num = mysqli_num_rows($query);
    if($num > 0 ){
        if($student_data = mysqli_fetch_assoc($query)){

        }   
    }
    mysqli_free_result($query);
}

if(!empty($student_data)){
    $student_data['sectionName'] =  "";
    $student_data['levelId'] =  "";
    $student_data['teacherId'] =  "";
    $student_data['levelName'] =  "";
    $student_data['adviser'] =  "";
    $student_data['sessionName'] = "";

    $sql_query = "SELECT * FROM tblsection WHERE Id='".mysqli_real_escape_string($con,$student_data['sectionId'])."'";
    $query = mysqli_query($con,$sql_query);
    if($query){
        $num = mysqli_num_rows($query);
        if($num > 0 ){
            if($data = mysqli_fetch_assoc($query)){
                $student_data['sectionName'] =  $data['sectionName'];
                $student_data['levelId'] =  $data['levelId'];
            }   
        }
        mysqli_free_result($query);
        unset($data);
    }

    $sql_query = "SELECT sectionId,teacherId FROM tbladviser LEFT JOIN (SELECT Id FROM tblsection) as s ON tbladviser.sectionId = s.Id LEFT JOIN (SELECT Id FROM tbladmin) as a ON tbladviser.teacherId = a.Id WHERE s.Id='".mysqli_real_escape_string($con,$student_data['sectionId'])."' AND a.Id='".mysqli_real_escape_string($con,$student_data['teacherId'])."'";
    $query = mysqli_query($con,$sql_query);
    if($query){
        $num = mysqli_num_rows($query);
        if($num > 0 ){
            if($data = mysqli_fetch_assoc($query)){
                $student_data['sectionId'] =  $data['sectionId'];
                $student_data['teacherId'] =  $data['teacherId'];
            }   
        }
        mysqli_free_result($query);
        unset($data);
    }

    $sql_query = "SELECT * FROM tbllevel WHERE Id='".mysqli_real_escape_string($con,$student_data['levelId'])."'";
    $query = mysqli_query($con,$sql_query);
    if($query){
        $num = mysqli_num_rows($query);
        if($num > 0 ){
            if($data = mysqli_fetch_assoc($query)){
                $student_data['levelName'] =  $data['levelName'];
            }   
        }
        mysqli_free_result($query);
        unset($data);
    }


    $sql_query = "SELECT * FROM tbladmin WHERE Id='".mysqli_real_escape_string($con,$student_data['teacherId'])."'";
    $query = mysqli_query($con,$sql_query);
    if($query){
        $num = mysqli_num_rows($query);
        if($num > 0 ){
            if($data = mysqli_fetch_assoc($query)){
                $student_data['fullName'] =  $data['fullName'];
            }   
        }
        mysqli_free_result($query);
        unset($data);
    } 

    $sql_query = "SELECT Id,sessionName FROM tblsession WHERE Id='".mysqli_real_escape_string($con,$student_data['sessionId'])."'";
    $query = mysqli_query($con,$sql_query);
    if($query){
        $num = mysqli_num_rows($query);
        if($num > 0 ){
            if($data = mysqli_fetch_assoc($query)){
                $student_data['sessionName'] =  $data['sessionName'];
            }   
        }
        mysqli_free_result($query);
        unset($data);
    } 
    
  }
  $rowi = $student_data;
}


else{

echo "<script type = \"text/javascript\">
window.location = (\"createStudent.php\")
</script>"; 
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
                            <li class="breadcrumb-item active" aria-current="page">Student Information</li>
                        </ol>
                    </nav>
                </div>
            </div>

    <div class="content">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Student Information</h2></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                                <h3>Student Details</h3> <hr color="black">
                                   <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                    <form method="Post" action="">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Fullname</label>
                                                    <input id="" name="lastname" type="tel" class="form-control cc-exp" value="<?php echo $rowi['lastName'], ", ",$rowi['firstName']," " ,$rowi['middleName']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Age</label>
                                                    <input id="" name="lastname" type="tel" class="form-control cc-exp" value="<?php echo $rowi['age']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Gender</label>
                                                    <input id="" name="lastname" type="tel" class="form-control cc-exp" value="<?php echo $rowi['gender']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">LRN</label>
                                                    <input id="" name="LRN" type="tel" class="form-control cc-exp" value="<?php echo $rowi['LRN']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Grade Level</label>
                                                    <input id="" name="levelId" type="tel" class="form-control cc-exp" value="<?php echo $rowi['levelId']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Section</label>
                                                    <input id="" name="sectionId" type="tel" class="form-control cc-exp" value="<?php echo $rowi['sectionName']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Session</label>
                                                    <input id="" name="sessionId" type="tel" class="form-control cc-exp" value="<?php echo $rowi['sessionName']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <h3>Secondary Details</h3> <hr color="black"> 
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Father's Name</label>
                                                    <input id="" name="father" type="tel" class="form-control cc-exp" value="<?php echo $rowi['father']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                    <input id="" name="fathernum" type="tel" class="form-control cc-exp" value="<?php echo $rowi['fathernum']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Mother's Name</label>
                                                    <input id="" name="mother" type="tel" class="form-control cc-exp" value="<?php echo $rowi['mother']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                    <input id="" name="mothernum" type="tel" class="form-control cc-exp" value="<?php echo $rowi['mothernum']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Guardian's Name</label>
                                                    <input id="" name="guardian" type="tel" class="form-control cc-exp" value="<?php echo $rowi['guardian']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                    <input id="" name="guardiannum" type="tel" class="form-control cc-exp" value="<?php echo $rowi['guardiannum']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
                                                </div>
                                            </div>
                                        </div>       
                                    </form>
                                </div>
                    </div> <!-- .card -->
                </div><!--/.col-->
        
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
