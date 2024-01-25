<?php
    include('../includes/dbconnection.php');
    include('../includes/session.php');
$query = mysqli_query($con,"SELECT * FROM tbladmin WHERE staffId='".$_SESSION['staffId']."'");
$row = mysqli_fetch_array($query);
$fullName = $row['fullName'];

$countAllStudent = 0;
    $countAllStudent1 = 0;
    $session_id = array('','');
    
    
    $query = mysqli_query($con, "SELECT * FROM `tblsession` ORDER BY  isActive DESC, Id ASC LIMIT 2");
    if($query){
        $count = mysqli_num_rows($query);
        if($count > 0){
            $count = 0;
            while($row = mysqli_fetch_assoc($query)){
    
                $session_id[$count] = $row['Id'];
                $count++;
            }
    
        }
    }
    
    //get previous
    $query = mysqli_query($con, "SELECT COUNT(studentId) as count FROM `tblpromoted` WHERE sessionId = '".$session_id[1]."'");
    if($query){
        $count = mysqli_num_rows($query);
        if($count > 0){
            $count = 0;
            if($row = mysqli_fetch_assoc($query)){
                $countAllStudent = $row['count'];
            }
    
        }
    }
    
    
    //get previous
    $query = mysqli_query($con, "SELECT COUNT(studentId) as count FROM `tblpromoted` WHERE sessionId = '".$session_id[0]."'");
    if($query){
        $count = mysqli_num_rows($query);
        if($count > 0){
            $count = 0;
            if($row = mysqli_fetch_assoc($query)){
                $countAllStudent1 = $row['count'];
            }
    
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include '../includes/title.php';?>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link  rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>style.css">

</head>
<body>
    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="logo-details">
                <img src="<?php echo BASE_URL; ?>assets/img/logo.png" width="40px" height="40px">
                <span class="logo_name"> GRADING SYSTEM </span>
        </div>

            <ul class="nav-links">
                <li>
                    <a href="<?php echo BASE_URL; ?>superadmin/index2.php" class="active">
                        <i class="las la-home"></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>Superadmin/createSession.php">
                        <i class="las la-cogs"></i>
                        <span class="link_name">Session</span>
                    </a>
                </li>
                <li>
                    <div class="icon-link">
                        <a href="#">
                            <i class="las la-chalkboard-teacher"></i>
                            <span class="link_name">Faculty</span>
                        </a>    
                        <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/createFaculty.php" class="las la-plus">Add New 
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/viewFaculty.php" class="las la-eye"> View Faculty
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/facultyload.php" class="las la-book">Faculty Load
                                </a>
                            </li>
                        </ul>
                </li>
                <li>
                    <div class="icon-link">
                        <a href="#">
                            <i class="las la-user-graduate"></i>
                            <span class="link_name">Student</span>
                        </a>
                            <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/createStudent.php" class="las la-plus">Add New Student
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/viewStudent.php" class="las la-eye">View Student
                                </a>
                            </li>
                        </ul>
                </li>
                <li>
                    <div class="icon-link">
                        <a href="#">
                            <i class="las la-list"></i>
                            <span class="link_name">Secttion</span>
                        </a>
                            <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/createDepartment.php" class="las la-plus">Add New Section
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/viewDepartment.php" class="las la-eye">View Section
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/createAdviser.php" class="las la-book-reader">Assign Adviser
                                </a>
                            </li>
                        </ul>
                </li>
                <li>
                    <div class="icon-link">
                        <a href="#">
                            <i class="las la-book-open"></i>
                            <span class="link_name">Subject</span>
                        </a>
                            <i class="las la-angle-down arrow"></i>
                    </div>    
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/createCourses.php" class="las la-plus">Add New Subject
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/viewCourses.php" class="las la-eye">View Subject
                                </a>
                            </li>
                        </ul>
                </li>
            </ul>
    </div>

    
    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                <span>Dashboard</span>
            </h2>

            <div class="user-wrapper">
                <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo BASE_URL; ?>assets/img/admin-icn.png" width="40px" height="40px" alt="">
                    <div class="user-name">
                        <h4><?php echo $fullName?></h4>
                        <small>
                            <?php
                                $query = mysqli_query($con,"SELECT * FROM tbladmin as a LEFT JOIN (SELECT Id, UserType FROM tbladmintype) as adt ON a.adminTypeId = adt.Id WHERE staffId='".$_SESSION['staffId']."'");
                                while ($row=mysqli_fetch_array($query)) { 
                            ?>
                            <?php echo $row['UserType'];?>
                            <?php }?>
                        </small>
                    </div>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>superAdmin/changePassword.php"><i class="las la-user-circle "></i> My Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>superadmin/logout.php"><i class="las la-sign-out-alt"></i>Logout</a></li>
                </ul>
            </div>
        </header>

        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1><?php echo $countAllStudent;?></h1>
                        <span>Previous Enrolled Students</span>
                    </div>
                    <div>
                        <span class=" las la-users"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1><?php echo $countAllStudent1;?></h1>
                        <span>Current Enrolled Students</span>
                    </div>
                    <div>
                        <span class=" las la-users"></span>
                    </div>
                </div>
            </div>
                      <br><br><br><br><br><br>              
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h3 align="center">
                            <marquee direction="left">Current Session: <?php 
                                $result = mysqli_query($con, 'SELECT (sessionName) AS sessname FROM tblsession WHERE isActive = 1'); 
                                $row = mysqli_fetch_assoc($result); 
                                $sum = $row['sessname'];
                                 echo $sum;
                            ?></marquee>
                        </h3>
                    </div>
                </div>
            </div>
        </main>
        <!-- FOOTER-->
        <footer>
            <div class="copyright" align="center" >
                &copy; Copyright <strong><span>MIES</span></strong>. All Rights Reserved
            </div>  
        </footer>
<!-- END OF FOOTER-->
    </div>
<!-- END OF BODY-->



<!-- SCRIPT-->
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

