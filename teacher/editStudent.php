
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(1);

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

if(isset($_GET['editStudentId'])){

$_SESSION['editStudentId'] = $_GET['editStudentId'];

$query = mysqli_query($con,"SELECT * FROM tblpromoted as p LEFT JOIN (SELECT Id,levelName FROM tbllevel) as l ON p.levelId=l.Id LEFT JOIN (SELECT Id,sectionName FROM tblsection) as sec ON p.sectionId=sec.Id LEFT JOIN (SELECT Id,firstName,lastName,middleName,age,gender,LRN,father,fathernum,mother,mothernum,guardian,guardiannum FROM tblstudent) as s ON p.studentId = s.Id WHERE p.studentId='$_SESSION[editStudentId]'");
$rowi = mysqli_fetch_array($query);

}

else{ 

echo "<script type = \"text/javascript\">
window.location = (\"createStudent.php\")
</script>"; 
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
  $dateCreated = date("Y-m-d");

$query=mysqli_query($con,"UPDATE tbladmin set fullName='$firstname $lastname',staffId='lrn'  WHERE userId='". $_SESSION['editStudentId']."'");
$query=mysqli_query($con,"UPDATE tblstudent SET firstName='$firstname', lastName='$lastname', middleName='$middlename', age='$age', gender='$gender',
LRN='$lrn', father='$father', fathernum='$fathernum', mother='$mother', mothernum='$mothernum', guardian='$guardian', guardiannum='$guardiannum'
WHERE Id='$_SESSION[editStudentId]'");

 
if ($query) {

    $alertStyle ="alert alert-success";
    $statusMsg="Student Edited Successfully!";
}
else
{
  $alertStyle ="alert alert-danger";
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
                                <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
                          </ol>
                        </nav>
                </div>
            </div>

    <div class="content">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Edit Student Information</h2></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                                <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                <h3>Student Details</h3> <hr color="black">
                                   <form method="Post" action="">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Firstname</label>
                                                    <input id="" name="firstname" type="text" class="form-control cc-exp" value="<?php echo $rowi['firstName']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Middlename</label>
                                                    <input id="" name="middlename" type="text" class="form-control cc-exp" value="<?php echo $rowi['middleName']?>" data-val="true" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label for="x_card_code" class="control-label mb-1">Lastname</label>
                                                    <input id="" name="lastname" type="text" class="form-control cc-cvc" value="<?php echo $rowi['lastName']?>" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="">
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                        <div class="col-4">
                                                <label for="x_card_code" class="control-label mb-1">Age</label>
                                                    <input id="" name="age" type="text" class="form-control cc-cvc" value="<?php echo $rowi['age']?>" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="">
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Gender</label>
                                                        <select Required id="gender" name="gender"  class="form-select">
                                                            <option value="">Select Category</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Male">Male</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">LRN</label>
                                                    <input id="" name="lrn" type="text" class="form-control cc-exp" value="<?php echo $rowi['LRN']?><?= isset($_POST['LRN']) ? $_POST['LRN'] : ''; ?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <?php
                                                    echo"<div id='txtHint'></div>";
                                                ?>                                    
                                            </div>
                                        </div>
                                    </div>
                                        <h3>Secondary Details</h3> <hr color="black">
                                    
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Father's Name</label>
                                                    <input id="" name="father" type="text" class="form-control cc-exp" value="<?php echo $rowi['father']?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                    <input id="" name="fathernum" type="text" class="form-control cc-exp" value="<?php echo $rowi['fathernum']?>" data-val="true" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Mother's Name</label>
                                                    <input id="" name="mother" type="text" class="form-control cc-exp" value="<?php echo $rowi['mother']?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                    <input id="" name="mothernum" type="text" class="form-control cc-exp" value="<?php echo $rowi['mothernum']?>" data-val="true" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Guardian's Name</label>
                                                    <input id="" name="guardian" type="text" class="form-control cc-exp" value="<?php echo $rowi['guardian']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                    <input id="" name="guardiannum" type="text" class="form-control cc-exp" value="<?php echo $rowi['guardiannum']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class ="rows">
                                            <div class="cancel">
                                            <button type="submit" name="cancel" class="btn" ><a href="../teacher/viewstudent.php?viewId=<?php echo $_SESSION['viewId'];?>&aId=<?php echo $_GET['aId'];?>" >Cancel</a></button>
                                            </div>
                                            <button type="submit" name="submit" class="btn">Update Student</button>
                                        </div>
                                            
                                        
                                    </form>
                                </div>
                    </div> <!-- .card -->
                </div><!--/.col-->
<!-- end of datatable -->

        </div>
    </div><!-- .animated -->
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
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    ></script>
<script>
$("#gender").val("<?= isset($_POST['gender']) ? $_POST['gender'] : ''; ?>");
$("#grade").val("<?= isset($_POST['levelId']) ? $_POST['levelId'] : ''; ?>");
$("#section_sel").val("<?= isset($_POST['section']) ? $_POST['section'] : ''; ?>");
$("#year").val("<?= isset($_POST['sessionId']) ? $_POST['sessionId'] : ''; ?>");

$("#grade").selectize({});
       $("#year").selectize({});
       $("#gender").selectize({});
       $("#section_sel").selectize({});
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
