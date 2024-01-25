<?php

    session_start();
    error_reporting(0);
    include('includes/dbconnection.php');

  ?>


<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include 'includes/title.php';?>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon">
    <!-- <link rel="shortcut icon" href="img/favicon2.jpeg" /> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style2.css">

      <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- VENDOR -->
    <!-- Vendor CSS Files -->
        <link href="dashboard/bootstrap.min.css" rel="stylesheet">
        <link href="dashboard/bootstrap-icons.css" rel="stylesheet">
        <link href="dashboard/boxicons.min.css" rel="stylesheet">
        <link href="dashboard/quill.snow.css" rel="stylesheet">
        <link href="dashboard/quill.bubble.css" rel="stylesheet">
        <link href="dashboard/remixicon.css" rel="stylesheet">
        <link href="dashboard/simple-datatables/style.css" rel="stylesheet">

          <!-- Template Main CSS File -->
        <link href="dashboard/style.css" rel="stylesheet">

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>
<body class="bg-light">

    <div class="sufee-login d-flex align-content-center flex-wrap" >
        <div class="container">
            <div class="login-content">
                <div class="d-flex justify-content-center py-4">
                    <a href="index.php" class="logo d-flex align-items-center w-auto">
                    <img src="assets/img/logo.png" height="50px" alt="">
                    <span class="logo-name d-none d-lg-block">MIES Grade Viewing System</span>
                    </a>
                </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">
                    <?php
                        if(isset($_SESSION['status'])){
                            ?>
                            <div class="alert alert-success">
                                <h5><?= $_SESSION['status']; ?></h5>
                            </div>
                            <?php
                            unset($_SESSION['status']);
                        }
                    ?>
                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                    <p class="text-center small">Enter your email address to reset</p>
                </div>
                    <form method="Post" Action="../password-reset-code.php">
                        <div class="form-group">
                            <input type="text" name="email" Required class="form-control" placeholder="">
                            <center><label>Email Address</label></center>
                        </div>
						
                        <button class="btn btn-primary w-100" type="submit" name="password_reset_link">Send Password</button>
                        <br><br>
                        
                            <div class="card" style="background:grey;">
                                <div class="card-body" style="background:#dddddd;" >
                                    This is only for approved personnel! If you are a teacher or a student, please contact the school principal to reset your password!
                                </div>
                            </div>
						
						
						
                        <!-- <div class="social-login-content">
                            <div class="social-button">
                                <button type="button" class="btn social facebook btn-flat btn-addon mb-3"><i class="ti-facebook"></i>Sign in with facebook</button>
                                <button type="button" class="btn social twitter btn-flat btn-addon mt-2"><i class="ti-twitter"></i>Sign in with twitter</button>
                            </div>
                        </div> -->
                        <!-- <div class="register-link m-t-15 text-center">
                            <p>Don't have account ? <a href="#"> Sign Up Here</a></p>
                        </div> -->
                    </form>
                </div>
                </div>
                <div class="copyright" align="center" >
                &copy; Copyright <strong><span>MIES</span></strong>. All Rights Reserved
            </div>   
            </div>
        </div>


        
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>
</html>
