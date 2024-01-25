
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);


if(isset($_GET['studentId'])){

$_SESSION['studentId'] = $_GET['studentId'];

$query = mysqli_query($con,"select * from tblpromoted where studentId='$_SESSION[studentId]'");
$rowi = mysqli_fetch_array($query);
$ret=mysqli_query($con,"SELECT tblstudent.Id, tblstudent.firstName, tblstudent.lastName, tblstudent.middleName,tblstudent.LRN,tblpromoted.dateCreated, tblsection.Id,tblsection.sectionName,tbllevel.levelName,tblsession.sessionName, tblpromoted.studentId,tblpromoted.sectionId,tblpromoted.sessionId,tblpromoted.levelId
From tblpromoted WHERE studentId='$_SESSION[studentId]'
LEFT JOIN tblsection ON tblsection.Id = tblpromoted.sectionId  
LEFT JOIN tbllevel ON tbllevel.Id = tblpromoted.levelId
LEFT JOIN tblsession ON tblsession.Id = tblpromoted.sessionId
LEFT JOIN tblstudent ON tblstudent.Id = tblpromoted.studentId");
$rowi = mysqli_fetch_array($ret);
}

else{ 

echo "<script type = \"text/javascript\">
window.location = (\"viewStudent.php\")
</script>"; 
}


if(isset($_POST['submit'])){

 $alertStyle ="";
  $statusMsg="";

  $firstname=$_POST['firstname'];
  $lastname=$_POST['lastname'];
  $middlename=$_POST['middlename'];
  $lrn=$_POST['lrn'];
  $levelId=$_POST['levelId'];
  $sectionId=$_POST['sectionId'];
  $sessionId=$_POST['sessionId'];
  $dateCreated = date("Y-m-d");

// $query=mysqli_query($con,"select * from tblstudent where matricno !='$matricNo'");
// $ret=mysqli_fetch_array($query);
// if($ret > 0){

//   $alertStyle ="alert alert-danger";
//   $statusMsg="Student with the Matric Number already exist!";

// }
// else{

$ret=mysqli_query($con,"UPDATE tblstudent SET levelId='$levelId', sectionId = '$sectionId', sessionId='$sessionId'
where studentId='$_SESSION[studentId]'");
$rowi = mysqli_fetch_array($ret);

if ($ret) {

    echo "<script type = \"text/javascript\">
    window.location = (\"viewStudent.php\")
    </script>"; 
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
                    <h2>Session</h2>
                </div>
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Dashboard</li>
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
                            <strong class="card-title"><h2 align="center">Edit Promoted Student</h2></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                                <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                   <form method="Post" action="">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Fullname</label>
                                                    <input id="" name="lastname" type="tel" class="form-control cc-exp" value="<?php echo $rowi['lastName'], ", ",$rowi['firstName']," " ,$rowi['middleName']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="" disabled>
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
                                                        <label for="cc-exp" class="control-label mb-1">Grade  Level</label>
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
                                                        <label for="cc-exp" class="control-label mb-1">Section</label>
                                                        <?php 
                                                        $query=mysqli_query($con,"select * from tblsection ORDER BY levelId ASC");                        
                                                        $count = mysqli_num_rows($query);
                                                        if($count > 0){                       
                                                            echo ' <select  name="section" class="form-select">';
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
                                                 <label for="x_card_code" class="control-label mb-1">Session</label>
                                                <?php 
                                                $query=mysqli_query($con,"select * from tblsession ORDER BY id ASC");                        
                                                $count = mysqli_num_rows($query);
                                                if($count > 0){                       
                                                    echo ' <select required name="sessionId" class="form-select">';
                                                    
                                                    while ($row = mysqli_fetch_array($query)) {
                                                    echo'<option value="'.$row['Id'].'" >'.$row['sessionName'].'</option>';
                                                        }
                                                            echo '</select>';
                                                        }
                                            ?>   
                                            </div>
                                        </div>
                                    </div>
                                    <div>
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
