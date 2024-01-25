
<?php
//added 
$query = mysqli_query($con,"SELECT * FROM tbladmin WHERE staffId='".$_SESSION['staffId']."'");
$row = mysqli_fetch_array($query);
$fullName = $row['fullName'];

?>

<input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="logo-details">
                <img src="../assets/img/logo.png" width="40px" height="40px">
                <span class="logo_name"> GRADING SYSTEM </span>
        </div>

            <ul class="nav-links">
                <li>
                    <a href="../teacher/index.php" class="<?php if($page=='dashboard'){ echo 'active'; }?>">
                        <i class="las la-arrow-left"></i>
                        <span class="link_name">Back</span>
                    </a>
                </li>    
                <li>
                    <a href="../teacher/advisee.php?viewId=<?php echo $_GET['viewId']; ?>&aId=<?php echo $_GET['aId']; ?>" class="<?php if($page=='grade_list'){ echo 'active'; }?>">
                        <i class="las la-book"></i>
                        <span class="link_name">Grade List</span>
                    </a>
                </li>
                <!--
                <li>
                    <div class="icon-link">
                        <a href="#" class="<?php if($page=='remarks'){ echo 'active'; }?>">
                            <i class="las la-comments"></i>
                            <span class="link_name">Remarks</span>
                        </a>    
                        <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <li> <a href="<?php echo BASE_URL; ?>teacher/remarks.php?period=1&viewId=<?php echo $_GET['viewId']; ?>"  class="las la-comment-dots"> 1st Grading Period</a></li>
                            <li> <a href="<?php echo BASE_URL; ?>teacher/remarks.php?period=2&viewId=<?php echo $_GET['viewId']; ?>"  class="las la-comment-dots"> 2nd Grading Period</a></li>
                            <li> <a href="<?php echo BASE_URL; ?>teacher/remarks.php?period=3&viewId=<?php echo $_GET['viewId']; ?>"  class="las la-comment-dots"> 3rd Grading Period</a></li>
                            <li> <a href="<?php echo BASE_URL; ?>teacher/remarks.php?period=4&viewId=<?php echo $_GET['viewId']; ?>"  class="las la-comment-dots"> 4th Grading Period</a></li>
                        </ul>
                </li>
                -->
                <li>
                    <a href="../teacher/promote.php?viewId=<?php echo $_GET['viewId']; ?>&aId=<?php echo $_GET['aId']; ?>" class="<?php if($page=='promote'){ echo 'active'; }?>">
                        <i class="las la-sort-numeric-up-alt"></i>
                        <span class="link_name">Promote Students</span>
                    </a>
                </li>
                <li class="<?php if($page=='performance'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#" >
                            <i class="las la-chart-bar"></i>
                            <span class="link_name">Proficiency Level</span>
                        </a>
                            <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <?php //added 
                                $query = mysqli_query($con,"SELECT f.Id as fload_id, s.subjectTitle,f.subjectId,f.sectionId FROM tblfacultyload as f LEFT JOIN (SELECT Id FROM tblsection) as sec ON f.sectionId = sec.Id LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as s ON f.subjectId = s.Id  WHERE f.sectionId = '".$_GET['viewId']."'  AND f.sessionId = '".$_SESSION['global_session']."'");
                                while ($row=mysqli_fetch_array($query)) {
                            ?>     
                            <li> <a href="../teacher/performance.php?viewId=<?php echo $row['fload_id']; ?>&period=1&aId=<?php echo $_GET['aId']; ?>"  class="lar la-chart-bar"> <?php echo $row['subjectTitle'];?></a></li>
                            <?php 
                                }//added end
                            ?>
                        </ul>
                </li>
               <!-- <li>
                    <a href="<?php echo BASE_URL; ?>teacher/createcard.php?viewId=<?php echo $_GET['viewId']; ?>" class="<?php if($page=='card'){ echo 'active'; }?>">
                        <i class="lar la-address-card"></i>
                        <span class="link_name">Create Student Card</span>
                    </a>
                </li>-->
                <li class="<?php if($page=='newstudent'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#" >
                            <i class="las la-user-graduate"></i>
                            <span class="link_name">Student</span>
                        </a>    
                        <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <li> <a href="../teacher/createstudent.php?viewId=<?php echo $_GET['viewId']; ?>&aId=<?php echo $_GET['aId']; ?>"  class="las la-plus"> Add New Student</a></li>
                            <li> <a href="../teacher/viewstudent.php?viewId=<?php echo $_GET['viewId']; ?>&aId=<?php echo $_GET['aId']; ?>"  class="las la-eye">View List of Student</a></li>
                            
                        </ul>
                </li>
            </ul>
    </div>