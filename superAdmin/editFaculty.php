
<?php

    include('../includes/dbconnection.php');
    include('../includes/session.php');
    error_reporting(0);


if(isset($_GET['editid'])){

$_SESSION['editId'] = $_GET['editid'];

$query = mysqli_query($con,"SELECT * FROM tblfaculty WHERE Id='". $_SESSION['editId']."'");
$rowi = mysqli_fetch_array($query);

}
 
else{

echo "<script type = \"text/javascript\">
    window.location = (\"createFaculty.php\")
    </script>"; 
}


if(isset($_POST['submit'])){

     $alertStyle ="";
     $statusMsg="";

    $lname=$_POST['lastName'];
    $fname=$_POST['firstName'];
    $mname=$_POST['middleName'];
    $fid=$_POST['facultyID'];
    $designation=$_POST['designation'];
    $dateCreated = date("Y-m-d");

  $query=mysqli_query($con,"update tblfaculty set lname='$lname', fname='$fname', mname='$mname',fid='$fid',designation='$designation'   where Id='". $_SESSION['editId']."'");
  $query=mysqli_query($con,"UPDATE tbladmin SET fullName='$fname $lname',staffId='$fid'  WHERE userId='". $_SESSION['editId']."'");

    if($query){
        $alertStyle ="alert alert-success";
        $statusMsg="Teacher Edited Successfully!";
       
    }
    else {

        $alertStyle ="alert alert-danger";
        $statusMsg="An Error Occurred!";
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
    <?php $page="faculty"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-head">
                <div class="page-title">
                    <h2>Faculty</h2>
                </div>
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">Faculty</li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Faculty</li>
                          </ol>
                        </nav>
                </div>
            </div>

        <div class="content">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">Edit Faculty</h2></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                       <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                        <form method="Post" action="">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Last Name:</label>
                                                        <input id="" name="lastName" type="tel" class="form-control cc-exp" value="<?php echo $rowi['lname']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="Faculty Name">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">First Name:</label>
                                                        <input id="" name="firstName" type="tel" class="form-control cc-exp" value="<?php echo $rowi['fname']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="Faculty Name">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Middle Name:</label>
                                                        <input id="" name="middleName" type="tel" class="form-control cc-exp" value="<?php echo $rowi['mname']?>" placeholder="Faculty Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Faculty ID:</label>
                                                        <input id="" name="facultyID" type="tel" class="form-control cc-exp" value="<?php echo $rowi['fid']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="Faculty Id">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Teacher Designation</label>
                                                        <input id="" name="designation" type="tel" class="form-control cc-exp" value="<?php echo $rowi['designation']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="Teacher Designation">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class ="rows">
                                                <div class="cancel">
                                                <button type="submit" name="cancel" class="btn" ><a href="../superAdmin/viewFaculty.php" >Cancel</a></button>
                                                </div>
                                                <button type="submit" name="submit" class="btn ">Update Faculty</button>
                                            </div>
                                        </form>
                                    </div>
                        </div> <!-- .card -->

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
