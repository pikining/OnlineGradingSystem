
<?php

    include('../includes/dbconnection.php');
    include('../includes/session.php');
    error_reporting(0);


$query=mysqli_query($con,"SELECT * FROM tbladmin WHERE staffId='".$_SESSION['staffId']."'");
$rowi=mysqli_fetch_array($query);

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


if(isset($_POST['submit2'])){
    
    $fullName=$_POST['fullName'];
    $emailAddress=$_POST['emailAddress'];
    $phoneNo=$_POST['phoneNo'];
    $staffId=$_POST['staffId'];

    $ret=mysqli_query($con,"UPDATE tbladmin SET fullName='$fullName', emailAddress='$emailAddress',phoneNo='$phoneNo' WHERE staffId='$_SESSION[staffId]'");
   
    if ($ret) {
    
    
     
      $alertStyle2 ="success";
      $statusMsg2="Profile updated successfully!";

    } else {

      $alertStyle2 ="error";
      $statusMsg2="An Error Occurred!";
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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link  rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">

</head>
<body>
    <!-- Left Panel -->
    <?php $page="profile"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->


    <div class="main-content">

        <!-- Header-->
<?php include 'includes/header.php';?>
        <!-- /header -->
        <!-- Header-->
        <main>
            <div class="card-head">
                <div class="page-title">
                    <h2>My Profile</h2>
                </div>
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">Profile</li>
                                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                          </ol>
                        </nav>
                </div>
            </div>

        <div class="content">
                    
                    <div class="recent-grid">
                                    <div class="profile">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3> Update Profile</h3>
                                            </div>
                                                <div class="card-body">
                                                    <form  method="POST" action="">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <div class="form-group">
                                                                    <label for="cc-exp" class="control-label mb-1">Full Name:</label>
                                                                    <input id="" name="fullName" type="tel" class="form-control cc-exp" value="<?php echo $rowi['fullName']?>" placeholder="Admin Name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <div class="form-group">
                                                                    <label for="cc-exp" class="control-label mb-1">Email Address:</label>
                                                                    <input id="" name="emailAddress" type="email" class="form-control cc-exp" value="<?php echo $rowi['emailAddress']?>" placeholder="Email Address">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <div class="form-group">
                                                                    <label for="cc-exp" class="control-label mb-1">Phone Number:</label>
                                                                    <input id="" name="phoneNo" type="tel" class="form-control cc-exp" value="<?php echo $rowi['phoneNo']?>" placeholder="Phone Number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                       <!-- <div class="row">
                                                            <div class="col-10">
                                                                <div class="form-group">
                                                                    <label for="cc-exp" class="control-label mb-1">Username:</label>
                                                                    <input name="staffId" type="tel" class="form-control cc-exp" value="<?php echo $rowi['staffId']?>" placeholder="Username">
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                        <div>
                                                        <button   type="submit" name="submit2" class="btn">Update Profile</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="password">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3>Change Password</h3>
                                                </div>
                                                <div class="card-body">
                                                    <form  method="Post" action="">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <div class="form-group">
                                                                    <label for="cc-exp" class="control-label mb-1">Current Password</label>
                                                                    <input id="currentpassword" required name="currentpassword" type="password" class="form-control cc-exp" value="" Required placeholder="Current Password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <div class="form-group">
                                                                    <label for="cc-exp" class="control-label mb-1">New Password</label>
                                                                    <input id="newpassword" required name="newpassword" type="password" class="form-control cc-exp" value="" data-val="true" placeholder="New Password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <div class="form-group">
                                                                    <label for="cc-exp" class="control-label mb-1">Confirm new Password</label>
                                                                    <input id="confirmpassword" required name="confirmpassword" type="password" class="form-control cc-exp" value="" data-val="true" placeholder="Confirm new Password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button  type="submit" name="submit" class="btn " style="background-color:#53a3e4;">Change Password</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                
<!-- end of datatable -->

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
<?php
if(isset($statusMsg2)){
?>
<script>
    Swal.fire({
        title: '<?php echo $statusMsg2;?>',
        icon: '<?php echo $alertStyle2;?>',
        //button:'Ok'
        timer: 1500
    })
</script>


<?php
    unset($statusMsg2);
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

<!-- END OF SCRIPT-->
</body>
</html>
