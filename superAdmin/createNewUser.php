
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
$sectionId=$_POST['sectionId'];
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

$pw = strtoupper(substr($s_fname, 0, 1));
$pw .= strtoupper(substr($s_lname, 0, 1));
$pw .= rand(10000, 99999);
$pw .= "!";

if($ret > 0){

  $alertStyle ="alert alert-danger";
  $statusMsg="Student with the LRN already exist!";

}
else{

$query=mysqli_query($con,"insert into tblstudent(firstName,lastName,middleName,LRN,password,levelId,facultyId,sectionId,sessionId,father,fathernum,mother,mothernum,guardian,guardiannum,dateCreated) 
value('$firstname','$lastname','$middlename','$lrn','$pw','$levelId','$facultyId','$sectionId','$sessionId','$father','$fathernum','$mother','$mothernum','$guardian','$guardiannum','$dateCreated')");

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

<script>
function showValues(str) {
if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
} else { 
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","ajaxCall2.php?fid="+str,true);
    xmlhttp.send();
}
}
</script>
</head>
<script src="../js/jquery-1.12.1.min.js"></script>
<script>
    $(document).ready(function(){
            $("#levelId").change(function(){
                var aid = $("#levelId").val();
                $.ajax({
                    url: 'data2student.php',
                    method: 'post',
                    data: 'aid=' + aid
                }).done(function(sectionId){
                    console.log(sectionId);
                    sectionId = JSON.parse(sectionId);
                    $('#sectionId').empty();
                    sectionId.forEach(function(sectionIds){
                        $('#sectionId').append('<option value="">' + sectionIds.sectionName + '</option>')
                    })
                })
            })
        })
</script>
<body>
<!-- Left Panel -->
<?php $page="user"; include 'includes/leftMenu.php';?>

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
                <div class="col-lg-4">
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
                                <li class="active">Add New User</li>
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
                            <strong class="card-title"><h2 align="center">Add New User</h2>
                            <button type="submit" name="submit" class="float-right btn btn-success" >Add New User</button>
                            </strong>
                           
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                            <div id="pay-invoice">
                                <div class="card-body">
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
                                                        <label for="cc-exp" class="control-label mb-1">Grade  Level</label>
                                                            <select class="form-control" id="levelId" name="levelId[]" >
                                                    <option selected="" disabled="">Select Grade Level</option>
                                                    <?php 
                                                    require 'data2student.php';
                                                    $tbllevel = loadlevel();
                                                    foreach ($tbllevel as $level) {
                                                    echo "<option id='".$level['Id']."' value='".$level['Id']."'>".$level['levelName']."</option>";
                                                    }
                                                    
                                                    ?>
                                                            </select>
                                                    </div>
                                                </div>
                                            <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Section</label>
                                                            <select class="form-control" id="sectionId" required name="sectionId">
                                                            <option data-val-required="true" selected="" disabled="">Select Section</option>
                                
                                                            </select>
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
                                                    echo ' <select required name="sessionId" class="custom-select form-control">';
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
                                                <input id="" name="father" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                <input id="" name="fathernum" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-exp="Please enter a valid security code" placeholder="">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Mother's Name</label>
                                                <input id="" name="mother" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Contact Number</label>
                                                <input id="" name="mothernum" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
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
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                            <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>FullName</th>
                                        <th>LRN</th>
                                        <th>Level</th>
                                        <th>Date Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                        <?php
                $ret=mysqli_query($con,"SELECT tblstudent.Id, tblstudent.firstName, tblstudent.lastName, tblstudent.middleName,tblstudent.LRN,
                tblstudent.dateCreated, tbllevel.levelName,tblfaculty.lname,tblsession.sessionName,tblfaculty.fname,tblfaculty.mname
                from tblstudent
                LEFT JOIN tbllevel ON tbllevel.Id = tblstudent.levelId
                LEFT JOIN tblsession ON tblsession.Id = tblstudent.sessionId
                LEFT JOIN tblfaculty ON tblfaculty.Id = tblstudent.facultyId");
                $cnt=1;
                while ($row=mysqli_fetch_array($ret)) {
                                    ?>
                <tr>
                <td><?php echo $cnt;?></td>
                <td><?php echo $row['firstName'].' '.$row['lastName'].' '.$row['middleName'];?></td>
                <td><?php echo $row['LRN'];?></td>
                <td><?php echo $row['levelName'];?></td>
                <td><?php echo $row['dateCreated'];?></td>
                <td><a href="editStudent.php?editStudentId=<?php echo $row['LRN'];?>" title="Edit Details"><i class="fa fa-edit fa-1x"></i></a>
                <a href="viewStudentinfo.php?editid=<?php echo $row['Id'];?>" title="Edit Faculty Details"><i class="fa fa-info-circle fa-1x"></i></a>
                <a class="delete" data-href="deleteStudent.php?delid=<?php echo $row['LRN'];?>" title="Delete Student Details"><i class="fa fa-trash fa-1x"></i></a></td>
                
                </tr>
                <?php 
                $cnt=$cnt+1;
                }?>
                                                                                        
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

<script src=../assets/plugins/bootstrap-sweetalert/sweetalert.min.js></script>
<script src="../_common/delete_swal.js"></script>

</body>
</html>
