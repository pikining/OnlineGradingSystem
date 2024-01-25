
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

if(isset($_POST['submit'])){

 $alertStyle ="";
  $statusMsg="";

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$middlename=$_POST['middlename'];
$lrn=$_POST['lrn'];
$levelId=$_POST['levelId'];
$section=$_POST['section'];
$facultyId=$_POST['facultyId'];
$sessionId=$_POST['sessionId'];
$father=$_POST['father'];
$fathernum=$_POST['fathernum'];
$mother=$_POST['mother'];
$mothernum=$_POST['mothernum'];
$guardian=$_POST['guardian'];
$guardiannum=$_POST['guardiannum'];
$dateCreated = date("Y-m-d");

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


if($ret > 0){

  $alertStyle ="alert alert-danger";
  $statusMsg="Student with the LRN already exist!";

}
else{
$query=mysqli_query($con,"insert into  tbladmin (fullName,staffid,staffpass,adminTypeId,dateCreated) 
    VALUES ('$firstname $lastname','$lrn','$pw','5','$dateCreated')");
$query=mysqli_query($con,"insert into  tbladmin (fullName,staffid,staffpass,adminTypeId,dateCreated) 
    VALUES ('$guardian','$guardiannum','$pw2','6','$dateCreated')");
$query=mysqli_query($con,"insert into tblstudent(firstName,lastName,middleName,LRN,password,levelId,sectionId,sessionId,father,fathernum,mother,mothernum,guardian,guardiannum,dateCreated) 
value('$firstname','$lastname','$middlename','$lrn','$pw','$levelId','$section','$sessionId','$father','$fathernum','$mother','$mothernum','$guardian','$guardiannum','$dateCreated')");
if($query){
    $last_id = mysqli_insert_id($con);

}
//promote last_id as student id
$query=mysqli_query($con,"insert into  tblpromoted (studentId,levelId,sectionId,sessionId,dateCreated) 
VALUES ('$last_id','$levelId','$section','$sessionId','$dateCreated')");

//

if ($query) {

  $alertStyle ="alert alert-success";
  $statusMsg="Student Added Successfully!";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include '../includes/title.php';?>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link  rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <link rel="stylesheet" href="../assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.css" integrity="sha512-pZE3NzBgokXUM9YLBGQIw99omcxiRdkMhZkz0o7g0VjC0tCFlBUqbcLKUuX8+jfsZgiZNIWFiLuZpLxXoxi53w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- Left Panel -->
    <?php $page="student"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-head">
                <div class="page-title">
                    <h2>Student</h2>
                </div>
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">Student</li>
                                <li class="breadcrumb-item active" aria-current="page">Add Student</li>
                          </ol>
                        </nav>
                </div>
            </div>

            
    <div class="content">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Add New Student</h2></strong>
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
                                                    <input id="" name="firstname" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Middlename</label>
                                                    <input id="" name="middlename" type="text" class="form-control cc-exp" value="" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label for="x_card_code" class="control-label mb-1">Lastname</label>
                                                    <input id="" name="lastname" type="text" class="form-control cc-cvc" value="" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="">
                                            </div>
                                        </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">LRN</label>
                                                    <input id="" name="lrn" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                            <div class="form-group">
                                                        <label for="x_card_code" class="control-label mb-1">Grade Level</label>
                                                            <?php 
                                                            $query=mysqli_query($con,"select * from tbllevel ORDER BY id ASC");                        
                                                            $count = mysqli_num_rows($query);
                                                            if($count > 0){                       
                                                                echo ' <select required name="levelId" class="form-select">';
                                                                echo'<option value="">Select Grade Level</option>';
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                echo'<option value="'.$row['Id'].'" >'.$row['levelName'].'</option>';
                                                                    }
                                                                        echo '</select>';
                                                                    }
                                                            ?>    
                                                    </div>
                                                </div>
                                            <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="x_card_code" class="control-label mb-1">Section</label>
                                                        <?php 
                                                        $query=mysqli_query($con,"select * from tblsection ORDER BY levelId ASC");                        
                                                        $count = mysqli_num_rows($query);
                                                        if($count > 0){                       
                                                            echo ' <select id="section_sel" name="section" class="form-select">';
                                                            echo'<option value="">Select Section</option>';
                                                            while ($row = mysqli_fetch_array($query)) {
                                                            echo'<option value="'.$row['Id'].'" >'.$row['sectionName'].'</option>';
                                                                }
                                                                    echo '</select>';
                                                                }
                                                        ?>   
                                                    </div>
                                            </div>
                                        </div> 

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                 <label for="x_card_code" class="control-label mb-1">School Year</label>
                                                <?php 
                                                $query=mysqli_query($con,"select * from tblsession ORDER BY id ASC");                        
                                                $count = mysqli_num_rows($query);
                                                if($count > 0){                       
                                                    echo ' <select required name="sessionId" class="form-select">>';
                                                    echo'<option value="">Select Session</option>';
                                                    while ($row = mysqli_fetch_array($query)) {
                                                    echo'<option value="'.$row['Id'].'" >'.$row['sessionName'].'</option>';
                                                        }
                                                            echo '</select>';
                                                        }
                                            ?>   
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
                                                <input id="" name="father" type="text" class="form-control cc-exp" value=""  placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                <input id="" name="fathernum" type="text" class="form-control cc-exp" value=""   placeholder="">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Mother's Name</label>
                                                <input id="" name="mother" type="text" class="form-control cc-exp" value=""   placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                <input id="" name="mothernum" type="text" class="form-control cc-exp" value=""  placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Guardian's Name</label>
                                                <input id="" name="guardian" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-exp="Please enter a valid security code" placeholder="">
                                                </div>
                                            </div>  
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="x_card_code" class="control-label mb-1">Contact Number</label>
                                                <input id="" name="guardiannum" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-exp="Please enter a valid security code" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                            <button type="submit" name="submit" class="btn">Add New Student</button>
                                        </div>
                                    </form>
                                </div>
                    </div> <!-- .card -->
                </div><!--/.col-->
           

            <br><br>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">All Student</h2></strong>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>FullName</th>
                                        <th>LRN</th>
                                        <th>Date Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                    <?php
                                        $ret=mysqli_query($con,"SELECT * From tblstudent");
                                        $cnt=1;
                                        while ($row=mysqli_fetch_array($ret)) {
                                     ?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row['firstName'].' '.$row['lastName'].' '.$row['middleName'];?></td>
                                        <td><?php echo $row['LRN'];?></td>
                                        <td><?php echo $row['dateCreated'];?></td>
                                        <td><a href="editStudent.php?editStudentId=<?php echo $row['LRN'];?>" title="Edit Details"><i class="las la-edit"></i></a>
                                        <a href="viewStudentinfo.php?editid=<?php echo $row['LRN'];?>" title="Edit Faculty Details"><i class="las la-info-circle"></i></a>
                                        <a class="delete" data-href="deleteStudent.php?delid=<?php echo $row['LRN'];?>" title="Delete Student Details"><i class="las la-trash-alt"></i></a></td>
                                    </tr>
                                    <?php 
                                        $cnt=$cnt+1;
                                    }?>
                                                                                        
                            </tbody>
                        </table>
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
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    ></script>
    <script>
       // Menu Trigger
       $("#section_sel").selectize({});
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
