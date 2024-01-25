
<?php

    include('../includes/dbconnection.php');
    include('../includes/session.php');
    error_reporting(0);

if(isset($_GET['editid'])){

$_SESSION['editid'] = $_GET['editid'];

$query = mysqli_query($con,"select * from tblsession where Id='$_SESSION[editid]'");
$rowi = mysqli_fetch_array($query);

}

else{

echo "<script type = \"text/javascript\">
    window.location = (\"createSession.php\")
    </script>"; 
}


if(isset($_POST['submit'])){

     $alertStyle ="";
      $statusMsg="";

    $sessionName=$_POST['sessionName'];

    $query=mysqli_query($con,"update tblsession set sessionName='$sessionName' where Id='$_SESSION[editid]'");

    if ($query) {
        
       $alertStyle ="alert alert-success";
       $statusMsg="Session Edited Successfully!";
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
    <?php $page="session"; include 'includes/leftMenu.php';?>

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
                        <li class="breadcrumb-item">Session</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Session</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="content">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">Edit Session</h2></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                <form method="Post" action="">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Session</label>
                                                <input id="" name="sessionName" type="tel" class="form-control cc-exp" value="<?php echo $rowi['sessionName'];?>" placeholder="Session Name">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class ="rows">
                                        <div class="cancel">
                                        <button type="submit" name="cancel" class="btn" style="color:'#df2c14';"><a href="../superAdmin/createSession.php" >Cancel</a></button>
                                        </div>
                                        <button type="submit" name="submit" class="btn ">Update Session</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- .card -->
               

<!-- end of datatable -->

    </div><!-- .content -->

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
