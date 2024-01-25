
<?php

$query = mysqli_query($con,"SELECT * FROM tbladmin WHERE staffId='".$_SESSION['staffId']."'");
$row = mysqli_fetch_array($query);
$fullName = $row['fullName'];
?>
<b>
<aside id="left-panel" class="left-panel" >
        <nav class="navbar navbar-expand-sm navbar-default" style="color: black;">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                <li class="menu-title">ADMIN: &nbsp;<?php echo $fullName;?><br> Staff Id: <?php echo $staffId;?></li>
                    <li class="<?php if($page=='dashboard'){ echo 'active'; }?>">
                        <a href="index.php"><i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
                    
                        <!-- <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Admin</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa fa-plus"></i><a href="createAdmin.php">Add Administrator</a></li>
                                <li><i class="fa fa-eye"></i><a href="viewAdmin.php">View Administrator</a></li>
                            </ul>
                        </li> 
                    <li class="<?php if($page=='user'){ echo 'active'; }?>">
                    <a href="createNewUser.php"><i class="menu-icon fa fa-plus"></i>Add New User</a>
                    </li>-->

                    <li class="menu-item-has-children dropdown <?php if($page=='session'){ echo 'active'; }?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Session</a>
                        <ul class="sub-menu children dropdown-menu" >
                            <li><i class="fa fa-plus"></i> <a href="<?php echo BASE_URL; ?>Superadmin/createSession.php" style="color: #187bcd;">Add New Session</a></li>
                           
                        </ul>
                    </li>
                   
                   <li class="menu-title">Faculty and Section</li>
                    <li class="menu-item-has-children dropdown <?php if($page=='faculty'){ echo 'active'; }?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Faculty</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-plus"></i> <a href="<?php echo BASE_URL; ?>Superadmin/createFaculty.php" style="color: #187bcd;">Add New Faculty</a></li>
                            <li><i class="fa fa-eye"></i> <a href="<?php echo BASE_URL; ?>Superadmin/viewFaculty.php" style="color: #187bcd;">View Faculty</a></li>
                            <li><i class="fa fa-book"></i> <a href="<?php echo BASE_URL; ?>Superadmin/facultyload.php" style="color: #187bcd;">Faculty Load</a></li>                        
                        </ul>
                    </li>
                    
                    <li class="menu-item-has-children dropdown <?php if($page=='department'){ echo 'active'; }?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-bars"></i>Section</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-plus"></i> <a href="<?php echo BASE_URL; ?>Superadmin/createDepartment.php" style="color: #187bcd;">Add New Section</a></li>
                            <li><i class="fa fa-eye"></i> <a href="<?php echo BASE_URL; ?>Superadmin/viewDepartment.php" style="color: #187bcd;">View Section</a></li>
                        </ul>
                    </li>

                    <li class="menu-title">Student and Subject</li>
                    <li class="menu-item-has-children dropdown <?php if($page=='student'){ echo 'active'; }?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-users"></i>Student</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-plus"></i> <a href="<?php echo BASE_URL; ?>Superadmin/createStudent.php" style="color: #187bcd;">Add New Student</a></li>
                            <li><i class="fa fa-eye"></i> <a href="<?php echo BASE_URL; ?>Superadmin/viewStudent.php" style="color: #187bcd;">View Student</a></li>
                        </ul>
                    </li>

                    

                     <li class="menu-item-has-children dropdown <?php if($page=='subject'){ echo 'active'; }?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Subject</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-plus"></i> <a href="<?php echo BASE_URL; ?>Superadmin/createCourses.php" style="color: #187bcd;">Add New Subject</a></li>
                            <li><i class="fa fa-eye"></i> <a href="<?php echo BASE_URL; ?>Superadmin/viewCourses.php" style="color: #187bcd;">View Subject</a></li>
                        </ul>
                    </li>
                    <li class="menu-title">Grading</li>
                      <li class="menu-item-has-children dropdown <?php if($page=='result'){ echo 'active'; }?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-file"></i>Computation</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-plus"></i> <a href="<?php echo BASE_URL; ?>Superadmin/studentList.php" style="color: #187bcd;">Compute GPA</a></li>
                          <!-- <li><i class="fa fa-plus"></i> <a href="Superadmin/studentList2.php" style="color: #187bcd;">Compute CGPA</a></li>
                            <li><i class="fa fa-plus"></i> <a href="studentList3.php">View/Print Result</a></li> -->                    
                            <li><i class="fa fa-plus"></i> <a href="<?php echo BASE_URL; ?>Superadmin/gradingCriteria.php" style="color: #187bcd;">View Grading Criteria</a></li>

                        </ul>
                    </li>

                   <!-- <li class="menu-title">Account</li>
                    <li class="menu-item-has-children dropdown <?php if($page=='profile'){ echo 'active'; }?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-user-circle"></i>Profile</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-key"></i> <a href="changePassword.php">Change Password</a></li>
                            <li><i class="menu-icon fa fa-user"></i> <a href="updateProfile.php">Update Profile</a></li>
                            </li>
                        </ul>
                         <li>
                        <a href="logout.php"> <i class="menu-icon fa fa-power-off"></i>Logout </a>
                    </li>
                    </li> -->
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside></b>