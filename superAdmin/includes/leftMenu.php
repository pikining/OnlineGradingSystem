
<?php

$query = mysqli_query($con,"SELECT * FROM tbladmin WHERE staffId='".$_SESSION['staffId']."'");
$row = mysqli_fetch_array($query);
$fullName = $row['fullName'];
?>

<input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="logo-details">
                <img src="../assets/img/logo.png" width="50px" height="50px">
                <span class="logo_name"> GRADING SYSTEM </span>
        </div>

            <ul class="nav-links">
                <li>
                    <a href="../superAdmin/index.php" class="<?php if($page=='dashboard'){ echo 'active'; }?>">
                        <i class="las la-home"></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../superAdmin/createSession.php" class="<?php if($page=='session'){ echo 'active'; }?>">
                        <i class="las la-cogs"></i>
                        <span class="link_name">School Year</span>
                    </a>
                </li>
                <li class="<?php if($page=='faculty'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#" >
                            <i class="las la-chalkboard-teacher"></i>
                            <span class="link_name">Faculty</span>
                        </a>    
                        <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <li >
                                <a href="../superAdmin/createFaculty.php" class="las la-plus ">Add New Faculty
                                </a>
                            </li>
                            <li>
                                <a href="../superAdmin/viewFaculty.php" class="las la-eye"> View Faculty
                                </a>
                            </li>
                            <li>
                                <a href="../superAdmin/facultyload.php" class="las la-book">Subject Handled
                                </a>
                            </li>
                        </ul>
                </li>
                <li class="<?php if($page=='student'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#" >
                            <i class="las la-user-graduate"></i>
                            <span class="link_name">Student</span>
                        </a>
                            <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                        <!--    <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/createStudent.php" class="las la-plus">Add New Student
                                </a>
                            </li>-->
                            <!--<li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/viewStudent.php" class="las la-eye">View Students
                                </a>
                            </li>-->
                            <li>
                                <a href="../superAdmin/listofgrade.php" class="las la-money-check"> Student's Card
                                </a>
                            </li>
                            <li>
                                <a href="../superAdmin/listoflevel.php" class="las la-chart-bar">Performance
                                </a>
                            </li>
                           <!-- <li>
                                <a href="<?php echo BASE_URL; ?>Superadmin/promotedstudents.php" class="las la-eye">Promoted Student
                                </a>
                            </li>-->
                        </ul>
                </li>
                <li class="<?php if($page=='section'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#" >
                            <i class="las la-list"></i>
                            <span class="link_name">Section</span>
                        </a>
                            <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <li>
                                <a href="../superAdmin/createDepartment.php" class="las la-plus">Add New Section
                                </a>
                            </li>
                            <li>
                                <a href="../superAdmin/viewDepartment.php" class="las la-eye">View Section
                                </a>
                            </li>
                            <li>
                                <a href="../superAdmin/createAdviser.php" class="las la-book-reader">Assign Adviser
                                </a>
                            </li>
                        </ul>
                </li>
                <li class="<?php if($page=='subject'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#">
                            <i class="las la-book-open"></i>
                            <span class="link_name">Subject</span>
                        </a>
                            <i class="las la-angle-down arrow"></i>
                    </div>    
                        <ul class="sub-menu">
                            <li>
                                <a href="../superAdmin/createCourses.php" class="las la-plus">Add New Subject
                                </a>
                            </li>
                            <li>
                                <a href="../superAdmin/viewCourses.php" class="las la-eye">View Subject
                                </a>
                            </li>
                        </ul>
                </li>
                <!--<li>
                    <a href="../superAdmin/resetpassword.php" class="<?php if($page=='password'){ echo 'active'; }?>">
                        <i class="las la-cogs"></i>
                        <span class="link_name">Passwords</span>
                    </a>
                </li>-->
            </ul>
    </div>

    