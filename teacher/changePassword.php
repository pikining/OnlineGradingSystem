
<?php

    include('../includes/dbconnection.php');
    include('../includes/session.php');
    error_reporting(0);

if(isset($_POST['submit'])){
    
    $cpassword=$_POST['currentpassword'];
    $newpassword=$_POST['newpassword'];
    $confirmpassword=$_POST['confirmpassword'];
    $re = "/^(?=.*[a-z])(?=.*\\d).{8,}$/i"; 
    
    $query=mysqli_query($con,"select * from tbladmin where staffId='$staffId' and staffpass='$cpassword'");
    $row=mysqli_fetch_array($query);
    if($row > 0){
      if(preg_match($re, $newpassword)) {
          if($newpassword == $confirmpassword){
        $ret=mysqli_query($con,"update tbladmin set staffpass='$newpassword' where staffId='$staffId'");

      $alertStyle ="success";
      $statusMsg="Password changed successfully!";

    }else{
        $alertStyle ="error";
      $statusMsg="New password and confirm password does not match!";
    }
          
      }
    else{
        $alertStyle ="error";
      $statusMsg="Password must contain 8 characters, 1 uppercase, 1 lowercase , 1 number and 1 special character.";
    }
    }
    else 
    {

      $alertStyle ="error";
      $statusMsg="Your current password is wrong!";
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
                    <h2>My Profile</h2>
                </div>
            </div>

        <div class="content">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">Update Profile</h2></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        <form  method="Post" action="">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Current Password</label>
                                                        <input id="currentpassword" required name="currentpassword" type="password" class="form-control cc-exp" value="" Required placeholder="Current Password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">New Password</label>
                                                        <input id="newpassword" required name="newpassword" type="password" class="form-control cc-exp" value="" data-val="true" placeholder="New Password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Confirm new Password</label>
                                                        <input id="confirmpassword" required name="confirmpassword" type="password" class="form-control cc-exp" value="" data-val="true" placeholder="Confirm new Password">
                                                    </div>
                                                </div>
                                            </div>
                                            <button  type="submit" name="submit" class="btn ">Change Password</button>
                                        </form>
                                    </div>
                                </div>
                        </div> <!-- .card -->
                    </div><!--/.col-->
               

                
<!-- end of datatable -->

    </div><!-- .content -->

    <div class="clearfix"></div>
        </main>
        <?php include 'includes/footer.php';?>


</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="../assets/js/main.js"></script>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if(isset($statusMsg)){
?>
<script>
    Swal.fire({
        title: '<?php echo $statusMsg;?>',
        icon: '<?php echo $alertStyle;?>',
        //button:'Ok'
    })
</script>


<?php
    unset($statusMsg);
}
?>

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


</body>
</html>
